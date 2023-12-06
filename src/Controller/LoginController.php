<?php

namespace App\Controller;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Etudiant;
use App\Form\ConnectionType;
use App\Form\RegistrationType;

class LoginController extends AbstractController
{
  public function formConnection(Request $request)
  {
    $etudiant = new Etudiant();

    $form = $this->createForm(ConnectionType::class, $etudiant);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $etudiant = $form->getData();
        $e = $this->getDoctrine()->getRepository(Etudiant::class)->findByNumeroEtudiant($etudiant->getNumeroEtudiant());
        $id = $e[0]->getId();
        return $this->redirectToRoute('pointage', array('id' => $id));
    }
    return $this->render('login.html.twig', array(
      'form'=>$form->createView(),
    ));

  }

  public function formRegistration(Request $request)
  {
    $etudiant = new Etudiant();

    $form = $this->createForm(RegistrationType::class, $etudiant);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName())
      {
        return $this->redirectToRoute('index');
      }else{
        $etudiant = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etudiant);
        $entityManager->flush();
      }
      return $this->redirectToRoute('index');
    }
    return $this->render('registration.html.twig', array('form'=>$form->createView(),));
  }
}
