<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210052551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE medic_prescription (id INT AUTO_INCREMENT NOT NULL, date_of_birth DATETIME NOT NULL, age VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, diagnostic VARCHAR(255) NOT NULL, blood_pressure VARCHAR(255) NOT NULL, pulse_rate VARCHAR(255) NOT NULL, drug VARCHAR(255) NOT NULL, unite VARCHAR(255) NOT NULL, dosage VARCHAR(255) NOT NULL, examination VARCHAR(255) NOT NULL, health_regine VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, age INT NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, prescriptions VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE medic_prescription');
        $this->addSql('DROP TABLE user');
    }
}
