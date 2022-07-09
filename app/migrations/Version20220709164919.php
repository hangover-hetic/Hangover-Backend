<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709164919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bought_package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE festival_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE friendship_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE inscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE licence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE organisation_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE organisator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE screen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE screen_template_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE show_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sponsor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE style_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bought_package (id INT NOT NULL, related_user_id INT NOT NULL, package_id INT DEFAULT NULL, number INT NOT NULL, picture_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0F0C7AB98771930 ON bought_package (related_user_id)');
        $this->addSql('CREATE INDEX IDX_F0F0C7ABF44CABFF ON bought_package (package_id)');
        $this->addSql('CREATE TABLE festival (id INT NOT NULL, organisation_team_id INT DEFAULT NULL, cover_id INT DEFAULT NULL, icon_id INT DEFAULT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, programmation JSON NOT NULL, status VARCHAR(20) DEFAULT NULL, map JSON NOT NULL, location VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_57CF7894AE8AFAD ON festival (organisation_team_id)');
        $this->addSql('CREATE INDEX IDX_57CF789922726E9 ON festival (cover_id)');
        $this->addSql('CREATE INDEX IDX_57CF78954B9D732 ON festival (icon_id)');
        $this->addSql('CREATE INDEX IDX_57CF789F98F144A ON festival (logo_id)');
        $this->addSql('CREATE TABLE festival_media (festival_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(festival_id, media_id))');
        $this->addSql('CREATE INDEX IDX_49D59028AEBAF57 ON festival_media (festival_id)');
        $this->addSql('CREATE INDEX IDX_49D5902EA9FDD75 ON festival_media (media_id)');
        $this->addSql('CREATE TABLE festival_screen_template (festival_id INT NOT NULL, screen_template_id INT NOT NULL, PRIMARY KEY(festival_id, screen_template_id))');
        $this->addSql('CREATE INDEX IDX_19213B538AEBAF57 ON festival_screen_template (festival_id)');
        $this->addSql('CREATE INDEX IDX_19213B53912CAB7C ON festival_screen_template (screen_template_id)');
        $this->addSql('CREATE TABLE friendship (id INT NOT NULL, related_user_id INT NOT NULL, friend_id INT NOT NULL, validated BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7234A45F98771930 ON friendship (related_user_id)');
        $this->addSql('CREATE INDEX IDX_7234A45F6A5458E8 ON friendship (friend_id)');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, festival_id INT DEFAULT NULL, related_user_id INT NOT NULL, ticket_path VARCHAR(255) DEFAULT NULL, agenda JSON DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D68AEBAF57 ON inscription (festival_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D698771930 ON inscription (related_user_id)');
        $this->addSql('CREATE TABLE licence (id INT NOT NULL, organisation_team_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, is_buyed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DAAE6484AE8AFAD ON licence (organisation_team_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, festival_id INT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10C8AEBAF57 ON media (festival_id)');
        $this->addSql('CREATE TABLE organisation_team (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE organisator (id INT NOT NULL, organisation_team_id INT DEFAULT NULL, related_user_id INT DEFAULT NULL, is_administrator BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8580E584AE8AFAD ON organisator (organisation_team_id)');
        $this->addSql('CREATE INDEX IDX_B8580E5898771930 ON organisator (related_user_id)');
        $this->addSql('CREATE TABLE package (id INT NOT NULL, festival_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, picture_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DE6867958AEBAF57 ON package (festival_id)');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, festival_id INT NOT NULL, media_id INT NOT NULL, related_user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8AEBAF57 ON post (festival_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DEA9FDD75 ON post (media_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D98771930 ON post (related_user_id)');
        $this->addSql('COMMENT ON COLUMN post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE screen (id INT NOT NULL, festival_id INT NOT NULL, token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF4C61308AEBAF57 ON screen (festival_id)');
        $this->addSql('CREATE TABLE screen_template (id INT NOT NULL, name VARCHAR(255) NOT NULL, disposition JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE show (id INT NOT NULL, image_id INT DEFAULT NULL, festival_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_320ED9013DA5256D ON show (image_id)');
        $this->addSql('CREATE INDEX IDX_320ED9018AEBAF57 ON show (festival_id)');
        $this->addSql('COMMENT ON COLUMN show.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN show.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE show_style (show_id INT NOT NULL, style_id INT NOT NULL, PRIMARY KEY(show_id, style_id))');
        $this->addSql('CREATE INDEX IDX_310CDCB6D0C1FC64 ON show_style (show_id)');
        $this->addSql('CREATE INDEX IDX_310CDCB6BACD6074 ON show_style (style_id)');
        $this->addSql('CREATE TABLE sponsor (id INT NOT NULL, logo_id INT DEFAULT NULL, festival_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_818CC9D4F98F144A ON sponsor (logo_id)');
        $this->addSql('CREATE INDEX IDX_818CC9D48AEBAF57 ON sponsor (festival_id)');
        $this->addSql('CREATE TABLE style (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, profile_picture_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address TEXT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, roles TEXT NOT NULL, ghost_mode BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649292E8AE2 ON "user" (profile_picture_id)');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE bought_package ADD CONSTRAINT FK_F0F0C7AB98771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bought_package ADD CONSTRAINT FK_F0F0C7ABF44CABFF FOREIGN KEY (package_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF7894AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF789922726E9 FOREIGN KEY (cover_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF78954B9D732 FOREIGN KEY (icon_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival ADD CONSTRAINT FK_57CF789F98F144A FOREIGN KEY (logo_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_media ADD CONSTRAINT FK_49D59028AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_media ADD CONSTRAINT FK_49D5902EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_screen_template ADD CONSTRAINT FK_19213B538AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_screen_template ADD CONSTRAINT FK_19213B53912CAB7C FOREIGN KEY (screen_template_id) REFERENCES screen_template (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F98771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F6A5458E8 FOREIGN KEY (friend_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D698771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE6484AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisator ADD CONSTRAINT FK_B8580E584AE8AFAD FOREIGN KEY (organisation_team_id) REFERENCES organisation_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisator ADD CONSTRAINT FK_B8580E5898771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867958AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D98771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61308AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show ADD CONSTRAINT FK_320ED9013DA5256D FOREIGN KEY (image_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show ADD CONSTRAINT FK_320ED9018AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show_style ADD CONSTRAINT FK_310CDCB6D0C1FC64 FOREIGN KEY (show_id) REFERENCES show (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE show_style ADD CONSTRAINT FK_310CDCB6BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4F98F144A FOREIGN KEY (logo_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D48AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE festival_media DROP CONSTRAINT FK_49D59028AEBAF57');
        $this->addSql('ALTER TABLE festival_screen_template DROP CONSTRAINT FK_19213B538AEBAF57');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D68AEBAF57');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C8AEBAF57');
        $this->addSql('ALTER TABLE package DROP CONSTRAINT FK_DE6867958AEBAF57');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D8AEBAF57');
        $this->addSql('ALTER TABLE screen DROP CONSTRAINT FK_DF4C61308AEBAF57');
        $this->addSql('ALTER TABLE show DROP CONSTRAINT FK_320ED9018AEBAF57');
        $this->addSql('ALTER TABLE sponsor DROP CONSTRAINT FK_818CC9D48AEBAF57');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF789922726E9');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF78954B9D732');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF789F98F144A');
        $this->addSql('ALTER TABLE festival_media DROP CONSTRAINT FK_49D5902EA9FDD75');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DEA9FDD75');
        $this->addSql('ALTER TABLE show DROP CONSTRAINT FK_320ED9013DA5256D');
        $this->addSql('ALTER TABLE sponsor DROP CONSTRAINT FK_818CC9D4F98F144A');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649292E8AE2');
        $this->addSql('ALTER TABLE festival DROP CONSTRAINT FK_57CF7894AE8AFAD');
        $this->addSql('ALTER TABLE licence DROP CONSTRAINT FK_1DAAE6484AE8AFAD');
        $this->addSql('ALTER TABLE organisator DROP CONSTRAINT FK_B8580E584AE8AFAD');
        $this->addSql('ALTER TABLE bought_package DROP CONSTRAINT FK_F0F0C7ABF44CABFF');
        $this->addSql('ALTER TABLE festival_screen_template DROP CONSTRAINT FK_19213B53912CAB7C');
        $this->addSql('ALTER TABLE show_style DROP CONSTRAINT FK_310CDCB6D0C1FC64');
        $this->addSql('ALTER TABLE show_style DROP CONSTRAINT FK_310CDCB6BACD6074');
        $this->addSql('ALTER TABLE bought_package DROP CONSTRAINT FK_F0F0C7AB98771930');
        $this->addSql('ALTER TABLE friendship DROP CONSTRAINT FK_7234A45F98771930');
        $this->addSql('ALTER TABLE friendship DROP CONSTRAINT FK_7234A45F6A5458E8');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D698771930');
        $this->addSql('ALTER TABLE organisator DROP CONSTRAINT FK_B8580E5898771930');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D98771930');
        $this->addSql('DROP SEQUENCE bought_package_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE festival_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE friendship_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE inscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE licence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE organisation_team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE organisator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE package_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE screen_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE screen_template_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE show_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sponsor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE style_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE bought_package');
        $this->addSql('DROP TABLE festival');
        $this->addSql('DROP TABLE festival_media');
        $this->addSql('DROP TABLE festival_screen_template');
        $this->addSql('DROP TABLE friendship');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE licence');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE organisation_team');
        $this->addSql('DROP TABLE organisator');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE screen');
        $this->addSql('DROP TABLE screen_template');
        $this->addSql('DROP TABLE show');
        $this->addSql('DROP TABLE show_style');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE "user"');
    }
}
