<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708103012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE organisation_message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE singer_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE screen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE show_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sponsor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE screen (id INT NOT NULL, festival_id INT NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF4C61308AEBAF57 ON screen (festival_id)');
        $this->addSql('CREATE TABLE show (id INT NOT NULL, image_id INT DEFAULT NULL, festival_id INT NOT NULL, name VARCHAR(255) NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_320ED9013DA5256D ON show (image_id)');
        $this->addSql('CREATE INDEX IDX_320ED9018AEBAF57 ON show (festival_id)');
        $this->addSql('COMMENT ON COLUMN show.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN show.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE sponsor (id INT NOT NULL, logo_id INT DEFAULT NULL, festival_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_818CC9D4F98F144A ON sponsor (logo_id)');
        $this->addSql('CREATE INDEX IDX_818CC9D48AEBAF57 ON sponsor (festival_id)');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61308AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show ADD CONSTRAINT FK_320ED9013DA5256D FOREIGN KEY (image_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show ADD CONSTRAINT FK_320ED9018AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4F98F144A FOREIGN KEY (logo_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D48AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE organisation_message');
        $this->addSql('DROP TABLE singer');
        $this->addSql('ALTER TABLE festival ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF789F98F144A FOREIGN KEY (logo_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_57CF789F98F144A ON festival (logo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE screen_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE show_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sponsor_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE organisation_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE singer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE organisation_message (id INT NOT NULL, festival_id INT DEFAULT NULL, level INT NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, message VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d539477c8aebaf57 ON organisation_message (festival_id)');
        $this->addSql('CREATE TABLE singer (id INT NOT NULL, image_id INT DEFAULT NULL, festival_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_98b619978aebaf57 ON singer (festival_id)');
        $this->addSql('CREATE INDEX idx_98b619973da5256d ON singer (image_id)');
        $this->addSql('ALTER TABLE organisation_message ADD CONSTRAINT fk_d539477c8aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE singer ADD CONSTRAINT fk_98b619978aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE singer ADD CONSTRAINT fk_98b619973da5256d FOREIGN KEY (image_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE screen');
        $this->addSql('DROP TABLE show');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF789F98F144A');
        $this->addSql('DROP INDEX IDX_57CF789F98F144A');
        $this->addSql('ALTER TABLE festival DROP logo_id');
    }
}
