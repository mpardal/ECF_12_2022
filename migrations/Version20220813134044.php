<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813134044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD franchise_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAEA39FCC8 FOREIGN KEY (franchise_id_id) REFERENCES franchise (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EAEA39FCC8 ON structure (franchise_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAEA39FCC8');
        $this->addSql('DROP INDEX IDX_6F0137EAEA39FCC8 ON structure');
        $this->addSql('ALTER TABLE structure DROP franchise_id_id');
    }
}
