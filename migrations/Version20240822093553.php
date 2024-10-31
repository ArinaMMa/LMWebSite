<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822093553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F18DC2902E0');
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F18F34B011E');
        $this->addSql('DROP INDEX IDX_629A2F18DC2902E0 ON horse');
        $this->addSql('DROP INDEX IDX_629A2F18F34B011E ON horse');
        $this->addSql('ALTER TABLE horse ADD client_id INT NOT NULL, ADD breeder_id INT NOT NULL, DROP client_id_id, DROP breeder_ho_id');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F1819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F1833C95BB1 FOREIGN KEY (breeder_id) REFERENCES breeder (id)');
        $this->addSql('CREATE INDEX IDX_629A2F1819EB6921 ON horse (client_id)');
        $this->addSql('CREATE INDEX IDX_629A2F1833C95BB1 ON horse (breeder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F1819EB6921');
        $this->addSql('ALTER TABLE horse DROP FOREIGN KEY FK_629A2F1833C95BB1');
        $this->addSql('DROP INDEX IDX_629A2F1819EB6921 ON horse');
        $this->addSql('DROP INDEX IDX_629A2F1833C95BB1 ON horse');
        $this->addSql('ALTER TABLE horse ADD client_id_id INT NOT NULL, ADD breeder_ho_id INT NOT NULL, DROP client_id, DROP breeder_id');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F18DC2902E0 FOREIGN KEY (client_id_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE horse ADD CONSTRAINT FK_629A2F18F34B011E FOREIGN KEY (breeder_ho_id) REFERENCES breeder (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_629A2F18DC2902E0 ON horse (client_id_id)');
        $this->addSql('CREATE INDEX IDX_629A2F18F34B011E ON horse (breeder_ho_id)');
    }
}
