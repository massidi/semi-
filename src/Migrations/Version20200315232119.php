<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200315232119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctor ADD medic_prescription_id INT NOT NULL');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A319AA59E FOREIGN KEY (medic_prescription_id) REFERENCES medic_prescription (id)');
        $this->addSql('CREATE INDEX IDX_1FC0F36A319AA59E ON doctor (medic_prescription_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A319AA59E');
        $this->addSql('DROP INDEX IDX_1FC0F36A319AA59E ON doctor');
        $this->addSql('ALTER TABLE doctor DROP medic_prescription_id');
    }
}
