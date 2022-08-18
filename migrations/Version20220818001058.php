<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818001058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise ADD address VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL, ADD whey_sale TINYINT(1) NOT NULL, ADD towel_sale TINYINT(1) NOT NULL, ADD drink_sale TINYINT(1) NOT NULL, ADD payment_day TINYINT(1) NOT NULL, ADD late_closing TINYINT(1) NOT NULL, ADD send_newsletter TINYINT(1) NOT NULL, ADD roles JSON NOT NULL, DROP adresse, DROP code_postal, DROP vente_whey, DROP vente_serviette, DROP vente_boisson, DROP jour_paiement, DROP fermeture_tardive, DROP envoi_newsletter, CHANGE active active TINYINT(1) NOT NULL, CHANGE sauna sauna TINYINT(1) NOT NULL, CHANGE ring_boxe ring_boxe TINYINT(1) NOT NULL, CHANGE crossfit crossfit TINYINT(1) NOT NULL, CHANGE biking biking TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE structure ADD roles JSON NOT NULL, CHANGE active active TINYINT(1) NOT NULL, CHANGE vente_whey vente_whey TINYINT(1) NOT NULL, CHANGE vente_serviette vente_serviette TINYINT(1) NOT NULL, CHANGE vente_boisson vente_boisson TINYINT(1) NOT NULL, CHANGE sauna sauna TINYINT(1) NOT NULL, CHANGE jour_paiement jour_paiement TINYINT(1) NOT NULL, CHANGE fermeture_tardive fermeture_tardive TINYINT(1) NOT NULL, CHANGE envoi_newsletter envoi_newsletter TINYINT(1) NOT NULL, CHANGE ring_boxe ring_boxe TINYINT(1) NOT NULL, CHANGE crossfit crossfit TINYINT(1) NOT NULL, CHANGE biking biking TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise ADD adresse VARCHAR(255) NOT NULL, ADD code_postal VARCHAR(255) NOT NULL, ADD vente_whey SMALLINT NOT NULL, ADD vente_serviette SMALLINT NOT NULL, ADD vente_boisson SMALLINT NOT NULL, ADD jour_paiement SMALLINT NOT NULL, ADD fermeture_tardive SMALLINT NOT NULL, ADD envoi_newsletter SMALLINT NOT NULL, DROP address, DROP postal_code, DROP whey_sale, DROP towel_sale, DROP drink_sale, DROP payment_day, DROP late_closing, DROP send_newsletter, DROP roles, CHANGE active active SMALLINT NOT NULL, CHANGE sauna sauna SMALLINT NOT NULL, CHANGE ring_boxe ring_boxe SMALLINT NOT NULL, CHANGE crossfit crossfit SMALLINT NOT NULL, CHANGE biking biking SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE structure DROP roles, CHANGE active active SMALLINT NOT NULL, CHANGE vente_whey vente_whey SMALLINT NOT NULL, CHANGE vente_serviette vente_serviette SMALLINT NOT NULL, CHANGE vente_boisson vente_boisson SMALLINT NOT NULL, CHANGE sauna sauna SMALLINT NOT NULL, CHANGE jour_paiement jour_paiement SMALLINT NOT NULL, CHANGE fermeture_tardive fermeture_tardive SMALLINT NOT NULL, CHANGE envoi_newsletter envoi_newsletter SMALLINT NOT NULL, CHANGE ring_boxe ring_boxe SMALLINT NOT NULL, CHANGE crossfit crossfit SMALLINT NOT NULL, CHANGE biking biking SMALLINT NOT NULL');
    }
}
