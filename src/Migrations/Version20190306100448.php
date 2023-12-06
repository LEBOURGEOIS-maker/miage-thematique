<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306100448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cours_admin (cours_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_B86884A07ECF78B0 (cours_id), INDEX IDX_B86884A0642B8210 (admin_id), PRIMARY KEY(cours_id, admin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_cours (formation_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_8B4112E95200282E (formation_id), INDEX IDX_8B4112E97ECF78B0 (cours_id), PRIMARY KEY(formation_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_admin (formation_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_FE8593035200282E (formation_id), INDEX IDX_FE859303642B8210 (admin_id), PRIMARY KEY(formation_id, admin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_admin ADD CONSTRAINT FK_B86884A07ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_admin ADD CONSTRAINT FK_B86884A0642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E97ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_admin ADD CONSTRAINT FK_FE8593035200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_admin ADD CONSTRAINT FK_FE859303642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE admin_cours');
        $this->addSql('DROP TABLE admin_formation');
        $this->addSql('DROP TABLE pointage_admin');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3220CFB9C');
        $this->addSql('DROP INDEX IDX_717E22E3220CFB9C ON etudiant');
        $this->addSql('ALTER TABLE etudiant ADD formation_id INT NOT NULL, DROP detenir_id, DROP formation');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E35200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_717E22E35200282E ON etudiant (formation_id)');
        $this->addSql('ALTER TABLE plage_horaire CHANGE duree_plage duree_plage VARCHAR(255) NOT NULL, CHANGE plage plage_horaire VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20C4F82548');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20E977E148');
        $this->addSql('DROP INDEX IDX_7591B20C4F82548 ON pointage');
        $this->addSql('DROP INDEX IDX_7591B20E977E148 ON pointage');
        $this->addSql('ALTER TABLE pointage ADD cours_id INT NOT NULL, ADD plage_horaire_id INT NOT NULL, DROP respecter_id, DROP appartenir_id');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B207ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20B6BCB98B FOREIGN KEY (plage_horaire_id) REFERENCES plage_horaire (id)');
        $this->addSql('CREATE INDEX IDX_7591B207ECF78B0 ON pointage (cours_id)');
        $this->addSql('CREATE INDEX IDX_7591B20B6BCB98B ON pointage (plage_horaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_cours (admin_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_5DE07766642B8210 (admin_id), INDEX IDX_5DE077667ECF78B0 (cours_id), PRIMARY KEY(admin_id, cours_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE admin_formation (admin_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_A9B7248D642B8210 (admin_id), INDEX IDX_A9B7248D5200282E (formation_id), PRIMARY KEY(admin_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pointage_admin (pointage_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_A1E014E2E58DA11D (pointage_id), INDEX IDX_A1E014E2642B8210 (admin_id), PRIMARY KEY(pointage_id, admin_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE07766642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_cours ADD CONSTRAINT FK_5DE077667ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_formation ADD CONSTRAINT FK_A9B7248D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2E58DA11D FOREIGN KEY (pointage_id) REFERENCES pointage (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE cours_admin');
        $this->addSql('DROP TABLE formation_cours');
        $this->addSql('DROP TABLE formation_admin');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E35200282E');
        $this->addSql('DROP INDEX IDX_717E22E35200282E ON etudiant');
        $this->addSql('ALTER TABLE etudiant ADD detenir_id INT DEFAULT NULL, ADD formation VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP formation_id');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3220CFB9C FOREIGN KEY (detenir_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3220CFB9C ON etudiant (detenir_id)');
        $this->addSql('ALTER TABLE plage_horaire CHANGE duree_plage duree_plage INT NOT NULL, CHANGE plage_horaire plage VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B207ECF78B0');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20B6BCB98B');
        $this->addSql('DROP INDEX IDX_7591B207ECF78B0 ON pointage');
        $this->addSql('DROP INDEX IDX_7591B20B6BCB98B ON pointage');
        $this->addSql('ALTER TABLE pointage ADD respecter_id INT DEFAULT NULL, ADD appartenir_id INT DEFAULT NULL, DROP cours_id, DROP plage_horaire_id');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20C4F82548 FOREIGN KEY (respecter_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20E977E148 FOREIGN KEY (appartenir_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_7591B20C4F82548 ON pointage (respecter_id)');
        $this->addSql('CREATE INDEX IDX_7591B20E977E148 ON pointage (appartenir_id)');
    }
}
