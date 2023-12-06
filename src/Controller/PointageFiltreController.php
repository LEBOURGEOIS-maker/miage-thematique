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
use App\Form\PointageFiltreType;

use App\Entity\Pointage;
use App\Entity\Formation;
use App\Entity\Cours;
use App\Entity\Utilisateur;

date_default_timezone_set('Europe/Paris');

class PointageFiltreController extends AbstractController
{
			public function create(Request $request, EntityManagerInterface $em)
			{

						$listeformation = $em->getRepository(Formation::class)->findAll();
						dump($listeformation);
						$formation = new Formation();
						$form = $this->createForm(PointageFiltreType::class, null, ['formations' => $listeformation]);
						$form->handleRequest($request);
						// if ($form->isSubmitted() && $form->isValid()) {
						// 		// ... save the meetup, redirect etc.
						// }
						//
						// return $this->render(
						// 		'meetup/create.html.twig',
						// 		['form' => $form->createView()]
						// );

						if ($form->isSubmitted() && $form->isValid()) {
            // ... save the meetup, redirect etc.
			        }

			        return $this->render(
			            'pointageFiltre.html.twig',
			            ['form' => $form->createView()]
			        );
			}

			public function ajaxAction(Request $request)
			{
				if ($request->isXmlHttpRequest()) {
					$form_element1 = $request->request->get('form_element1');
					$form_element2 = $request->request->get('form_element2');
					// do whatever

					$data['success'] = true;
					$data['url'] = $this->generateUrl('new_route');;
					return new \Symfony\Component\HttpFoundation\JsonResponse($data);
				}
			}

}
