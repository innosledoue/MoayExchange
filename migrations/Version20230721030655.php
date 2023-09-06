<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721030655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions ADD crypto_id INT DEFAULT NULL, ADD expediteur_id INT DEFAULT NULL, ADD recepteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CE9571A63 FOREIGN KEY (crypto_id) REFERENCES crypto_monnaie (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C10335F61 FOREIGN KEY (expediteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C3B49782D FOREIGN KEY (recepteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CE9571A63 ON transactions (crypto_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C10335F61 ON transactions (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C3B49782D ON transactions (recepteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CE9571A63');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C10335F61');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C3B49782D');
        $this->addSql('DROP INDEX IDX_EAA81A4CE9571A63 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4C10335F61 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4C3B49782D ON transactions');
        $this->addSql('ALTER TABLE transactions DROP crypto_id, DROP expediteur_id, DROP recepteur_id');
    }
}
