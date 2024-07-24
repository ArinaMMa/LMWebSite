<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724125635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, number_address INT DEFAULT NULL, street_address VARCHAR(255) NOT NULL, zip_code_address INT NOT NULL, city_address VARCHAR(255) NOT NULL, country_address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breeder (id INT AUTO_INCREMENT NOT NULL, name_br VARCHAR(255) NOT NULL, siren_br INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE done_prestations (id INT AUTO_INCREMENT NOT NULL, date_prestation DATE NOT NULL, service_price_fixed INT NOT NULL, quantity INT NOT NULL, commentary_prestation LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horse (id INT AUTO_INCREMENT NOT NULL, breed_ho VARCHAR(255) NOT NULL, sex_ho VARCHAR(255) NOT NULL, birthdate_ho DATE NOT NULL, name_ho VARCHAR(255) NOT NULL, picture_ho VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name_service VARCHAR(255) NOT NULL, description_service LONGTEXT NOT NULL, minimum_duration_service VARCHAR(255) DEFAULT NULL, price_service INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vet (id INT AUTO_INCREMENT NOT NULL, lastname_vet VARCHAR(255) NOT NULL, firstname_vet VARCHAR(255) NOT NULL, email_vet VARCHAR(255) NOT NULL, tel_vet VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE breeder');
        $this->addSql('DROP TABLE done_prestations');
        $this->addSql('DROP TABLE horse');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE vet');
    }
}
