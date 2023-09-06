<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721030025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD user_id INT DEFAULT NULL, ADD crypto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FE9571A63 FOREIGN KEY (crypto_id) REFERENCES crypto_monnaie (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FA76ED395 ON annonces (user_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FE9571A63 ON annonces (crypto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FA76ED395');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FE9571A63');
        $this->addSql('DROP INDEX IDX_CB988C6FA76ED395 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FE9571A63 ON annonces');
        $this->addSql('ALTER TABLE annonces DROP user_id, DROP crypto_id');
    }
}
