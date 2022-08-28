<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826134737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP city, DROP short_description, DROP full_description, DROP address, DROP postal_code');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise ADD city VARCHAR(255) NOT NULL, ADD short_description LONGTEXT DEFAULT NULL, ADD full_description LONGTEXT DEFAULT NULL, ADD address VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL');
    }
}
