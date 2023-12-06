<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\PlageHoraire;

class PlageHoraireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 8; $i < 20; $i++){
          for ($j = 1; $j <= 5; $j++){
            $plageHoraire =  new PlageHoraire();
            $heureFin = $i+$j;
            $plageHoraire->setPlageHoraire("".$i."h-".$heureFin."h");
            $plageHoraire->setDureePlage("".$j."");
            $manager->persist($plageHoraire);
            $this->addReference($plageHoraire->getPlageHoraire(), $plageHoraire);
          }
        }
        $manager->flush();
    }
}
