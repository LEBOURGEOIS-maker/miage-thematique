<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304094147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE admin_cours');
        $this->addSql('DROP TABLE admin_formation');
        $this->addSql('DROP TABLE admin_pointage');
        $this->addSql('ALTER TABLE pointage CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT NULL, CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT NULL, CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE commentaire commentaire VARCHAR(255) DEFAULT NULL, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20B6BCB98B FOREIGN KEY (plage_horaire_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20290CBC30 FOREIGN KEY (utilisateur_etudiant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B205200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_7591B20B6BCB98B ON pointage (plage_horaire_id)');
        $this->addSql('CREATE INDEX IDX_7591B20290CBC30 ON pointage (utilisateur_etudiant_id)');
        $this->addSql('CREATE INDEX IDX_7591B205200282E ON pointage (formation_id)');
        $this->addSql('ALTER TABLE pointage RENAME INDEX fk_7591b207ecf78b0 TO IDX_7591B207ECF78B0');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE utilisateur_cours ADD CONSTRAINT FK_3B0FD4427ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE formation_cours ADD PRIMARY KEY (formation_id, cours_id)');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E97ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8B4112E95200282E ON formation_cours (formation_id)');
        $this->addSql('CREATE INDEX IDX_8B4112E97ECF78B0 ON formation_cours (cours_id)');
        $this->addSql('ALTER TABLE abscences_justif ADD cours_id INT NOT NULL, ADD plage_horaire_justif_abscence_id INT NOT NULL, ADD utilisateur_etudiant_id INT DEFAULT NULL, ADD formation_id INT NOT NULL, DROP etudiant, DROP cours, DROP plageHoraire, DROP date, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE lien_fichier lien_fichier TINYINT(1) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE abscences_justif ADD CONSTRAINT FK_7FE9C9527ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE abscences_justif ADD CONSTRAINT FK_7FE9C952AAFCBF73 FOREIGN KEY (plage_horaire_justif_abscence_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE abscences_justif ADD CONSTRAINT FK_7FE9C952290CBC30 FOREIGN KEY (utilisateur_etudiant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE abscences_justif ADD CONSTRAINT FK_7FE9C9525200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_7FE9C9527ECF78B0 ON abscences_justif (cours_id)');
        $this->addSql('CREATE INDEX IDX_7FE9C952AAFCBF73 ON abscences_justif (plage_horaire_justif_abscence_id)');
        $this->addSql('CREATE INDEX IDX_7FE9C952290CBC30 ON abscences_justif (utilisateur_etudiant_id)');
        $this->addSql('CREATE INDEX IDX_7FE9C9525200282E ON abscences_justif (formation_id)');
        $this->addSql('ALTER TABLE plage_horaire CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_cours (admin_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_5DE077667ECF78B0 (cours_id), INDEX IDX_5DE07766642B8210 (admin_id), PRIMARY KEY(admin_id, cours_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE admin_formation (admin_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_A9B7248D5200282E (formation_id), INDEX IDX_A9B7248D642B8210 (admin_id), PRIMARY KEY(admin_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE admin_pointage (admin_id INT NOT NULL, pointage_id INT NOT NULL, INDEX IDX_93F91C26E58DA11D (pointage_id), INDEX IDX_93F91C26642B8210 (admin_id), PRIMARY KEY(admin_id, pointage_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE abscences_justif MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE abscences_justif DROP FOREIGN KEY FK_7FE9C9527ECF78B0');
        $this->addSql('ALTER TABLE abscences_justif DROP FOREIGN KEY FK_7FE9C952AAFCBF73');
        $this->addSql('ALTER TABLE abscences_justif DROP FOREIGN KEY FK_7FE9C952290CBC30');
        $this->addSql('ALTER TABLE abscences_justif DROP FOREIGN KEY FK_7FE9C9525200282E');
        $this->addSql('DROP INDEX IDX_7FE9C9527ECF78B0 ON abscences_justif');
        $this->addSql('DROP INDEX IDX_7FE9C952AAFCBF73 ON abscences_justif');
        $this->addSql('DROP INDEX IDX_7FE9C952290CBC30 ON abscences_justif');
        $this->addSql('DROP INDEX IDX_7FE9C9525200282E ON abscences_justif');
        $this->addSql('ALTER TABLE abscences_justif DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE abscences_justif ADD etudiant INT NOT NULL, ADD cours VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, ADD plageHoraire INT NOT NULL, ADD date DATE NOT NULL, DROP cours_id, DROP plage_horaire_justif_abscence_id, DROP utilisateur_etudiant_id, DROP formation_id, CHANGE id id INT NOT NULL, CHANGE lien_fichier lien_fichier VARCHAR(5) NOT NULL COLLATE utf8mb4_general_ci');
        $this->addSql('ALTER TABLE formation MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE formation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE formation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE formation_cours DROP FOREIGN KEY FK_8B4112E95200282E');
        $this->addSql('ALTER TABLE formation_cours DROP FOREIGN KEY FK_8B4112E97ECF78B0');
        $this->addSql('DROP INDEX IDX_8B4112E95200282E ON formation_cours');
        $this->addSql('DROP INDEX IDX_8B4112E97ECF78B0 ON formation_cours');
        $this->addSql('ALTER TABLE formation_cours DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE plage_horaire MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE plage_horaire DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE plage_horaire CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20B6BCB98B');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20290CBC30');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B205200282E');
        $this->addSql('DROP INDEX IDX_7591B20B6BCB98B ON pointage');
        $this->addSql('DROP INDEX IDX_7591B20290CBC30 ON pointage');
        $this->addSql('DROP INDEX IDX_7591B205200282E ON pointage');
        $this->addSql('ALTER TABLE pointage CHANGE utilisateur_etudiant_id utilisateur_etudiant_id INT DEFAULT NULL, CHANGE date_pointage_entree date_pointage_entree DATETIME DEFAULT \'NULL\', CHANGE date_pointage_sortie date_pointage_sortie DATETIME DEFAULT \'NULL\', CHANGE commentaire commentaire VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE commentaire_sortie commentaire_sortie VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pointage RENAME INDEX idx_7591b207ecf78b0 TO FK_7591B207ECF78B0');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B35200282E');
        $this->addSql('ALTER TABLE utilisateur CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE roles roles VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE numero_etudiant numero_etudiant VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur_cours DROP FOREIGN KEY FK_3B0FD4427ECF78B0');
    }
}
