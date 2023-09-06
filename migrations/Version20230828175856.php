<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828175856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, je_donne_id INT DEFAULT NULL, je_recois_id INT DEFAULT NULL, montant_envoye DOUBLE PRECISION NOT NULL, montant_recevoir DOUBLE PRECISION NOT NULL, adresse_reception VARCHAR(255) NOT NULL, adresse_envoyeur VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_35D4282CEB82109B (je_donne_id), UNIQUE INDEX UNIQ_35D4282CA1260DAE (je_recois_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CEB82109B FOREIGN KEY (je_donne_id) REFERENCES crypto_monnaie (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA1260DAE FOREIGN KEY (je_recois_id) REFERENCES crypto_monnaie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CEB82109B');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CA1260DAE');
        $this->addSql('DROP TABLE commandes');
    }
}
