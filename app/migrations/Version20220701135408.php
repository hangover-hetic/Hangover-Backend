<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701135408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE organisation_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE singer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE organisation_message (id INT NOT NULL, festival_id INT DEFAULT NULL, level INT NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, message VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D539477C8AEBAF57 ON organisation_message (festival_id)');
        $this->addSql('CREATE TABLE singer (id INT NOT NULL, image_id INT DEFAULT NULL, festival_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98B619973DA5256D ON singer (image_id)');
        $this->addSql('CREATE INDEX IDX_98B619978AEBAF57 ON singer (festival_id)');
        $this->addSql('ALTER TABLE organisation_message ADD CONSTRAINT FK_D539477C8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE singer ADD CONSTRAINT FK_98B619973DA5256D FOREIGN KEY (image_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE singer ADD CONSTRAINT FK_98B619978AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival ADD icon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF78954B9D732 FOREIGN KEY (icon_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_57CF78954B9D732 ON festival (icon_id)');
        $this->addSql('ALTER TABLE "user" ADD ghost_mode BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE organisation_message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE singer_id_seq CASCADE');
        $this->addSql('DROP TABLE organisation_message');
        $this->addSql('DROP TABLE singer');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF78954B9D732');
        $this->addSql('DROP INDEX IDX_57CF78954B9D732');
        $this->addSql('ALTER TABLE festival DROP icon_id');
        $this->addSql('ALTER TABLE "user" DROP ghost_mode');
    }
}
