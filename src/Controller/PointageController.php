<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\Pointage;
use App\Entity\Utilisateur;
use App\Entity\PlageHoraire;

use App\Form\PointageType;
use App\Form\PointageNullType;
use App\Form\PointageDeSortieType;

use DateTimeImmutable;

date_default_timezone_set('Europe/Paris');

class PointageController extends AbstractController
{
  public function show(Request $request, EntityManagerInterface $em): Response
  {
    //$session = $this->get('session');
    $user = $this->getUser();
    $pointage = new Pointage();
    //$user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
    $idPointage = $this->getDoctrine()->getRepository(Pointage::class)->findPointageSortieByEtudiant($user);
    $idPointageNull = $this->getDoctrine()->getRepository(Pointage::class)->findByPointageByEtudiant($user);

    if($idPointage != null)
    {
      $pointageExistant = $this->getDoctrine()->getRepository(Pointage::class)->find($idPointage[0]);
      $cours = $pointageExistant->getCours();
      $form =$this->createForm(PointageDeSortieType::class, $pointageExistant);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $pointageExistant->setDatePointageSortie(new \DateTime());
        $heureDebut = $pointageExistant->getDatePointageEntree();
        $heureFin = $pointageExistant->getDatePointageSortie();
        $dureeDuPointage = $heureDebut->diff($heureFin);
        if($heureDebut->format("d") == $heureFin->format("d"))
        {
          if($dureeDuPointage->format("%H")< $pointageExistant->getPlageHoraire()->getDureePlage() && !strstr($pointageExistant->getCours()->getNomUe(), "Travail Personnel"))
          {
            $pointageExistant->setPartiEnAvance(true);
          }
        }
        $date = new \DateTime();
        $dureePointageReglementaire = $this->conversionDureePointage($date->setTimestamp(mktime($pointageExistant->getPlageHoraire()->getDureePlage(), 0, 0)));
        $duree = $this->conversionDureePointage($dureeDuPointage);
        if($duree > $dureePointageReglementaire+900)
        {
          $pointageExistant->setDureePointage($pointageExistant->getPlageHoraire()->getDureePlage() * 3600);
        }
        else
        {
          $pointageExistant->setDureePointage($duree);
        }
        $pointageExistant->setAbsence(false);
        $pointageExistant->setDepartJustifie(false);
        $pointageExistant->setAbsenceJustifie(false);
        $em->flush();

        return $this->redirectToRoute('panelEtudiant');

      }
      return $this->render('pointageDeSortie.html.twig', [
          'nom' => $user->getNomUtilisateur(),
          'prenom' => $user->getPrenomUtilisateur(),
          'cours' => $cours->getNomUe(),
          'form'=>$form->createView(),
      ]);
    }
    elseif ($idPointageNull != null)
    {
      $formation = $user->getFormation();

      $form = $this->createForm(PointageNullType::class, $pointage, ['formation' => $formation]);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // $pointage = $form->getData();
        $cours = $form['cours']->getData()->getNomUe();
        $idPointageNull = $this->getDoctrine()->getRepository(Pointage::class)->findPointageByEtudiantAndCours($user, $form['cours']->getData());
        //$plageHoraire = $form['plageHoraire']->getData()->getPlageHoraire();
        if($idPointageNull == null)
        {
          throw $this->createNotFoundException('Vous n\'avez pas ce cours aujourd\'hui');
        }
        $pointage = $this->getDoctrine()->getRepository(Pointage::class)->find($idPointageNull[0]);
        $plageHoraire = $pointage->getPlageHoraire()->getPlageHoraire();
        $tab = explode("h", $plageHoraire, 2);
        $pointageTemporaire = new \DateTime();
        if($tab[0] > $pointageTemporaire->format("H") && 0-$pointageTemporaire->format("i") > -55)
        {
          $date = new \DateTime();
          $date = $date->setTimestamp(mktime($pointageTemporaire->format("H") ,55 ,0));
          $pointage->setDatePointageEntree($date);
        }else{
          $pointage->setDatePointageEntree($pointageTemporaire);
        }
        $pointage->setFormation($formation);
        $pointage->setRetard($this->calculRetard($plageHoraire, $pointage->getDatePointageEntree(), $cours));
        $pointage->setPointeParAdmin(false);
        $pointage->setPartiEnAvance(false);
        $pointage->setDureePointage(0);
        $pointage->setAbsence(false);
        $pointage->setDepartJustifie(false);
        $pointage->setAbsenceJustifie(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($pointage);
        $em->flush();

        return $this->redirectToRoute('panelEtudiant');
      }
      return $this->render('pointageNull.html.twig', [
          'nom' => $user->getNomUtilisateur(),
          'prenom' => $user->getPrenomUtilisateur(),
          'form'=>$form->createView(),
      ]);
    }
    else //Pointage dont le cours n'apparait pas dans l'emploi du temps Celcat (Travail Perso)
    {
      $formation = $user->getFormation();

      $form = $this->createForm(PointageType::class, $pointage, ['formation' => $formation]);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $pointage = $form->getData();
        $cours = $form['cours']->getData()->getNomUe();
        $plageHoraire = $form['plageHoraire']->getData()->getPlageHoraire();
        $tab = explode("h", $plageHoraire, 2);
        $pointageTemporaire = new \DateTime();
        if($tab[0] > $pointageTemporaire->format("H") && 0-$pointageTemporaire->format("i") > -55)
        {
          $date = new \DateTime();
          $date = $date->setTimestamp(mktime($pointageTemporaire->format("H") ,55 ,0));
          $pointage->setDatePointageEntree($date);
        }else{
          $pointage->setDatePointageEntree($pointageTemporaire);
        }
        $pointage->setFormation($formation);
        $pointage->setRetard($this->calculRetard($plageHoraire, $pointage->getDatePointageEntree(), $cours));
        $pointage->setPointeParAdmin(false);
        $pointage->setPartiEnAvance(false);
        $pointage->setDureePointage(0);
        $pointage->setAbsence(false);
        $pointage->setDepartJustifie(false);
        $pointage->setAbsenceJustifie(false);
        $pointage->setUtilisateurEtudiant($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($pointage);
        $em->flush();

        return $this->redirectToRoute('panelEtudiant');
      }
      return $this->render('pointage.html.twig', [
          'nom' => $user->getNomUtilisateur(),
          'prenom' => $user->getPrenomUtilisateur(),
          'form'=>$form->createView(),
      ]);
    }
  }

  //Fonction pour calculer le retard
  private function calculRetard($ph, $hpointage, $cours)
  {
    if(strstr($cours, "Travail Personnel"))
    {
      return 0;
    }
    else {
      $tab = explode("h", $ph, 2);
      $heureDebut = intval($tab[0]);
      $heure = $hpointage->format("H");
      $minute = $hpointage->format("i");
      $secondes = $hpointage->format("s");
      if($heure-$heureDebut <0 || $minute <0)
      {
        return 0;
      }else {
        $total = (($heure-$heureDebut)*3600 + ($minute*60) + $secondes);
        return $total;
      }
    }
  }

  //Fonction pour additioner les heures effectuées sur la semaine par l'étudiant
  private function conversionDureePointage($dp){
    $heures = intval($dp->format('%H'))*3600;
    $minutes = intval($dp->format('%I'))*60;
    $secondes = intval($dp->format('%S'));
    $total = $heures + $minutes + $secondes;
    return $total;
  }
}
