<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use DoctrineExtensions\Query\Mysql\Week;

use App\Entity\Pointage;
use App\Entity\Formation;
use App\Entity\Cours;
use App\Entity\Utilisateur;

date_default_timezone_set('Europe/Paris');


/*
ALGO

Rapport du jour 		-	OK
Rapport de la semaine 	-	OK
	Récupérer la date du jour
	Récupérer le jour de la date (Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi, Dimanche)
	CAS
		Lundi		:	DateDebut = DateDuJour, DateFin = DateDuJour+6
		Mardi		:	DateDebut = DateDuJour-1, DateFin = DateDuJour+5
		Mercredi	:	DateDebut = DateDuJour-2, DateFin = DateDuJour+4
		Jeudi		:	DateDebut = DateDuJour-3, DateFin = DateDuJour+3
		Vendredi	:	DateDebut = DateDuJour-4, DateFin = DateDuJour+2
		Samedi		:	DateDebut = DateDuJour-5, DateFin = DateDuJour+1
		Dimanche	:	DateDebut = DateDuJour-6, DateFin = DateDuJour

Rapport du mois			-	OK
	Récupérer la date du jour
	DateDebut = Mettre 01 en jour de de la date
	DateFin = Mettre le dernier jour du mois de la date

Rapport annuel			-	A DEV
	Récupérer la date du jour
	SI avant septembre :
		DateDebut = 01/09/AnnéeEnCours-1
		DateFin = 31/07/AnnéeEnCours
	SINON :
		DateDebut = 01/09/AnnéeEnCours
		DateFin = 31/07/AnnéeEnCours+1
	FIN SI

*/


class PointageViewerController extends AbstractController
{
	public function show(EntityManagerInterface $em) : Response
	{
			return $this->render('pointageViewer.html.twig', array(
			'listeDePointage' => null
			));
	}

	public function showBetweenTwoDates(Request $request, EntityManagerInterface $em) : Response
	{
		$dateDebut = $request->request->get('dateDebut');
		$dateFin = $request->request->get('dateFin');
		//dump($dateDebut." ".$dateFin);
		$listeDePointage = $em->getRepository(Pointage::class)->AdminFindBetweenTwoDates($em, $dateDebut, $dateFin);
		return $this->render('pointageViewer.html.twig', array(
		'listeDePointage' => $listeDePointage
		));
	}

	public function showRapportDuJour(EntityManagerInterface $em) : Response
	{
		$date = new \DateTime();
		//dump($dateDebut." ".$dateFin);
		if(!$date)
		{
			$listeDePointage = $em->getRepository(Pointage::class)->AdminFindByDay($em, $date);
		}
		else
		{
			$listeDePointage = null;
		}
		return $this->render('pointageViewerRapportDuJour.html.twig', array(
		'listeDePointage' => $listeDePointage
		));
	}

	public function showRapportDeSemaine(EntityManagerInterface $em) : Response
	{
		$dateDebutActuelle = new \DateTime();
		$dateFinActuelle = new \DateTime();
		$jour = $dateDebutActuelle->format('D');
		//dump("Jour actuel : ".$jour);
		switch($jour)
		{
			case "Mon":
				//dump("Passé à Mon");
				$dateDebut = $dateDebutActuelle;
				$dateFin = $dateFinActuelle->modify('+6 day');
				break;
			case "Tue":
				//dump("Passé à Tue");
				$dateDebut = $dateDebutActuelle->modify('-1 day');
				$dateFin = $dateFinActuelle->modify('+5 day');
				break;
			case "Wed":
				//dump("Passé à Wed");
				$dateDebut = $dateDebutActuelle->modify('-2 day');
				$dateFin = $dateFinActuelle->modify('+4 day');
				break;
			case "Thu":
				//dump("Passé à Thu");
				$dateDebut = $dateDebutActuelle->modify('-3 day');
				$dateFin = $dateFinActuelle->modify('+3 day');
				break;
			case "Fri":
				$dateDebut = $dateDebutActuelle->modify('-4 day');
				$dateFin = $dateFinActuelle->modify('+2 day');
				break;
			case "Sat":
				$dateDebut = $dateDebutActuelle->modify('-5 day');
				$dateFin = $dateFinActuelle->modify('+1 day');
				break;
			case "Sun":
				$dateDebut = $dateDebutActuelle->modify('-6 day');
				$dateFin = $dateFinActuelle;
				break;
		}
		//dump(date_format($dateDebut,"Y-m-d")." jusqu'à ".date_format($dateFin,"Y-m-d"));
		if(!$dateDebut && !$dateFin)
		{
			$listeDePointage = $em->getRepository(Pointage::class)->AdminFindBetweenTwoDates($em, date_format($dateDebut,"Y-m-d"), date_format($dateFin,"Y-m-d"));
		}
		else
		{
			$listeDePointage = null;
		}
		return $this->render('pointageViewerRapportDeSemaine.html.twig', array(
		'listeDePointage' => $listeDePointage
		));
	}

	public function showRapportDeMois(EntityManagerInterface $em) : Response
	{
		$dateDebutActuelle = new \DateTime();
		$dateFinActuelle = new \DateTime();
		$lastDayOfTheMonth = date('t',strtotime('today'));
		$dateDebut = new \DateTime($dateDebutActuelle->format('Y-m')."-01");
		$dateFin = new \DateTime($dateFinActuelle->format('Y-m')."-".$lastDayOfTheMonth);
		//dump(date_format($dateDebut,"Y-m-d"));
		//dump(date_format($dateFin,"Y-m-d"));
		//dump(date_format($dateDebut,"Y-m-d")." jusqu'à ".date_format($dateFin,"Y-m-d"));
		if(!$dateDebut && !$dateFin)
		{
			$listeDePointage = $em->getRepository(Pointage::class)->AdminFindBetweenTwoDates($em, date_format($dateDebut,"Y-m-d"), date_format($dateFin,"Y-m-d"));
		}
		else
		{
			$listeDePointage = null;
		}
		return $this->render('pointageViewerRapportDeMois.html.twig', array(
		'listeDePointage' => $listeDePointage
		));
	}


	public function showRapportDeAnnée(EntityManagerInterface $em) : Response
	{
		$dateDebutActuelle = new \DateTime();
		$dateFinActuelle = new \DateTime();
		$mois = $dateDebutActuelle->format('m');
		//dump($mois);
		if($mois<'09')
		{
				$dateDebut = new \DateTime(($dateDebutActuelle->format('Y')-1)."-09-01");
				//DateFin = 31/07/AnnéeEnCours
				$dateFin = new \DateTime($dateFinActuelle->format('Y')."-07-31");
		} else {
				//DateDebut = 01/09/AnnéeEnCours
				$dateDebut = new \DateTime(($dateDebutActuelle->format('Y'))."-09-01");
				//DateFin = 31/07/AnnéeEnCours+1
				$dateFin = new \DateTime(($dateFinActuelle->format('Y')+1)."-07-31");
		}
		dump(date_format($dateDebut,"Y-m-d")." jusqu'à ".date_format($dateFin,"Y-m-d"));
		$listeDePointage = $em->getRepository(Pointage::class)->AdminFindBetweenTwoDates($em, date_format($dateDebut,"Y-m-d"), date_format($dateFin,"Y-m-d"));
		return $this->render('pointageViewerRapportDeAnnée.html.twig', array(
		'listeDePointage' => $listeDePointage
		));
	}
}
