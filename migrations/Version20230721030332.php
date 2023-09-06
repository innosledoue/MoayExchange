<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721030332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taux_change ADD crypto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taux_change ADD CONSTRAINT FK_FAD035B1E9571A63 FOREIGN KEY (crypto_id) REFERENCES crypto_monnaie (id)');
        $this->addSql('CREATE INDEX IDX_FAD035B1E9571A63 ON taux_change (crypto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taux_change DROP FOREIGN KEY FK_FAD035B1E9571A63');
        $this->addSql('DROP INDEX IDX_FAD035B1E9571A63 ON taux_change');
        $this->addSql('ALTER TABLE taux_change DROP crypto_id');
    }
}
