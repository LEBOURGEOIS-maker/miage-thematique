<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Formation;

class FormationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $m1miage = new Formation();
      $m1miage->setNomFormation('M1 Miage');
      $manager->persist($m1miage);

      $m2Osie = new Formation();
      $m2Osie->setNomFormation('M2 Miage OSIE');
      $manager->persist($m2Osie);

      $m2Sio = new Formation();
      $m2Sio->setNomFormation('M2 Miage SIO');
      $manager->persist($m2Sio);

      // $m2Ine = new Formation();
      // $m2Ine->setNomFormation('M2 Miage INE');
      // $manager->persist($m2Ine);

      $manager->flush();

      $this->addReference('m1_miage', $m1miage);
      $this->addReference('m2_osie', $m2Osie);
      $this->addReference('m2_sio', $m2Sio);
      //$this->addReference('m2_ine', $m2Ine);
    }
}
