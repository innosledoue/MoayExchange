<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825074849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD super_admin TINYINT(1) NOT NULL, ADD admin_role TINYINT(1) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL, CHANGE reset_token reset_token VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP super_admin, DROP admin_role, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(100) DEFAULT NULL');
    }
}
