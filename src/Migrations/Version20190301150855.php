<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301150855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_pointage (admin_id INT NOT NULL, pointage_id INT NOT NULL, INDEX IDX_93F91C26642B8210 (admin_id), INDEX IDX_93F91C26E58DA11D (pointage_id), PRIMARY KEY(admin_id, pointage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_cours (admin_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_5DE07766642B8210 (admin_id), INDEX IDX_5DE077667ECF78B0 (cours_id), PRIMARY KEY(admin_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_formation (admin_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_A9B7248D642B8210 (admin_id), INDEX IDX_A9B7248D5200282E (formation_id), PRIMARY KEY(admin_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom_ue VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_admin (etudiant_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_F734216ADDEAB1A3 (etudiant_id), INDEX IDX_F734216A642B8210 (admin_id), PRIMARY KEY(etudiant_id, admin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom_formation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plage_horaire (id INT AUTO_INCREMENT NOT NULL, plage VARCHAR(255) NOT NULL, duree_plage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_pointage ADD CONSTRAINT FK_93F91C26642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_pointage ADD CONSTRAINT FK_93F91C26E58DA11D FOREIGN KEY (pointage_id) REFERENCES pointage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE07766642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE077667ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_admin ADD CONSTRAINT FK_F734216ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_admin ADD CONSTRAINT FK_F734216A642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD detenir_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3220CFB9C FOREIGN KEY (detenir_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3220CFB9C ON etudiant (detenir_id)');
        $this->addSql('ALTER TABLE pointage ADD respecter_id INT DEFAULT NULL, ADD appartenir_id INT DEFAULT NULL, ADD statut_pointage VARCHAR(255) NOT NULL, ADD type_pointage VARCHAR(255) NOT NULL, ADD date_pointage_entree DATETIME NOT NULL, ADD date_pointage_sortie DATETIME NOT NULL');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20C4F82548 FOREIGN KEY (respecter_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20E977E148 FOREIGN KEY (appartenir_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_7591B20C4F82548 ON pointage (respecter_id)');
        $this->addSql('CREATE INDEX IDX_7591B20E977E148 ON pointage (appartenir_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_cours DROP FOREIGN KEY FK_5DE077667ECF78B0');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20E977E148');
        $this->addSql('ALTER TABLE admin_formation DROP FOREIGN KEY FK_A9B7248D5200282E');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3220CFB9C');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20C4F82548');
        $this->addSql('DROP TABLE admin_pointage');
        $this->addSql('DROP TABLE admin_cours');
        $this->addSql('DROP TABLE admin_formation');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etudiant_admin');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE plage_horaire');
        $this->addSql('DROP INDEX IDX_717E22E3220CFB9C ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP detenir_id');
        $this->addSql('DROP INDEX IDX_7591B20C4F82548 ON pointage');
        $this->addSql('DROP INDEX IDX_7591B20E977E148 ON pointage');
        $this->addSql('ALTER TABLE pointage DROP respecter_id, DROP appartenir_id, DROP statut_pointage, DROP type_pointage, DROP date_pointage_entree, DROP date_pointage_sortie');
    }
}
