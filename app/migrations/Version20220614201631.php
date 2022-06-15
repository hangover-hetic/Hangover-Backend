<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614201631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE festival_media (festival_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(festival_id, media_id))');
        $this->addSql('CREATE INDEX IDX_49D59028AEBAF57 ON festival_media (festival_id)');
        $this->addSql('CREATE INDEX IDX_49D5902EA9FDD75 ON festival_media (media_id)');
        $this->addSql('ALTER TABLE festival_media ADD CONSTRAINT FK_49D59028AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_media ADD CONSTRAINT FK_49D5902EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival DROP gallery');
        $this->addSql('ALTER TABLE media ADD festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6A2CA10C8AEBAF57 ON media (festival_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE festival_media');
        $this->addSql('ALTER TABLE festival ADD gallery TEXT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN festival.gallery IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C8AEBAF57');
        $this->addSql('DROP INDEX IDX_6A2CA10C8AEBAF57');
        $this->addSql('ALTER TABLE media DROP festival_id');
    }
}
