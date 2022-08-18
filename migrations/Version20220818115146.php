<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818115146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD address VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL, ADD whey_sale TINYINT(1) NOT NULL, ADD towel_sale TINYINT(1) NOT NULL, ADD drink_sale TINYINT(1) NOT NULL, ADD payment_day TINYINT(1) NOT NULL, ADD late_closing TINYINT(1) NOT NULL, ADD send_newsletter TINYINT(1) NOT NULL, DROP adresse, DROP code_postal, DROP vente_whey, DROP vente_serviette, DROP vente_boisson, DROP jour_paiement, DROP fermeture_tardive, DROP envoi_newsletter');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD adresse VARCHAR(255) NOT NULL, ADD code_postal VARCHAR(255) NOT NULL, ADD vente_whey TINYINT(1) NOT NULL, ADD vente_serviette TINYINT(1) NOT NULL, ADD vente_boisson TINYINT(1) NOT NULL, ADD jour_paiement TINYINT(1) NOT NULL, ADD fermeture_tardive TINYINT(1) NOT NULL, ADD envoi_newsletter TINYINT(1) NOT NULL, DROP address, DROP postal_code, DROP whey_sale, DROP towel_sale, DROP drink_sale, DROP payment_day, DROP late_closing, DROP send_newsletter');
    }
}
