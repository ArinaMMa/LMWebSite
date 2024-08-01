<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725145116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse ADD breeder_ho_id INT NOT NULL');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F18F34B011E FOREIGN KEY (breeder_ho_id) REFERENCES breeder (id)');
        $this->addSql('CREATE INDEX IDX_629A2F18F34B011E ON horse (breeder_ho_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F18F34B011E');
        $this->addSql('DROP INDEX IDX_629A2F18F34B011E ON horse');
        $this->addSql('ALTER TABLE horse DROP breeder_ho_id');
    }
}
