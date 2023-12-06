<?php

namespace App\Commandes;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Pointage;
use App\Entity\Utilisateur;
use App\Entity\Cours;
use App\Entity\PlageHoraire;

class CreerPointageCommand extends ContainerAwareCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'creer-pointage';

    //private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        //$this->em = $em;
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
      $this
          // the short description shown while running "php bin/console list"
          ->setDescription('Crée les pointages du jour')

          // the full command description shown when running the command with
          // the "--help" option
          ->setHelp('Cette commande crée les pointages du jour à partir des données présentes sur CelCat ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // $output->writeln([
      //     'Pointage Creator',
      //     '============',
      //     '',
      // ]);
      $em = $this->getContainer()->get('doctrine')->getManager();
      $users = $em->getRepository(Utilisateur::class)->findAll();
      $plageHoraire = $em->getRepository(PlageHoraire::class)->find(669);
      $cours = $em->getRepository(Cours::class)->find(482);

      foreach ($users as $user) {
        if(in_array("ROLE_ADMIN", $user->getRoles()) || in_array("ROLE_PROF", $user->getRoles()))
        {
          continue;
        }
        else
        {
          $pointage = new Pointage();
          $pointage->setPlageHoraire($plageHoraire);
          $pointage->setCours($cours);
          $pointage->setFormation($user->getFormation());
          $pointage->setRetard(0);
          $pointage->setPointeParAdmin(false);
          $pointage->setPartiEnAvance(false);
          $pointage->setDureePointage(0);
          $pointage->setAbsence(true);
          $pointage->setDepartJustifie(false);
          $pointage->setAbsenceJustifie(false);
          $pointage->setUtilisateurEtudiant($user);
        }

        $em->persist($pointage);
        $em->flush();
      }
      // $output->write('Tu as créé les pointages');
    }
}
