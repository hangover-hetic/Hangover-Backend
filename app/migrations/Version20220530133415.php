<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530133415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE festival ADD organisation_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF7894AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_57CF7894AE8AFAD ON festival (organisation_team_id)');
        $this->addSql('ALTER TABLE package ADD festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867958AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DE6867958AEBAF57 ON package (festival_id)');
        $this->addSql('ALTER TABLE post ADD screen_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D41A67722 FOREIGN KEY (screen_id) REFERENCES screen (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D41A67722 ON post (screen_id)');
        $this->addSql('ALTER TABLE screen ADD festival_id INT NOT NULL');
        $this->addSql('ALTER TABLE screen ADD template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61308AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61305DA0FB8 FOREIGN KEY (template_id) REFERENCES screen_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DF4C61308AEBAF57 ON screen (festival_id)');
        $this->addSql('CREATE INDEX IDX_DF4C61305DA0FB8 ON screen (template_id)');
        $this->addSql('ALTER TABLE user_festival ADD festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_festival ADD related_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_festival ADD CONSTRAINT FK_E5F113898AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_festival ADD CONSTRAINT FK_E5F1138998771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E5F113898AEBAF57 ON user_festival (festival_id)');
        $this->addSql('CREATE INDEX IDX_E5F1138998771930 ON user_festival (related_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF7894AE8AFAD');
        $this->addSql('DROP INDEX IDX_57CF7894AE8AFAD');
        $this->addSql('ALTER TABLE festival DROP organisation_team_id');
        $this->addSql('ALTER TABLE package DROP CONSTRAINT FK_DE6867958AEBAF57');
        $this->addSql('DROP INDEX IDX_DE6867958AEBAF57');
        $this->addSql('ALTER TABLE package DROP festival_id');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D41A67722');
        $this->addSql('DROP INDEX IDX_5A8A6C8D41A67722');
        $this->addSql('ALTER TABLE post DROP screen_id');
        $this->addSql('ALTER TABLE screen DROP CONSTRAINT FK_DF4C61308AEBAF57');
        $this->addSql('ALTER TABLE screen DROP CONSTRAINT FK_DF4C61305DA0FB8');
        $this->addSql('DROP INDEX IDX_DF4C61308AEBAF57');
        $this->addSql('DROP INDEX IDX_DF4C61305DA0FB8');
        $this->addSql('ALTER TABLE screen DROP festival_id');
        $this->addSql('ALTER TABLE screen DROP template_id');
        $this->addSql('ALTER TABLE user_festival DROP CONSTRAINT FK_E5F113898AEBAF57');
        $this->addSql('ALTER TABLE user_festival DROP CONSTRAINT FK_E5F1138998771930');
        $this->addSql('DROP INDEX IDX_E5F113898AEBAF57');
        $this->addSql('DROP INDEX IDX_E5F1138998771930');
        $this->addSql('ALTER TABLE user_festival DROP festival_id');
        $this->addSql('ALTER TABLE user_festival DROP related_user_id');
    }
}
