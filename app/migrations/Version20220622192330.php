<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622192330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_festival_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE inscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, festival_id INT DEFAULT NULL, related_user_id INT NOT NULL, ticket_path VARCHAR(255) NOT NULL, agenda JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D68AEBAF57 ON inscription (festival_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D698771930 ON inscription (related_user_id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D698771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE user_festival');
        $this->addSql('ALTER TABLE festival ADD cover_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF789922726E9 FOREIGN KEY (cover_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_57CF789922726E9 ON festival (cover_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE inscription_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_festival_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_festival (id INT NOT NULL, festival_id INT DEFAULT NULL, related_user_id INT NOT NULL, ticket_path VARCHAR(255) NOT NULL, agenda JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_e5f113898aebaf57 ON user_festival (festival_id)');
        $this->addSql('CREATE INDEX idx_e5f1138998771930 ON user_festival (related_user_id)');
        $this->addSql('ALTER TABLE user_festival ADD CONSTRAINT fk_e5f113898aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_festival ADD CONSTRAINT fk_e5f1138998771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF789922726E9');
        $this->addSql('DROP INDEX IDX_57CF789922726E9');
        $this->addSql('ALTER TABLE festival DROP cover_id');
    }
}
