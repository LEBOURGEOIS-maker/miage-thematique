<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Pointage;
use App\Entity\Cours;
use App\Entity\PlageHoraire;


class PointageDeSortieType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    // $formation = $this->getDoctrine()->getRepository(Formation::class)->find($idFormation);

    $builder
        ->add('commentaireSortie', TextareaType::class, array(
          'required' => false,
          'attr' => array('class' => 'custom-textarea', 'placeholder' => "Tu pars en avances là ?!", 'maxlength' => '70')
        ))
        ->add('connection', SubmitType::class, array('label' => 'Sortie de cours', 'attr' => array('class' => 'btn btn-primary text-uppercase ml-2 px-5')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver
    ->setDefaults([
        'data_class' => Pointage::class,
    ]);
  }
}
