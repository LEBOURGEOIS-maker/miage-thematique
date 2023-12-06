<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Validator\Constraints\DateTime;

use DateTimeImmutable;

use App\Entity\Pointage;

class PointageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
      $this->pointageDavid($manager);
      $this->pointageAlex($manager);
      $this->pointageAxel($manager);
      $this->pointageBastien($manager);
      $manager->flush();
    }

    public function getDependencies()
    {
      return array(FormationFixtures::class, CoursFixtures::class, UtilisateurFixtures::class, PlageHoraireFixtures::class);
    }
    //fonction interne
    private function pointageDavid($manager)
    {
      $this->importPointage(22, 4, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14520, null,null,0,0,0,$manager);
      $this->importPointage(22, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(22, 4, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(23, 4, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(24, 4, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 15000, null,null,0,0,0,$manager);
      $this->importPointage(25, 4, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(26, 4, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(26, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(27, 4, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(6, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(7, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(9, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(10, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14220, null,null,0,0,0,$manager);
      $this->importPointage(10, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(11, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(20, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(20, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null,null,0,0,0,$manager);
      $this->importPointage(20, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(21, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(22, 5, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 15000, null,null,0,0,0,$manager);
      $this->importPointage(23, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(24, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(24, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null, 0,0,0,$manager);
      $this->importPointage(25, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('david'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

    }

    private function pointageAlex($manager)
    {
      $this->importPointage(22, 4, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14520, null,null,0,0,0,$manager);
      $this->importPointage(22, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(22, 4, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(23, 4, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(24, 4, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 15000, null,null,0,0,0,$manager);
      $this->importPointage(25, 4, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(26, 4, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(26, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(27, 4, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(6, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(7, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(9, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(10, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14220, null,null,0,0,0,$manager);
      $this->importPointage(10, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(11, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(20, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(20, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null,null,0,0,0,$manager);
      $this->importPointage(20, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(21, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(22, 5, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 15000, null,null,0,0,0,$manager);
      $this->importPointage(23, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(24, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(24, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null, 0,0,0,$manager);
      $this->importPointage(25, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('alex'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);
    }

    private function pointageAxel($manager)
    {
      $this->importPointage(22, 4, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14520, null,null,0,0,0,$manager);
      $this->importPointage(22, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(22, 4, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(23, 4, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(24, 4, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 15000, null,null,0,0,0,$manager);
      $this->importPointage(25, 4, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(26, 4, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(26, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(27, 4, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(6, 5, 0, 0, 0, 0, 0, 0,$this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null, null,0,0,1,$manager);
      $this->importPointage(6, 5, 0, 0, 0, 0, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null, null,0,0,1,$manager);
      $this->importPointage(6, 5, 0, 0, 0, 0, 0, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null,null,0,0,1,$manager);
      $this->importPointage(7, 5, 0, 0, 0, 0, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null,null,0,0,1,$manager);
      $this->importPointage(9, 5, 0, 0, 0, 0, 0, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null,null,0,0,1,$manager);
      $this->importPointage(10, 5, 0, 0, 0, 0, 0, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null,null,0,0,1,$manager);
      $this->importPointage(10, 5, 0, 0, 0, 0, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null, null,0,0,1,$manager);
      $this->importPointage(11, 5, 0, 0, 0, 0, 0, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 0, null,null,0,0,1,$manager);

      $this->importPointage(20, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(20, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14400, null,null,0,0,0,$manager);
      $this->importPointage(20, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(21, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(22, 5, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 15000, null,null,0,0,0,$manager);
      $this->importPointage(23, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(24, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(24, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 0, false, 14400, null, null, 0,0,0,$manager);
      $this->importPointage(25, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('axel'), $this->getReference('m2_sio'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

    }

    private function pointageBastien($manager)
    {
      $this->importPointage(22, 4, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14520, null,null,0,0,0,$manager);
      $this->importPointage(22, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(22, 4, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(23, 4, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(24, 4, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 15000, null,null,0,0,0,$manager);
      $this->importPointage(25, 4, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(26, 4, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(26, 4, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(27, 4, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(6, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(6, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(7, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(9, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(10, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14220, null,null,0,0,0,$manager);
      $this->importPointage(10, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null,0,0,0,$manager);
      $this->importPointage(11, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);

      $this->importPointage(20, 5, 8, 57, 0, 12, 59, 0, $this->getReference('TRANS_10'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14520, null, null,0,0,0,$manager);
      $this->importPointage(20, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_15'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null,null,0,0,0,$manager);
      $this->importPointage(20, 5, 17, 58, 0, 19, 30, 0, $this->getReference('ISI_18'), $this->getReference('18h-20h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 10800, null,"Le prof m'a autorisé à partir plus tôt",0,0,0,$manager);
      $this->importPointage(21, 5, 14, 1, 0, 18, 0, 0, $this->getReference('GEO_08'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 60, false, 14340, "Ce n'est qu'une minute de retard",null,0,0,0,$manager);
      $this->importPointage(22, 5, 8, 53, 0, 13, 3, 0, $this->getReference('PRO_03'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 15000, null,null,0,0,0,$manager);
      $this->importPointage(23, 5, 13, 45, 0, 17, 58, 0, $this->getReference('ISI_16'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, true, 15180, null,"DEUX MINUTES",0,0,0,$manager);
      $this->importPointage(24, 5, 8, 58, 0, 12, 55, 0, $this->getReference('PERSO_01'), $this->getReference('9h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14220, null, null,0,0,0,$manager);
      $this->importPointage(24, 5, 14, 0, 0, 18, 0, 0, $this->getReference('ISI_19'), $this->getReference('14h-18h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 0, false, 14400, null, null, 0,0,0,$manager);
      $this->importPointage(25, 5, 8, 15, 0, 13, 5, 0, $this->getReference('ISI_11'), $this->getReference('8h-13h'), $this->getReference('bastien'), $this->getReference('m2_osie'), false, 900, false, 13800, "Mon bus est arrivé en retard",null,0,0,0,$manager);
    }

    private function importPointage($jour, $mois,$hd, $md, $sd, $hf, $mf, $sf , $matiere, $plage, $user, $formation, $pointeParAdmin, $retard, $partiEnAvance, $dureePointage, $commentaire, $commentaireSortie, $absenceJustifie, $departJustifie, $absence, $manager)
    {
      $pointage = new Pointage();
      $dateDebut = $this->recupDateTime(mktime($hd ,$md ,$sd , date($mois), date($jour), date('Y')));
      $dateFin = $this->recupDateTime(mktime($hf ,$mf ,$sf , date($mois), date($jour), date('Y')));
      $pointage->setDatePointageEntree($dateDebut);
      $pointage->setDatePointageSortie($dateFin);
      $pointage->setCours($matiere);
      $pointage->setPlageHoraire($plage);
      $pointage->setUtilisateurEtudiant($user);
      $pointage->setFormation($formation);
      $pointage->setPointeParAdmin($pointeParAdmin);
      $pointage->setRetard($retard);
      $pointage->setPartiEnAvance($partiEnAvance);
      $pointage->setCommentaire($commentaire);
      $pointage->setCommentaireSortie($commentaireSortie);
      $pointage->setDureePointage($dureePointage);
      $pointage->setAbsenceJustifie($absenceJustifie);
      $pointage->setDepartJustifie($departJustifie);
      $pointage->setAbsence($absence);
      $manager->persist($pointage);
    }

    private function recupDateTime($timestamp)
    {
      $dateTemp = new \DateTime();
      $jour = date("d", $timestamp);
      $mois = date("m", $timestamp);
      $annee = date("Y", $timestamp);
      $heures = date("H", $timestamp);
      $minutes = date("i", $timestamp);
      $secondes = date("s", $timestamp);

      $dateTemp->setDate($annee, $mois, $jour);
      $dateTemp->setTime($heures, $minutes, $secondes);
      return $dateTemp;
    }
}
