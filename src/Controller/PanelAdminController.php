<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\Pointage;
use App\Entity\Utilisateur;
use App\Entity\Cours;
use App\Form\RecherchePointageType;
use App\Form\RechercheAnomalieType;
use App\Form\RecherchePointagePeriodeType;
use App\Form\RechercheAnomaliePeriodeType;

use DateTimeImmutable;
date_default_timezone_set('Europe/Paris');

class PanelAdminController extends AbstractController
{
  public function panelAdmin(EntityManagerInterface $em, Request $request)
  {
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

    $countPointages = $em->getRepository(Pointage::class)->CountPointageByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeDePointage = $em->getRepository(Pointage::class)->findAllPointageByDate($em, $dateDebut, $dateFin);
    $countM1MIAGE = $em->getRepository(Utilisateur::class)->findCountEtudiantM1MIAGE($em);
    $countM2OSIE = $em->getRepository(Utilisateur::class)->findCountEtudiantM2OSIE($em);
    $countM2SIO = $em->getRepository(Utilisateur::class)->findCountEtudiantM2SIO($em);
    $countM2INE = $em->getRepository(Utilisateur::class)->findCountEtudiantM2INE($em);

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

    return $this->render('panelAdmin.html.twig', array('formPointage' => $formPointage->createView(),
                                                       'formAnomalie' => $formAnomalie->createView(),
                                                       'formPeriode' => $formPeriode->createView(),
                                                       'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                       'listeDePointage' => $listeDePointage,
                                                       'countM1MIAGE' => $countM1MIAGE,
                                                       'countM2OSIE' => $countM2OSIE,
                                                       'countM2SIO' => $countM2SIO,
                                                       'countM2INE' => $countM2INE,
                                                       'pointage' => $countPointages,
                                                       'retard' => $countRetard,
                                                       'avance' => $countDepartAvance,
                                                       'filtre' => $dateDebut));
  }
  public function coursListe(EntityManagerInterface $em, Request $request): Response
  {

  $session = $this->get('session');
  $user = $this->getUser();
  $teacherId = $user->getId();
  $idCours = $request->get('idCours');
  //dd($idCours);
  $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);

  $dateDebut = new \DateTime();
  $dateFin = new \DateTime();
  $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
  $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

  $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
  $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
  $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
  $listeCours = $em->getRepository(Cours::class)->findCoursListe($em);

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

  return $this->render('panelAdminCoursListeContenant.twig', array('formPointage' => $formPointage->createView(),
                                                      'formAnomalie' => $formAnomalie->createView(),
                                                      'formPeriode' => $formPeriode->createView(),
                                                      'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                      'listeCours' => $listeCours,
                                                      'pointage' => $countPointages,
                                                      'retard' => $countRetard,
                                                      'avance' => $countDepartAvance));
  }
  public function profsListe(EntityManagerInterface $em, Request $request): Response
  {

    $session = $this->get('session');
    $user = $this->getUser();
    $teacherId = $user->getId();
    $idCours = $request->get('idCours');
    //dd($idCours);
    $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
  
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));
  
    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeProfs = $em->getRepository(Utilisateur::class)->findProfsListe($em);
  
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
  
    return $this->render('panelAdminProfsListeContenant.twig', array('formPointage' => $formPointage->createView(),
                                                        'formAnomalie' => $formAnomalie->createView(),
                                                        'formPeriode' => $formPeriode->createView(),
                                                        'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                        'listeProfs' => $listeProfs,
                                                        'pointage' => $countPointages,
                                                        'retard' => $countRetard,
                                                        'avance' => $countDepartAvance));
  }

  public function etudiantsListe(EntityManagerInterface $em, Request $request): Response
  {

    $session = $this->get('session');
    $user = $this->getUser();
    $teacherId = $user->getId();
    $idCours = $request->get('idCours');
    //dd($idCours);
    $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
  
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));
  
    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeEtudiants = $em->getRepository(Utilisateur::class)->findEtudiantsListe($em);
  
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
  
    return $this->render('panelAdminEtudiantsListeContenant.twig', array('formPointage' => $formPointage->createView(),
                                                        'formAnomalie' => $formAnomalie->createView(),
                                                        'formPeriode' => $formPeriode->createView(),
                                                        'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                        'listeEtudiants' => $listeEtudiants,
                                                        'pointage' => $countPointages,
                                                        'retard' => $countRetard,
                                                        'avance' => $countDepartAvance));
  }
  public function adminEtudiantsEtProfsParCours(EntityManagerInterface $em, Request $request): Response
  {

      $session = $this->get('session');
      $user = $this->getUser();
      $idCours = $request->get('idCours');
      //dd($idCours);
      $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
    
      $dateDebut = new \DateTime();
      $dateFin = new \DateTime();
      $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
      $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));
    
      $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
      $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
      $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
      $nomCours = $em->getRepository(Cours::class)->findNomDuCours($em, $idCours);
      $EtudiantsParCours = $em->getRepository(Cours::class)->findEtudiantsParCours($em, $idCours);
      $ProfsParCours = $em->getRepository(Cours::class)->findProfsParCours($em, $idCours);
      
      
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
    
      return $this->render('panelAdminCoursListeContenantEPPC.twig', array('formPointage' => $formPointage->createView(),
                                                          'formAnomalie' => $formAnomalie->createView(),
                                                          'formPeriode' => $formPeriode->createView(),
                                                          'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                          'nomCours' => $nomCours,
                                                          'EtudiantsParCours' => $EtudiantsParCours,
                                                          'ProfsParCours' => $ProfsParCours,
                                                          'pointage' => $countPointages,
                                                          'retard' => $countRetard,
                                                          'avance' => $countDepartAvance));
      }

    public function adminCoursParProf(EntityManagerInterface $em, Request $request): Response
    {
        $session = $this->get('session');
        $user = $this->getUser();
        $idProf = $request->get('idProf');
        //dd($idCours);
        $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
      
        $dateDebut = new \DateTime();
        $dateFin = new \DateTime();
        $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
        $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));
      
        $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
        $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
        $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
        $CoursParProf = $em->getRepository(Cours::class)->findCoursParProf($em, $idProf);
        
        
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
      
        return $this->render('panelAdminCoursListeCoursParProfContenant.twig', array('formPointage' => $formPointage->createView(),
                                                            'formAnomalie' => $formAnomalie->createView(),
                                                            'formPeriode' => $formPeriode->createView(),
                                                            'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                            'CoursParProf' => $CoursParProf,
                                                            'pointage' => $countPointages,
                                                            'retard' => $countRetard,
                                                            'avance' => $countDepartAvance));
          }


    public function adminCoursParEtudiant(EntityManagerInterface $em, Request $request): Response
    {
    $session = $this->get('session');
    $user = $this->getUser();
    $idEtudiant = $request->get('idEtudiant');
    //dd($idCours);
    $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
  
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));
  
    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $CoursParEtudiant = $em->getRepository(Cours::class)->findCoursParEtudiant($em, $idEtudiant);
     
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
  
    return $this->render('panelAdminCoursParEtudiantContenant.twig', array('formPointage' => $formPointage->createView(),
                                                        'formAnomalie' => $formAnomalie->createView(),
                                                        'formPeriode' => $formPeriode->createView(),
                                                        'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                        'CoursParEtudiant' => $CoursParEtudiant,
                                                        'pointage' => $countPointages,
                                                        'retard' => $countRetard,
                                                        'avance' => $countDepartAvance));
    }
        
}
