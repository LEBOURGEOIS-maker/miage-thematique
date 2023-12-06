<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Security\LoginFormAuthenticator;
use App\Entity\Utilisateur;

class UtilisateurFixtures extends Fixture
{
    
  /*
  private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }
    */

    public function load(ObjectManager $manager)
    {
      $dade = new Utilisateur();
      $dade->setEmail('etudiant1@test.fr');
      $dade->setRoles(['ROLE_USER']);
      $dade->setNumeroEtudiant('21103485');
      $dade->setPrenomUtilisateur('David');
      $dade->setNomUtilisateur('Dupont');
      $dade->setFormation($this->getReference('m2_osie'));
      $password=$this->encoder->encodePassword($dade, 'azerty');
      $dade->setPassword($password);
      $manager->persist($dade);

      $alle = new Utilisateur();
      $alle->setEmail('etudiant2@test.fr');
      $alle->setRoles(['ROLE_USER']);
      $alle->setNumeroEtudiant('21207671');
      $alle->setPrenomUtilisateur('Alexandre');
      $alle->setNomUtilisateur('Dupong');
      $alle->setFormation($this->getReference('m2_sio'));
      $password=$this->encoder->encodePassword($alle, 'azerty');
      $alle->setPassword($password);
      $manager->persist($alle);

      $axbo = new Utilisateur();
      $axbo->setEmail('etudiant3@test.fr');
      $axbo->setRoles(['ROLE_USER']);
      $axbo->setNumeroEtudiant('21610232');
      $axbo->setPrenomUtilisateur('Fabien');
      $axbo->setNomUtilisateur('Lebourgeois');
      $axbo->setFormation($this->getReference('m2_osie'));
      $password=$this->encoder->encodePassword($axbo, 'azerty');
      $axbo->setPassword($password);
      $manager->persist($axbo);

      $bade = new Utilisateur();
      $bade->setEmail('etudiant4@test.fr');
      $bade->setRoles(['ROLE_USER']);
      $bade->setNumeroEtudiant('21305611');
      $bade->setPrenomUtilisateur('Bastien');
      $bade->setNomUtilisateur('Duponp');
      $bade->setFormation($this->getReference('m1_miage'));
      $password=$this->encoder->encodePassword($bade, 'azerty');
      $bade->setPassword($password);
      $manager->persist($bade);

      $anla = new Utilisateur();
      $anla->setEmail('prof@test.fr');
      $anla->setRoles(['ROLE_PROF','ROLE_ADMIN']);
      $anla->setNumeroEtudiant('21100000');
      $anla->setPrenomUtilisateur('Anne');
      $anla->setNomUtilisateur('Lapujade');
      $password=$this->encoder->encodePassword($anla, 'azerty');
      $anla->setPassword($password);
      $manager->persist($anla);

      $manager->flush();

      $this->addReference('david', $dade);
      $this->addReference('alex', $alle);
      $this->addReference('axel', $axbo);
      $this->addReference('bastien', $bade);
      $this->addReference('anne', $anla);
    }
}
