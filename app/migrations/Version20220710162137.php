<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710162137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT fk_57cf78954b9d732');
        $this->addSql('DROP INDEX idx_57cf78954b9d732');
        $this->addSql('ALTER TABLE festival DROP icon_id');
        $this->addSql('ALTER TABLE festival DROP programmation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE festival ADD icon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE festival ADD programmation JSON NOT NULL');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT fk_57cf78954b9d732 FOREIGN KEY (icon_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_57cf78954b9d732 ON festival (icon_id)');
    }
}
