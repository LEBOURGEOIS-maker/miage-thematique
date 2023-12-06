<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306085733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3220CFB9C FOREIGN KEY (detenir_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20C4F82548 FOREIGN KEY (respecter_id) REFERENCES plage_horaire (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20E977E148 FOREIGN KEY (appartenir_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2E58DA11D FOREIGN KEY (pointage_id) REFERENCES pointage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage_admin ADD CONSTRAINT FK_A1E014E2642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3220CFB9C');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20DDEAB1A3');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20C4F82548');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20E977E148');
        $this->addSql('ALTER TABLE pointage_admin DROP FOREIGN KEY FK_A1E014E2E58DA11D');
        $this->addSql('ALTER TABLE pointage_admin DROP FOREIGN KEY FK_A1E014E2642B8210');
    }
}
