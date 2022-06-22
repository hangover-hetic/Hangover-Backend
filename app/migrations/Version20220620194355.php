<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620194355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8d41a67722');
        $this->addSql('DROP SEQUENCE screen_id_seq CASCADE');
        $this->addSql('CREATE TABLE festival_screen_template (festival_id INT NOT NULL, screen_template_id INT NOT NULL, PRIMARY KEY(festival_id, screen_template_id))');
        $this->addSql('CREATE INDEX IDX_19213B538AEBAF57 ON festival_screen_template (festival_id)');
        $this->addSql('CREATE INDEX IDX_19213B53912CAB7C ON festival_screen_template (screen_template_id)');
        $this->addSql('ALTER TABLE festival_screen_template ADD CONSTRAINT FK_19213B538AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_screen_template ADD CONSTRAINT FK_19213B53912CAB7C FOREIGN KEY (screen_template_id) REFERENCES screen_template (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE screen');
        $this->addSql('DROP INDEX idx_5a8a6c8d41a67722');
        $this->addSql('ALTER TABLE post RENAME COLUMN screen_id TO festival_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8AEBAF57 ON post (festival_id)');
        $this->addSql('ALTER TABLE screen_template ADD disposition JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE screen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE screen (id INT NOT NULL, festival_id INT NOT NULL, template_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_df4c61308aebaf57 ON screen (festival_id)');
        $this->addSql('CREATE INDEX idx_df4c61305da0fb8 ON screen (template_id)');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT fk_df4c61308aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT fk_df4c61305da0fb8 FOREIGN KEY (template_id) REFERENCES screen_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE festival_screen_template');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D8AEBAF57');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8AEBAF57');
        $this->addSql('ALTER TABLE post RENAME COLUMN festival_id TO screen_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d41a67722 FOREIGN KEY (screen_id) REFERENCES screen (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a8a6c8d41a67722 ON post (screen_id)');
        $this->addSql('ALTER TABLE screen_template DROP disposition');
    }
}
