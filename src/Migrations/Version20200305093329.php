<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200305093329 extends AbstractMigration
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
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT \'NULL\', CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT \'NULL\', CHANGE commentaire commentaire VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
