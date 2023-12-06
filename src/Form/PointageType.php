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


class PointageType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $formation = $options['formation'];

    // $formation = $this->getDoctrine()->getRepository(Formation::class)->find($idFormation);

    $builder
        ->add('cours', EntityType::class, array(
          'class' => Cours::class,
          'label' => false,
          'placeholder' => 'Cours',
          'required' => true,
          'choice_label' => 'nomUe',
          'choices' => $formation->getCours(),
          'attr' => array('class' => 'custom-select')
        ))
        ->add('plageHoraire', EntityType::class, array(
          'class' => PlageHoraire::class,
          'label' => false,
          'placeholder' => 'Plage horaire',
          'required' => true,
          'choice_label' => 'plageHoraire',
          'attr' => array('class' => 'custom-select')
        ))
        ->add('commentaire', TextareaType::class, array(
          'required' => false,
          'attr' => array('class' => 'custom-textarea', 'placeholder' => "T'es en retard ! :(", 'maxlength' => '70', 'rows' => '1')
        ))
        ->add('connection', SubmitType::class, array('label' => 'Pointer', 'attr' => array('class' => 'btn btn-primary text-uppercase ml-2 px-5')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver
    ->setDefaults([
        'data_class' => Pointage::class,
    ])
    ->setRequired(['formation']);
  }
}
