<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905160303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, email VARCHAR(191) NOT NULL, password VARCHAR(191) DEFAULT NULL, city VARCHAR(191) NOT NULL, active TINYINT(1) NOT NULL, whey_sale TINYINT(1) NOT NULL, towel_sale TINYINT(1) NOT NULL, drink_sale TINYINT(1) NOT NULL, sauna TINYINT(1) NOT NULL, payment_day TINYINT(1) NOT NULL, late_closing TINYINT(1) NOT NULL, send_newsletter TINYINT(1) NOT NULL, ring_boxe TINYINT(1) NOT NULL, crossfit TINYINT(1) NOT NULL, biking TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, activation_token VARCHAR(191) DEFAULT NULL, password_token VARCHAR(191) DEFAULT NULL, UNIQUE INDEX UNIQ_66F6CE2ABEAB6C24 (password_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, name VARCHAR(191) NOT NULL, email VARCHAR(191) NOT NULL, password VARCHAR(191) DEFAULT NULL, address VARCHAR(191) NOT NULL, postal_code VARCHAR(191) NOT NULL, city VARCHAR(191) NOT NULL, short_description LONGTEXT DEFAULT NULL, full_description LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, whey_sale TINYINT(1) NOT NULL, towel_sale TINYINT(1) NOT NULL, drink_sale TINYINT(1) NOT NULL, sauna TINYINT(1) NOT NULL, payment_day TINYINT(1) NOT NULL, late_closing TINYINT(1) NOT NULL, send_newsletter TINYINT(1) NOT NULL, ring_boxe TINYINT(1) NOT NULL, crossfit TINYINT(1) NOT NULL, biking TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, activation_token VARCHAR(191) DEFAULT NULL, password_token VARCHAR(191) DEFAULT NULL, franchise_validated TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6F0137EABEAB6C24 (password_token), INDEX IDX_6F0137EA523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA523CAB89');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
