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
use App\Form\RecherchePointageType;
use App\Form\RechercheAnomalieType;
use App\Form\RecherchePointagePeriodeType;
use App\Form\RechercheAnomaliePeriodeType;

use DateTimeImmutable;
date_default_timezone_set('Europe/Paris');

class PanelAdminPointageController extends AbstractController
{
  public function panelAdminPointage(EntityManagerInterface $em, Request $request)
  {
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeDePointage = $em->getRepository(Pointage::class)->findAllAnomalieByDate($em, $dateDebut, $dateFin);

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

    return $this->render('panelAdminPointage.html.twig', array('formPointage' => $formPointage->createView(),
                                                       'formAnomalie' => $formAnomalie->createView(),
                                                       'formPeriode' => $formPeriode->createView(),
                                                       'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                       'listeDePointage' => $listeDePointage,
                                                       'pointage' => $countPointages,
                                                       'retard' => $countRetard,
                                                       'avance' => $countDepartAvance));
  }
}
