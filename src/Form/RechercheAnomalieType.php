<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class RechercheAnomalieType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
        ->add('semaine', TextType::class, ['attr' => ['class' => 'form-control', 'placeholder'=> 'N°', 'maxlength'=>2], 'label'=>false])
        ->add('annee', ChoiceType::class, [
          'choices'  => [
            (new \DateTime())->format("Y") => (new \DateTime())->format("Y"),
            (new \DateTime("-1 year"))->format("Y") => (new \DateTime("-1 year"))->format("Y")
          ],
          'preferred_choices' => [(new \DateTime())->format("Y")],
          'attr' => [
            'class' => 'custom-select'
          ]
        ])
        ->add('submit', SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'csrf_protection' => false,
    ]);
  }
}
