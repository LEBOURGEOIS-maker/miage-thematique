<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301151348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, nom_admin VARCHAR(255) NOT NULL, prenom_admin VARCHAR(255) NOT NULL, id_connexion_admin VARCHAR(255) NOT NULL, mdp_admin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anomalie (id INT AUTO_INCREMENT NOT NULL, type_anomalie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, detenir_id INT DEFAULT NULL, numero_etudiant VARCHAR(255) NOT NULL, nom_etudiant VARCHAR(255) NOT NULL, prenom_etudiant VARCHAR(255) NOT NULL, mdp_etudiant VARCHAR(255) NOT NULL, formation VARCHAR(255) NOT NULL, INDEX IDX_717E22E3220CFB9C (detenir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointage (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, respecter_id INT DEFAULT NULL, appartenir_id INT DEFAULT NULL, date_pointage VARCHAR(255) NOT NULL, heure_pointage VARCHAR(255) NOT NULL, valide TINYINT(1) NOT NULL, statut_pointage VARCHAR(255) NOT NULL, type_pointage VARCHAR(255) NOT NULL, date_pointage_entree DATETIME NOT NULL, date_pointage_sortie DATETIME NOT NULL, INDEX IDX_7591B20DDEAB1A3 (etudiant_id), INDEX IDX_7591B20C4F82548 (respecter_id), INDEX IDX_7591B20E977E148 (appartenir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointage_admin (pointage_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_A1E014E2E58DA11D (pointage_id), INDEX IDX_A1E014E2642B8210 (admin_id), PRIMARY KEY(pointage_id, admin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3220CFB9C FOREIGN KEY (detenir_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20C4F82548 FOREIGN KEY (respecter_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20E977E148 FOREIGN KEY (appartenir_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2E58DA11D FOREIGN KEY (pointage_id) REFERENCES pointage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_pointage ADD CONSTRAINT FK_93F91C26642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_pointage ADD CONSTRAINT FK_93F91C26E58DA11D FOREIGN KEY (pointage_id) REFERENCES pointage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE07766642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE077667ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_admin ADD CONSTRAINT FK_F734216ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_admin ADD CONSTRAINT FK_F734216A642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_pointage DROP FOREIGN KEY FK_93F91C26642B8210');
        $this->addSql('ALTER TABLE admin_cours DROP FOREIGN KEY FK_5DE07766642B8210');
        $this->addSql('ALTER TABLE admin_formation DROP FOREIGN KEY FK_A9B7248D642B8210');
        $this->addSql('ALTER TABLE etudiant_admin DROP FOREIGN KEY FK_F734216A642B8210');
        $this->addSql('ALTER TABLE pointage_admin DROP FOREIGN KEY FK_A1E014E2642B8210');
        $this->addSql('ALTER TABLE etudiant_admin DROP FOREIGN KEY FK_F734216ADDEAB1A3');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20DDEAB1A3');
        $this->addSql('ALTER TABLE admin_pointage DROP FOREIGN KEY FK_93F91C26E58DA11D');
        $this->addSql('ALTER TABLE pointage_admin DROP FOREIGN KEY FK_A1E014E2E58DA11D');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE anomalie');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE pointage');
        $this->addSql('DROP TABLE pointage_admin');
        $this->addSql('ALTER TABLE admin_cours DROP FOREIGN KEY FK_5DE077667ECF78B0');
        $this->addSql('ALTER TABLE admin_formation DROP FOREIGN KEY FK_A9B7248D5200282E');
    }
}
