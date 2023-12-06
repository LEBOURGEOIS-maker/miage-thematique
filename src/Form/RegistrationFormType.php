<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

use App\Entity\Formation;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'Adresse email', 'attr' => array('placeholder' => 'Adresse email')))
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => array('placeholder' => 'Mot de passe')
            ])
            ->add('numeroEtudiant', NumberType::class, array('label' => 'Numéro étudiant', 'attr' => array('placeholder' => 'Numéro étudiant', 'maxlength' => '8', 'onkeypress' => 'return isNumber(event)')))
            ->add('prenomUtilisateur', TextType::class, array('label' => 'Prénom', 'attr' => array('placeholder' => 'Prénom')))
            ->add('nomUtilisateur', TextType::class, array('label' => 'Nom', 'attr' => array('placeholder' => 'Nom')))
            ->add('formation', EntityType::class, array('class'=> Formation::class, 'placeholder' => 'Formation', 'required' => true , 'choice_label' => 'nomFormation', 'attr' => array('class' => 'custom-select')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
