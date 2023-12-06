<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304145336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE abscences_justif (id INT AUTO_INCREMENT NOT NULL, cours VARCHAR(255) NOT NULL, plage_horaire_justif_abscence VARCHAR(255) NOT NULL, utilisateur_etudiant INT NOT NULL, formation VARCHAR(255) NOT NULL, lien_fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE admin_cours');
        $this->addSql('DROP TABLE admin_formation');
        $this->addSql('DROP TABLE admin_pointage');
        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT NULL, CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT NULL, CHANGE commentaire commentaire VARCHAR(255) DEFAULT NULL, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage RENAME INDEX fk_7591b207ecf78b0 TO IDX_7591B207ECF78B0');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE utilisateur_cours ADD CONSTRAINT FK_3B0FD4427ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_cours (admin_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_5DE077667ECF78B0 (cours_id), INDEX IDX_5DE07766642B8210 (admin_id), PRIMARY KEY(admin_id, cours_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE admin_formation (admin_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_A9B7248D5200282E (formation_id), INDEX IDX_A9B7248D642B8210 (admin_id), PRIMARY KEY(admin_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE admin_pointage (admin_id INT NOT NULL, pointage_id INT NOT NULL, INDEX IDX_93F91C26E58DA11D (pointage_id), INDEX IDX_93F91C26642B8210 (admin_id), PRIMARY KEY(admin_id, pointage_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE abscences_justif');
        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT \'NULL\', CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT \'NULL\', CHANGE commentaire commentaire VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pointage RENAME INDEX idx_7591b207ecf78b0 TO FK_7591B207ECF78B0');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B35200282E');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur_cours DROP FOREIGN KEY FK_3B0FD4427ECF78B0');
    }
}
