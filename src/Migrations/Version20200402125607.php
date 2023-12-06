<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402125607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT NULL, CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT NULL, CHANGE commentaire commentaire VARCHAR(255) DEFAULT NULL, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage RENAME INDEX fk_7591b207ecf78b0 TO IDX_7591B207ECF78B0');
        $this->addSql('ALTER TABLE prof_cours DROP FOREIGN KEY prof_cours_ibfk_1');
        $this->addSql('ALTER TABLE prof_cours DROP FOREIGN KEY prof_cours_ibfk_2');
        $this->addSql('DROP INDEX prof ON prof_cours');
        $this->addSql('DROP INDEX cours ON prof_cours');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE utilisateur_cours ADD CONSTRAINT FK_3B0FD4427ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT \'NULL\', CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT \'NULL\', CHANGE commentaire commentaire VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pointage RENAME INDEX idx_7591b207ecf78b0 TO FK_7591B207ECF78B0');
        $this->addSql('ALTER TABLE prof_cours ADD CONSTRAINT prof_cours_ibfk_1 FOREIGN KEY (cours) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE prof_cours ADD CONSTRAINT prof_cours_ibfk_2 FOREIGN KEY (prof) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX prof ON prof_cours (prof)');
        $this->addSql('CREATE INDEX cours ON prof_cours (cours)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B35200282E');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur_cours DROP FOREIGN KEY FK_3B0FD4427ECF78B0');
    }
}
