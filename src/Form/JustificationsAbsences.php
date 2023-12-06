<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

use App\Entity\Pointage;
use App\Entity\Cours;
use App\Entity\PlageHoraire;
use App\Entity\AbsencesJustifications;

class JustificationsAbsences extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $formation = $options['formation'];
    //$etudiant = $this->getUser();
    // $formation = $this->getDoctrine()->getRepository(Formation::class)->find($idFormation);

    $builder
        /*
        ->add('cours', EntityType::class, [
          'class' => Cours::class,
          'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('c')
                  ->innerJoin('c.id', 'cp', 'c.id = cp.id')
                  ->where('ec.etudiant = "'.$etudiant.'"')
                  ->orderBy('c.nomUe', 'ASC');
          },
          'choice_label' => 'nomUe',
        ]) */
      /*
        ->add('cours', EntityType::class, array(
          'class' => Cours::class,
          'label' => false,
          'placeholder' => 'Cours',
          'required' => true,
          'choice_label' => 'nomUe',
          'attr' => array('class' => 'custom-select')
        ))
        ->add('plageHoraire', EntityType::class, array(
          'class' => PlageHoraire::class,
          'label' => false,
          'placeholder' => 'Plage horaire',
          'required' => true,
          'choice_label' => 'plageHoraire',
          'attr' => array('class' => 'custom-select')
        ))*/
        ->add('dateDebut', DateType::class, [
          'widget' => 'choice',
          'format' => 'yyyy-MM-dd',
          'input' => 'string',
          'data' => '2020-05-01'
        ])
        ->add('heureDebut', TimeType::class, [
          'widget' => 'choice',
          'input' => 'string'
        ])
        ->add('dateFin', DateType::class, [
          'widget' => 'choice',
          'format' => 'yyyy-MM-dd',
          'input' => 'string',
          'data' => '2020-06-25'
        ])
        ->add('heureFin', TimeType::class, [
          'widget' => 'choice',
          'input' => 'string'
        ])
        ->add('lienFichier', FileType::class, [
          'label' => 'Lien du justificatif (PDF file)',
          

          // unmapped means that this field is not associated to any entity property
          'mapped' => false,

          // make it optional so you don't have to re-upload the PDF file
          // every time you edit the Product details
          'required' => true,

          // unmapped fields can't define their validation using annotations
          // in the associated entity, so you can use the PHP constraint classes
          'constraints' => [
              new File([
                  'maxSize' => '5024k',
                  'mimeTypes' => [
                      'application/pdf',
                      'application/x-pdf',
                  ],
                  'mimeTypesMessage' => 'Document non valide.',
              ])
          ],
      ])
        ->add('connection', SubmitType::class, array('label' => 'Justifier l\'absence', 'attr' => array('class' => 'btn btn-primary text-uppercase ml-2 px-5')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver
    ->setDefaults([
        'data_class' => AbsencesJustifications::class,
    ])
    ->setRequired(['formation']);
  }
}
