<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724142708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horse_done_prestations (horse_id INT NOT NULL, done_prestations_id INT NOT NULL, INDEX IDX_14BBF5F976B275AD (horse_id), INDEX IDX_14BBF5F9B8C2FEE5 (done_prestations_id), PRIMARY KEY(horse_id, done_prestations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horse_vet (horse_id INT NOT NULL, vet_id INT NOT NULL, INDEX IDX_231AE28476B275AD (horse_id), INDEX IDX_231AE28440369CAB (vet_id), PRIMARY KEY(horse_id, vet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horse_done_prestations ADD CONSTRAINT FK_14BBF5F976B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horse_done_prestations ADD CONSTRAINT FK_14BBF5F9B8C2FEE5 FOREIGN KEY (done_prestations_id) REFERENCES done_prestations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horse_vet ADD CONSTRAINT FK_231AE28476B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horse_vet ADD CONSTRAINT FK_231AE28440369CAB FOREIGN KEY (vet_id) REFERENCES vet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horse ADD client_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F18DC2902E0 FOREIGN KEY (client_id_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_629A2F18DC2902E0 ON horse (client_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse_done_prestations DROP FOREIGN KEY FK_14BBF5F976B275AD');
        $this->addSql('ALTER TABLE horse_done_prestations DROP FOREIGN KEY FK_14BBF5F9B8C2FEE5');
        $this->addSql('ALTER TABLE horse_vet DROP FOREIGN KEY FK_231AE28476B275AD');
        $this->addSql('ALTER TABLE horse_vet DROP FOREIGN KEY FK_231AE28440369CAB');
        $this->addSql('DROP TABLE horse_done_prestations');
        $this->addSql('DROP TABLE horse_vet');
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F18DC2902E0');
        $this->addSql('DROP INDEX IDX_629A2F18DC2902E0 ON horse');
        $this->addSql('ALTER TABLE horse DROP client_id_id');
    }
}
