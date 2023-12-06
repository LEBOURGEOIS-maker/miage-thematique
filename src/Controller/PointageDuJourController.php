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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Pointage;
use App\Entity\Formation;
use App\Entity\Cours;
use App\Entity\Utilisateur;
use App\Form\Pointage2Type;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

date_default_timezone_set('Europe/Paris');

class PointageDuJourController extends AbstractController
{
	public function show(EntityManagerInterface $em) : Response
	{
			$listeDePointage = $em->getRepository(Pointage::class)->AdminfindAll($em);
			return $this->render('pointageDuJour.html.twig', array(
			'listeDePointage' => $listeDePointage,
			'filtre' => false
			));
	}

	public function showBetweenTwoDates(Request $request, EntityManagerInterface $em) : Response
	{
		$dateDebut = $request->request->get('dateDebut');
		$dateFin = $request->request->get('dateFin');
		//dump($dateDebut." ".$dateFin);
		$listeDePointage = $em->getRepository(Pointage::class)->AdminFindBetweenTwoDates($em, $dateDebut, $dateFin);
		return $this->render('pointageDuJour.html.twig', array(
		'listeDePointage' => $listeDePointage,
		'filtre' => true
		));
	}

	public function validerPointage(Request $request, EntityManagerInterface $em, int $id) : Response
	{
			dump($id);
			$pointage = new Pointage();
			$em = $this->getDoctrine()->getManager();
			$pointage = $em->getRepository(Pointage::class)->find($id);

      if (null === $pointage) {
          throw new NotFoundHttpException();
      }
			// on extrait la date du pointage d'entrée
			$date = date_format(($pointage->getDatePointageEntree()), 'Y-m-d');
			//dump($date);

			// on récupère l'heure de fin de la plage horaire
			//dump($pointage->getPlageHoraire()->getPlageHoraire());
			$fin = explode("-", $pointage->getPlageHoraire()->getPlageHoraire(), 2);
      $hfin = intval($fin[1]);

			// on convertit l'ensemble en datetime
			$ndate = new \DateTime($date.' '.$hfin.':00:00');
			//dump($ndate);
			//dump($pointage);
			$pointage->setDatePointageSortie($ndate);
			$pointage->setPointeParAdmin(true);
			$em->flush();

			$request->getSession()
                ->getFlashBag()
                ->add('notice', 'success');
            $referer = $request->headers->get('referer');
      return $this->redirect($referer);
	}

	public function editPointage(Request $request, Pointage $pointage): Response
	{
			$form = $this->createForm(Pointage2Type::class, $pointage);
			$form->handleRequest($request);

			if ($form->isSubmitted() && $form->isValid()) {
					$this->getDoctrine()->getManager()->flush();

					return $this->redirectToRoute('pointageDuJour');
			}

			return $this->render('pointage/edit.html.twig', [
					'$pointage' => $pointage,
					'form' => $form->createView(),
			]);
	}

}
