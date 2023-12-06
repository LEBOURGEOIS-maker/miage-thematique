<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Pointage;
use App\Entity\PlageHoraire;
use App\Entity\Utilisateur;
use App\Entity\AbsencesJustifications;

use App\Form\RecherchePointageType;
use App\Form\RechercheAnomalieType;
use App\Form\RecherchePointagePeriodeType;
use App\Form\RechercheAnomaliePeriodeType;
use App\Form\JustificationsAbsences;
use App\Form\PointageNullType;
use App\Form\PointageDeSortieType;

use DateTimeImmutable;

class PanelEtudiantController extends AbstractController
{
  public function panelEtudiant()
  {
    $user = $this->getUser();
    $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
    $idPointage = $this->getDoctrine()->getRepository(Pointage::class)->findPointageSortieByEtudiant($utilisateurEtudiant);
    if($idPointage != null){
      $pointageExistant = $this->getDoctrine()->getRepository(Pointage::class)->find($idPointage[0]);
      $cours = $pointageExistant->getCours();
      return $this->render('panelEtudiant.html.twig', array('message' => 'Vous avez pointé en entrée de cours :', 'cours' => $cours, 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur()));
    } else {
      return $this->render('panelEtudiant.html.twig', array('message' => 'Vous n\'avez pas de pointage pour le moment', 'cours' =>'', 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur()));
    }
  }
  public function showPointageWeek(EntityManagerInterface $em)
  {
    $user = $this->getUser();
    $date = new \DateTime();
    $dateFinSemaine = new \DateTime();
    $date = $date->setTimestamp(strtotime('monday this week'));
    $dateFinSemaine = $dateFinSemaine->setTimestamp(strtotime('sunday this week'));
    $listeDePointage = $em->getRepository(Pointage::class)->findPointageByWeek($em, $user , $date, $dateFinSemaine);
    //{Conversion duree et retard en H/m et cumul des heures et des retards sur la semaine
    $cumulHeure = array('heures'=>0, 'minutes'=>0, 'secondes'=>0);
    $cumulRetard = array('heures'=>0, 'minutes'=>0, 'secondes'=>0);
    foreach ($listeDePointage as &$value) {
      $heurePointage = intval($value['dureePointage']/3600);
      $minutesPointage = intval(($value['dureePointage']%3600)/60);
      $secondesPointage = intval(($value['dureePointage']%3600)%60);
      $heureRetard = intval($value['retard']/3600);
      $minutesRetard = intval(($value['retard']%3600)/60);
      $secondesRetard = intval(($value['retard']%3600)%60);
      $cumulHeure = $this->additionHeures($cumulHeure, $heurePointage, $minutesPointage, $secondesPointage);
      $cumulRetard = $this->additionHeures($cumulRetard, $heureRetard, $minutesRetard, $secondesRetard);
    }
    return $this->render('pointageSemaine.html.twig', array('listeDePointage' => $listeDePointage, 'compteurHeureSemaine'=> $cumulHeure, 'compteurRetardSemaine' => $cumulRetard, 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur())); 
  }
  public function showPointageTotaux(EntityManagerInterface $em)
  {
    $user = $this->getUser();
    $date = new \DateTime();
    $dateFinSemaine = new \DateTime();
    $date = $date->setTimestamp(strtotime('monday this week'));
    $dateFinSemaine = $dateFinSemaine->setTimestamp(strtotime('sunday this week'));
    $listeDePointage = $em->getRepository(Pointage::class)->findPointageTotaux($em, $user);
    //{Conversion duree et retard en H/m et cumul des heures et des retards sur la semaine
    $cumulHeure = array('heures'=>0, 'minutes'=>0, 'secondes'=>0);
    $cumulRetard = array('heures'=>0, 'minutes'=>0, 'secondes'=>0);
    return $this->render('panelEtudiantPointageTotaux.html.twig', array('listeDePointage' => $listeDePointage, 'compteurHeureSemaine'=> $cumulHeure, 'compteurRetardSemaine' => $cumulRetard, 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur())); 
  } 
  public function justificationAbsence(Request $request, EntityManagerInterface $em): Response
  {
    $session = $this->get('session');
    $user = $this->getUser();
    $absenceJustif = new AbsencesJustifications();

    $formation = $user->getFormation();

    $form = $this->createForm(JustificationsAbsences::class, $absenceJustif, ['formation' => $formation]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $absenceJustif = $form->getData();
      $lienFichier = $form->get('lienFichier')->getData();
      $dateDebut = $form->get('dateDebut')->getData();
      $dateFin = $form->get('dateFin')->getData();
      $heureDebut = $form->get('heureDebut')->getData();
      $heureFin = $form->get('heureFin')->getData();

      if ($lienFichier) {
        $originalFilename = pathinfo($lienFichier->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$lienFichier->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $lienFichier->move(
                $this->getParameter('justifications_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $absenceJustif->setLienFichier($newFilename);
    }
      $id = $user->getId();
      $valider= 0;
      $absenceJustif->setUtilisateurEtudiant($user);  
      $absenceJustif->setFormation($formation);
      $absenceJustif->setDateDebut($dateDebut);
      $absenceJustif->setDateFin($dateFin);
      $absenceJustif->setHeureDebut($heureDebut);
      $absenceJustif->setHeureFin($heureFin);
      $absenceJustif->setValider($valider);
      $absenceJustif->setDate();

      $em = $this->getDoctrine()->getManager();
      $em->persist($absenceJustif);
      $em->flush();

      return $this->redirectToRoute('justificationSuccess');
    }
    return $this->render('panelEtudiantJustifierAbsence.twig', [
        'nom' => $user->getNomUtilisateur(),
        'prenom' => $user->getPrenomUtilisateur(),
        'form'=>$form->createView(),
    ]); 
  }
  public function justificationSuccess()
  {
    $user = $this->getUser();
    $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
    $idPointage = $this->getDoctrine()->getRepository(Pointage::class)->findPointageSortieByEtudiant($utilisateurEtudiant);
    if($idPointage != null){
      $pointageExistant = $this->getDoctrine()->getRepository(Pointage::class)->find($idPointage[0]);
      $cours = $pointageExistant->getCours();
      return $this->render('panelEtudiantJustifierAbsenceSubmitted.twig', array('message' => 'Vous avez pointé en entrée de cours :', 'cours' => $cours, 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur()));
    } else {
      return $this->render('panelEtudiantJustifierAbsenceSubmitted.twig', array('message' => 'Vous n\'avez pas de pointage pour le moment', 'cours' =>'', 'prenom' => $user->getPrenomUtilisateur(), 'nom' => $user->getNomUtilisateur()));
    }
  }
  public function listejustificationsAbs(EntityManagerInterface $em, Request $request): Response
  {
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

    $session = $this->get('session');
    $user = $this->getUser();
    $studentId = $user->getId();
    
    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeDePointage = $em->getRepository(AbsencesJustifications::class)->findStudentJustifiedAbs($em, $studentId);

    $formPointage=$this->createForm(RecherchePointageType::class);
    $formAnomalie=$this->createForm(RechercheAnomalieType::class);
    $formPeriode=$this->createForm(RecherchePointagePeriodeType::class);
    $formPeriodeAnomalie=$this->createForm(RechercheAnomaliePeriodeType::class);
    $formPointage->handleRequest($request);
    $formAnomalie->handleRequest($request);
    $formPeriode->handleRequest($request);
    $formPeriodeAnomalie->handleRequest($request);

    if ($formPointage->isSubmitted()) {
      $dateDebutCustom = date_create();
      date_isodate_set($dateDebutCustom, $formPointage['annee']->getData(), $formPointage['semaine']->getData(), 1);
      $dateFinCustom = date_create();
      date_isodate_set($dateFinCustom, $formPointage['annee']->getData(), $formPointage['semaine']->getData(), 7);
      return $this->redirectToRoute('panelAdminSemaine', array('dateD' => $dateDebutCustom->format('Y.m.d'), 'dateF' => $dateFinCustom->format('Y.m.d')));
    } else if ($formAnomalie->isSubmitted()) {
      $dateDebutCustom = date_create();
      date_isodate_set($dateDebutCustom, $formAnomalie['annee']->getData(), $formAnomalie['semaine']->getData(), 1);
      $dateFinCustom = date_create();
      date_isodate_set($dateFinCustom, $formAnomalie['annee']->getData(), $formAnomalie['semaine']->getData(), 7);
      return $this->redirectToRoute('panelAdminSemaineAnomalie', array('dateD' => $dateDebutCustom->format('Y.m.d'), 'dateF' => $dateFinCustom->format('Y.m.d')));
    } else if ($formPeriode->isSubmitted() && $formPeriode->isValid()) {
      $periode = $formPeriode['periode']->getData();
      $periode = str_replace('/', '.', $periode);
      $dates = explode("-", $periode);
      return $this->redirectToRoute('panelAdminPeriode', array('dateD' => $dates[0], 'dateF' => $dates[1]));
    } else if ($formPeriodeAnomalie->isSubmitted() && $formPeriodeAnomalie->isValid()) {
      $periode = $formPeriodeAnomalie['periode']->getData();
      $periode = str_replace('/', '.', $periode);
      $dates = explode("-", $periode);
      return $this->redirectToRoute('panelAdminPeriodeAnomalie', array('dateD' => $dates[0], 'dateF' => $dates[1]));
    }

    return $this->render('panelEtudiantJustificationsAbsences.html.twig', array('formPointage' => $formPointage->createView(),
                                                        'formAnomalie' => $formAnomalie->createView(),
                                                        'formPeriode' => $formPeriode->createView(),
                                                        'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                        'listeDePointage' => $listeDePointage,
                                                        'pointage' => $countPointages,
                                                        'retard' => $countRetard,
                                                        'avance' => $countDepartAvance));
  }
  private function additionHeures($tab, $h, $m, $s){
    $tab['heures'] = $tab['heures']+$h;
    if($tab['minutes']+$m > 60){
      $tab['minutes']=$tab['minutes']+$m-60;
      $tab['heures']= $tab['heures']+1;
    }else{
      $tab['minutes']=$tab['minutes']+$m;
    }
    if($tab['secondes']+$s > 60){
      $tab['secondes']=$tab['secondes']+$s-60;
      $tab['minutes']= $tab['minutes']+1;
    }else{
      $tab['secondes']=$tab['secondes']+$s;
    }
    return $tab;
  }
  // Fonction pour additioner les heures effectuées sur la semaine par l'étudiant
    // private function recupHeures($listePointage){
    //   $cumulHeure = array('heures'=>0, 'minutes'=>0, 'secondes'=>0);
    //   foreach ($listePointage as &$value) {
    //     $temps = date_diff($value['datePointageEntree'], $value['datePointageSortie']);
    //     $heures = intval($temps->format('%H'));
    //     $minutes = intval($temps->format('%I'));
    //     $secondes = intval($temps->format('%S'));
    //     $cumulHeure = $this->additionHeures($cumulHeure, $heures, $minutes, $secondes);
    //   }
    //   return $cumulHeure;
    // }

    //switch pour toujours partir de lundi et finir à samedi quelque soit le jour de visualisation des pointages
    // $jour = date('w');
    // switch($jour){
    //   case 1:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d'), date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+6, date('Y')));
    //     break;
    //   case 2:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-1, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+5, date('Y')));
    //     break;
    //   case 3:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-2, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+4, date('Y')));
    //     break;
    //   case 4:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-3, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+3, date('Y')));
    //     break;
    //   case 5:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-4, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+2, date('Y')));
    //     break;
    //   case 6:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-5, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')+1, date('Y')));
    //     break;
    //   case 0:
    //     $date = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d')-6, date('Y')));
    //     $dateFinSemaine = date('Y-m-d',mktime(0 ,0 ,0 , date('m'), date('d'), date('Y')));
    //     break;
    // }
}
