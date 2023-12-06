<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Pointage;
use App\Entity\Formation;
use App\Entity\Cours;
use App\Entity\PlageHoraire;


class PointageFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    //$listeFormation = $em->getRepository(Formation::class)->findAll();
      //dump($options);
      $listeformation = $options['formations'];
      //dump($listeformation);
      $listecours = $options['cours'];
      $builder
      //->add('formations', EntityType::class, ['class' => Formation::class, 'choices' => $listeformation])
      ->add('cours', EntityType::class, [
          'class' => Cours::class,
          'choices' => $listecours,
          //'group_by' => 'formation',
          'placeholder' => 'Choisir un cours'
        ])

      // ->add('cours', 'entity', array(
      //     'class' => 'Cours::class',
      //     'multiple' => false,
      //     'required' => false,
      //     'choices' => $this->getOptGropupForEntities()
      //       ))
      ->add('filtrer', SubmitType::class, ['label' => 'Filtrer']);
    }

  //   public function getOptGropupForEntities(){
  //     $artists = $this->em->getRepository('AcmeAdminBundle:Artists')->findAll();
  //     $list = array();
  //     foreach($artists as $a){
  //         $name = $a->getName();
  //         if(count($a->getWorks())>0){
  //             foreach($a->getWorks() as $w){
  //                 $list[$name][$w->getId()] = $w->getName();
  //             }
  //         }
  //     }
  //     return $list;
  // }


  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver
    ->setDefaults([
        'data_class' => null,
    ])
    ->setRequired(['formations'])
    ->setRequired(['cours']);
  }
}


//public function buildForm(FormBuilderInterface $builder, array $options)
//{
//        $listeFormation = $em->getRepository(Formation::class)->findAll();
        //   $listeformation = $options['formations'];
        //   dump('Début buildForm '.$listeformation[0]);
        //
        // $builder
        //   ->add('formation', EntityType::class, ['class' => Formation::class,
        //     'placeholder' => 'MIAGE M2',
        //     'choices' => $listeformation,'required'   => true,])
        //   ->add('cours', EntityType::class, array(
        //      'class' => Cours::class,
        //      'label' => false,
        //      'required' => true,
        //      'choice_label' => 'nomUe',
        //      'choices' => null,
        //      'attr' => array('class' => 'custom-select')))
        //   ->add('etudiants', TextType::class,['required'   => false,])
        //   ->add('date_debut', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd','required'   => false,'input' => 'string'])
        //   ->add('date_fin', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd','required'   => false,'input' => 'string'])
        //   ->add('filtrer', SubmitType::class, ['label' => 'Filtrer',]);

        // $formModifier = function (FormInterface $builder, Formation $formation = null)
        // {
        //       $cours = null === $formation ? [] : $formation->getCours();
        //
        //       $form->add('cours', EntityType::class, array(
        //         'class' => Cours::class,
        //         'label' => false,
        //         'placeholder' => 'Cours',
        //         'required' => true,
        //         'choice_label' => 'nomUe',
        //         'choices' => $formation->getCours(),
        //         'attr' => array('class' => 'custom-select')));
        //   };
        //
        //   $builder->addEventListener(
        //       FormEvents::PRE_SET_DATA,
        //       function (FormEvent $event) use ($formModifier) {
        //           $data = $event->getData();
        //           dump($data);
        //           $formModifier($event->getForm(), $data->);
        //       }
        //   );
        //
        //   $builder->get('formation')->addEventListener(
        //     FormEvents::POST_SUBMIT,
        //     function (FormEvent $event) use ($formModifier) {
        //         $formation = $event->getForm()->getData();
        //         $formModifier($event->getForm()->getParent(), $formation);
        //     }
        //   );
