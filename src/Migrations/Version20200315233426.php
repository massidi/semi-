<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200315233426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE medic_prescription ADD doctor_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medic_prescription ADD CONSTRAINT FK_9720D6F832B07E31 FOREIGN KEY (doctor_id_id) REFERENCES doctor (id)');
        $this->addSql('CREATE INDEX IDX_9720D6F832B07E31 ON medic_prescription (doctor_id_id)');
        $this->addSql('ALTER TABLE doctor DROP medic_prescription_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctor ADD medic_prescription_id INT NOT NULL');
        $this->addSql('ALTER TABLE medic_prescription DROP FOREIGN KEY FK_9720D6F832B07E31');
        $this->addSql('DROP INDEX IDX_9720D6F832B07E31 ON medic_prescription');
        $this->addSql('ALTER TABLE medic_prescription DROP doctor_id_id');
    }
}
