<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620195647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD media_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD related_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE post DROP image');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D98771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DEA9FDD75 ON post (media_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D98771930 ON post (related_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DEA9FDD75');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D98771930');
        $this->addSql('DROP INDEX IDX_5A8A6C8DEA9FDD75');
        $this->addSql('DROP INDEX IDX_5A8A6C8D98771930');
        $this->addSql('ALTER TABLE post ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post DROP media_id');
        $this->addSql('ALTER TABLE post DROP related_user_id');
    }
}
