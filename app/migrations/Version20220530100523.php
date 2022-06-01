<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530100523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE buyed_packaged_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE friend_list_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE bought_package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bought_package (id INT NOT NULL, related_user_id INT NOT NULL, number INT NOT NULL, picture_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0F0C7AB98771930 ON bought_package (related_user_id)');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
        $this->addSql('ALTER TABLE bought_package ADD CONSTRAINT FK_F0F0C7AB98771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE buyed_packaged');
        $this->addSql('DROP TABLE friend_list');
        $this->addSql('ALTER TABLE licence ADD organisation_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE6484AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DAAE6484AE8AFAD ON licence (organisation_team_id)');
        $this->addSql('ALTER TABLE organisator ADD organisation_team_id INT NOT NULL');
        $this->addSql('ALTER TABLE organisator ADD related_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organisator ADD CONSTRAINT FK_B8580E584AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisator ADD CONSTRAINT FK_B8580E5898771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B8580E584AE8AFAD ON organisator (organisation_team_id)');
        $this->addSql('CREATE INDEX IDX_B8580E5898771930 ON organisator (related_user_id)');
        $this->addSql('ALTER TABLE "user" ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bought_package_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE buyed_packaged_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE friend_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE buyed_packaged (id INT NOT NULL, number INT NOT NULL, picture_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE friend_list (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE bought_package');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('ALTER TABLE licence DROP CONSTRAINT FK_1DAAE6484AE8AFAD');
        $this->addSql('DROP INDEX UNIQ_1DAAE6484AE8AFAD');
        $this->addSql('ALTER TABLE licence DROP organisation_team_id');
        $this->addSql('ALTER TABLE organisator DROP CONSTRAINT FK_B8580E584AE8AFAD');
        $this->addSql('ALTER TABLE organisator DROP CONSTRAINT FK_B8580E5898771930');
        $this->addSql('DROP INDEX IDX_B8580E584AE8AFAD');
        $this->addSql('DROP INDEX IDX_B8580E5898771930');
        $this->addSql('ALTER TABLE organisator DROP organisation_team_id');
        $this->addSql('ALTER TABLE organisator DROP related_user_id');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC');
        $this->addSql('ALTER TABLE "user" DROP role_id');
    }
}
