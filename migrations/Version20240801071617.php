<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801071617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse_vet DROP FOREIGN KEY FK_231AE28476B275AD');
        $this->addSql('ALTER TABLE horse_vet ADD CONSTRAINT FK_231AE28476B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse_vet DROP FOREIGN KEY FK_231AE28476B275AD');
        $this->addSql('ALTER TABLE horse_vet ADD CONSTRAINT FK_231AE28476B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
