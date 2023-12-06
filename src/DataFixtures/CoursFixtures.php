<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Cours;

class CoursFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
      //{cours miage M1

      $isi01 = new Cours();
      $isi01->setNomUe('ISI_01 Architecture client serveur');
      $isi01->addFormation($this->getReference('m1_miage'));
      $manager->persist($isi01);

      $isi02 = new Cours();
      $isi02->setNomUe('ISI_02 Conduite de projet');
      $isi02->addFormation($this->getReference('m1_miage'));
      $manager->persist($isi02);

      $isi03 = new Cours();
      $isi03->setNomUe('ISI_03 Conduite du changement');
      $isi03->addFormation($this->getReference('m1_miage'));
      $manager->persist($isi03);

      $isi04 = new Cours();
      $isi04->setNomUe('ISI_04 Contrôle qualité');
      $isi04->addFormation($this->getReference('m1_miage'));
      $manager->persist($isi04);

      $isi05 = new Cours();
      $isi05->setNomUe('ISI_05 Ingénierie du logiciel');
      $isi05->addFormation($this->getReference('m1_miage'));
      $manager->persist($isi05);

      $info01 = new Cours();
      $info01->setNomUe('INFO_01 Administration des SE');
      $info01->addFormation($this->getReference('m1_miage'));
      $manager->persist($info01);

      $info02 = new Cours();
      $info02->setNomUe('INFO_02 Analyse et décision en entreprise');
      $info02->addFormation($this->getReference('m1_miage'));
      $manager->persist($info02);

      $info03 = new Cours();
      $info03->setNomUe('INFO_03 Architecture Web des SI');
      $info03->addFormation($this->getReference('m1_miage'));
      $manager->persist($info03);

      $info04 = new Cours();
      $info04->setNomUe('INFO_04 Architecture des SI');
      $info04->addFormation($this->getReference('m1_miage'));
      $manager->persist($info04);

      $info05 = new Cours();
      $info05->setNomUe('INFO_05 ASI mobiles 1');
      $info05->addFormation($this->getReference('m1_miage'));
      $manager->persist($info05);

      $info06 = new Cours();
      $info06->setNomUe('INFO_06 BD avancées');
      $info06->addFormation($this->getReference('m1_miage'));
      $manager->persist($info06);

      $info07 = new Cours();
      $info07->setNomUe('INFO_07 Bio informatique 1');
      $info07->addFormation($this->getReference('m1_miage'));
      $manager->persist($info07);

      $info08 = new Cours();
      $info08->setNomUe('INFO_08 Conception avancée des SI');
      $info08->addFormation($this->getReference('m1_miage'));
      $manager->persist($info08);

      $info09 = new Cours();
      $info09->setNomUe('INFO_09 IHM');
      $info09->addFormation($this->getReference('m1_miage'));
      $manager->persist($info09);

      $geo01 = new Cours();
      $geo01->setNomUe('GEO_01 Economie politique');
      $geo01->addFormation($this->getReference('m1_miage'));
      $manager->persist($geo01);

      $geo02 = new Cours();
      $geo02->setNomUe('GEO_02 Gestion de production');
      $geo02->addFormation($this->getReference('m1_miage'));
      $manager->persist($geo02);

      $geo05 = new Cours();
      $geo05->setNomUe('GEO_05 Marketing');
      $geo05->addFormation($this->getReference('m1_miage'));
      $manager->persist($geo05);

      $geo06 = new Cours();
      $geo06->setNomUe('GEO_06 Marketing orienté Web');
      $geo06->addFormation($this->getReference('m1_miage'));
      $manager->persist($geo06);

      $sante01 = new Cours();
      $sante01->setNomUe('SANTE_01 Analyse des systèmes physiques');
      $sante01->addFormation($this->getReference('m1_miage'));
      $manager->persist($sante01);

      $sante02 = new Cours();
      $sante02->setNomUe('SANTE_02 Droit de la santé et bioéthique 1');
      $sante02->addFormation($this->getReference('m1_miage'));
      $manager->persist($sante02);

      $sante03 = new Cours();
      $sante03->setNomUe('SANTE_03 Instrumentation biomédicale 1');
      $sante03->addFormation($this->getReference('m1_miage'));
      $manager->persist($sante03);

      $sante04 = new Cours();
      $sante04->setNomUe('SANTE_04 Notions de base en anatomie');
      $sante04->addFormation($this->getReference('m1_miage'));
      $manager->persist($sante04);

      $trans01 = new Cours();
      $trans01->setNomUe('TRANS_01 Anglais');
      $trans01->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans01);

      $trans01 = new Cours();
      $trans01->setNomUe('TRANS_01 Statistiques');
      $trans01->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans01);

      $trans02 = new Cours();
      $trans02->setNomUe('TRANS_02 Communication');
      $trans02->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans02);

      $trans03 = new Cours();
      $trans03->setNomUe('TRANS_03 Découverte de la recherche');
      $trans03->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans03);

      $trans04 = new Cours();
      $trans04->setNomUe('TRANS_04 Découverte des laboratoires');
      $trans04->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans04);

      $trans05 = new Cours();
      $trans05->setNomUe('TRANS_05 Droit du travail');
      $trans05->addFormation($this->getReference('m1_miage'));
      $manager->persist($trans05);

      // $pro01 = new Cours();
      // $pro01->setNomUe('PRO_01 Projet Professionnel');
      // $pro01->addFormation($this->getReference('m1_miage'));
      // $manager->persist($pro01);
      //cours miage M1}

      //{cours M2 Sio
      $isi18 = new Cours();
      $isi18->setNomUe('ISI_18 Interopérabilité des SI (ETL)');
      $isi18->addFormation($this->getReference('m2_sio'));
      $manager->persist($isi18);

      $info20 = new Cours();
      $info20->setNomUe('INFO_20 Big data');
      $info20->addFormation($this->getReference('m2_sio'));
      $manager->persist($info20);

      $info23 = new Cours();
      $info23->setNomUe('INFO_23 IA');
      $info23->addFormation($this->getReference('m2_sio'));
      $manager->persist($info23);

      $info26 = new Cours();
      $info26->setNomUe('INFO_26 Internet des objets (IoT)');
      $info26->addFormation($this->getReference('m2_sio'));
      $manager->persist($info26);

      $info32 = new Cours();
      $info32->setNomUe('INFO_32 Web x.0');
      $info32->addFormation($this->getReference('m2_sio'));
      $manager->persist($info32);

      $trans09 = new Cours();
      $trans09->setNomUe('TRANS_09 Data Science');
      $trans09->addFormation($this->getReference('m2_sio'));
      $manager->persist($trans09);
      //cours M2 Sio}

      //{cours M2 Osie
      $isi09 = new Cours();
      $isi09->setNomUe('ISI_09 Audit des SI');
      $isi09->addFormation($this->getReference('m2_osie'));
      $manager->persist($isi09);

      $isi11 = new Cours();
      $isi11->setNomUe('ISI_11 Progiciels de gestion intégrés');
      $isi11->addFormation($this->getReference('m2_osie'));
      $manager->persist($isi11);

      $isi15 = new Cours();
      $isi15->setNomUe('ISI_15 Stratégie et management des SI');
      $isi15->addFormation($this->getReference('m2_osie'));
      $manager->persist($isi15);

      $isi16 = new Cours();
      $isi16->setNomUe('ISI_16 Ingénierie des SI en santé');
      $isi16->addFormation($this->getReference('m2_osie'));
      $manager->persist($isi16);

      $isi18 = new Cours();
      $isi18->setNomUe('ISI_18 Outils pour la BI');
      $isi18->addFormation($this->getReference('m2_osie'));
      $manager->persist($isi18);

      $geo09 = new Cours();
      $geo09->setNomUe('GEO_09 Théories des organisations');
      $geo09->addFormation($this->getReference('m2_osie'));
      $manager->persist($geo09);
      //cours M2 Osie}

      //{cours en commun
      $perso01 = new Cours();
      $perso01->setNomUe('PERSO_01 Travail Personnel');
      $perso01->addFormation($this->getReference('m1_miage'));
      $perso01->addFormation($this->getReference('m2_osie'));
      $perso01->addFormation($this->getReference('m2_sio'));
      // $perso01->addFormation($this->getReference('m2_ine'));
      $manager->persist($perso01);

      $isi14 = new Cours();
      $isi14->setNomUe('ISI_14 Conduite de projet agile');
      $isi14->addFormation($this->getReference('m2_osie'));
      $isi14->addFormation($this->getReference('m2_sio'));
      $manager->persist($isi14);

      $isi19 = new Cours();
      $isi19->setNomUe('ISI_19 Workflows');
      $isi19->addFormation($this->getReference('m2_osie'));
      $isi19->addFormation($this->getReference('m2_sio'));
      $manager->persist($isi19);

      $pro03 = new Cours();
      $pro03->setNomUe('PRO_03 Etude de cas thématique');
      $pro03->addFormation($this->getReference('m2_osie'));
      $pro03->addFormation($this->getReference('m2_sio'));
      $manager->persist($pro03);

      // $pro04 = new Cours();
      // $pro04->setNomUe('PRO_04 Projet professionnel');
      // $pro04->addFormation($this->getReference('m2_osie'));
      // $pro04->addFormation($this->getReference('m2_sio'));
      // $manager->persist($pro04);

      $trans08 = new Cours();
      $trans08->setNomUe('TRANS_08 Anglais');
      $trans08->addFormation($this->getReference('m2_osie'));
      $trans08->addFormation($this->getReference('m2_sio'));
      $manager->persist($trans08);

      $trans10 = new Cours();
      $trans10->setNomUe('TRANS_10 Environnement socio-économique');
      $trans10->addFormation($this->getReference('m2_osie'));
      $trans10->addFormation($this->getReference('m2_sio'));
      $manager->persist($trans10);

      $geo08 = new Cours();
      $geo08->setNomUe('GEO_08 Stratégie d\'entreprise');
      $geo08->addFormation($this->getReference('m2_osie'));
      $geo08->addFormation($this->getReference('m2_sio'));
      $manager->persist($geo08);

      $isi17 = new Cours();
      $isi17->setNomUe('ISI_17 Management de la sécurité des SI');
      $isi17->addFormation($this->getReference('m2_osie'));
      $isi17->addFormation($this->getReference('m2_sio'));
      $manager->persist($isi17);

      $info18 = new Cours();
      $info18->setNomUe('INFO_18 Architecture des SI 2');
      $info18->addFormation($this->getReference('m2_osie'));
      $info18->addFormation($this->getReference('m2_sio'));
      $manager->persist($info18);

      $info19 = new Cours();
      $info19->setNomUe('INFO_19 ASI Mobile 2');
      $info19->addFormation($this->getReference('m2_osie'));
      $info19->addFormation($this->getReference('m2_sio'));
      $manager->persist($info19);

      $info31 = new Cours();
      $info31->setNomUe('INFO_31 Web Design');
      $info31->addFormation($this->getReference('m2_osie'));
      $info31->addFormation($this->getReference('m2_sio'));
      $manager->persist($info31);
      //cours en commun}

      $manager->flush();

      $this->addReference('ISI_01', $isi01);
      $this->addReference('ISI_02', $isi02);
      $this->addReference('ISI_03', $isi03);
      $this->addReference('ISI_04', $isi04);
      $this->addReference('ISI_05', $isi05);
      $this->addReference('ISI_09', $isi09);
      $this->addReference('ISI_11', $isi11);
      $this->addReference('ISI_14', $isi14);
      $this->addReference('ISI_15', $isi15);
      $this->addReference('ISI_16', $isi16);
      $this->addReference('ISI_17', $isi17);
      $this->addReference('ISI_18', $isi18);
      $this->addReference('ISI_19', $isi19);
      $this->addReference('INFO_01', $info01);
      $this->addReference('INFO_02', $info02);
      $this->addReference('INFO_03', $info03);
      $this->addReference('INFO_04', $info04);
      $this->addReference('INFO_05', $info05);
      $this->addReference('INFO_06', $info06);
      $this->addReference('INFO_07', $info07);
      $this->addReference('INFO_08', $info08);
      $this->addReference('INFO_09', $info09);
      $this->addReference('INFO_18', $info18);
      $this->addReference('INFO_19', $info19);
      $this->addReference('INFO_20', $info20);
      $this->addReference('INFO_23', $info23);
      $this->addReference('INFO_26', $info26);
      $this->addReference('INFO_31', $info31);
      $this->addReference('INFO_32', $info32);
      $this->addReference('TRANS_08', $trans08);
      $this->addReference('PERSO_01', $perso01);
      $this->addReference('PRO_03', $pro03);
      $this->addReference('TRANS_10', $trans10);
      $this->addReference('GEO_08', $geo08);
    }

    public function getDependencies()
    {
      return array(FormationFixtures::class,);
    }
}
