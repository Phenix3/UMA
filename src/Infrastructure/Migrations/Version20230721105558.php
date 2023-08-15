<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721105558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `application_contents` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', attachment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME DEFAULT CURRENT_TIMESTAMP, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_BC1CE64464E68B (attachment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `application_settings` (key_name VARCHAR(255) NOT NULL, value LONGTEXT NOT NULL, INDEX key_idx (key_name), PRIMARY KEY(key_name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `attachment_attachments` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', file_name VARCHAR(255) NOT NULL, file_size INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `auth_users` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D8A1F49CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `blog_categories` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, posts_count INT UNSIGNED NOT NULL, enabled TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `blog_posts` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (post_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `contact_contact_requests` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ip VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `profile_profile_pictures` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', file_name VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_ADC0C109DE12AB56 (created_by), INDEX IDX_ADC0C10916FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `profile_profiles` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', picture_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', updated_by BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(50) NOT NULL, slug VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_725AE481989D9B62 (slug), UNIQUE INDEX UNIQ_725AE481A76ED395 (user_id), UNIQUE INDEX UNIQ_725AE481EE45BDBF (picture_id), INDEX IDX_725AE481DE12AB56 (created_by), INDEX IDX_725AE48116FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `slider_slider_items` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', slider_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_4DBC40FB2CCC9638 (slider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `slider_sliders` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FB5EB8145E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `application_contents` ADD CONSTRAINT FK_BC1CE64464E68B FOREIGN KEY (attachment_id) REFERENCES `attachment_attachments` (id)');
        $this->addSql('ALTER TABLE `blog_posts` ADD CONSTRAINT FK_78B2F932BF396750 FOREIGN KEY (id) REFERENCES `application_contents` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES `blog_posts` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES `blog_categories` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `profile_profile_pictures` ADD CONSTRAINT FK_ADC0C109DE12AB56 FOREIGN KEY (created_by) REFERENCES `auth_users` (id)');
        $this->addSql('ALTER TABLE `profile_profile_pictures` ADD CONSTRAINT FK_ADC0C10916FE72E1 FOREIGN KEY (updated_by) REFERENCES `auth_users` (id)');
        $this->addSql('ALTER TABLE `profile_profiles` ADD CONSTRAINT FK_725AE481A76ED395 FOREIGN KEY (user_id) REFERENCES `auth_users` (id)');
        $this->addSql('ALTER TABLE `profile_profiles` ADD CONSTRAINT FK_725AE481EE45BDBF FOREIGN KEY (picture_id) REFERENCES `profile_profile_pictures` (id)');
        $this->addSql('ALTER TABLE `profile_profiles` ADD CONSTRAINT FK_725AE481DE12AB56 FOREIGN KEY (created_by) REFERENCES `auth_users` (id)');
        $this->addSql('ALTER TABLE `profile_profiles` ADD CONSTRAINT FK_725AE48116FE72E1 FOREIGN KEY (updated_by) REFERENCES `auth_users` (id)');
        $this->addSql('ALTER TABLE `slider_slider_items` ADD CONSTRAINT FK_4DBC40FB2CCC9638 FOREIGN KEY (slider_id) REFERENCES `slider_sliders` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `application_contents` DROP FOREIGN KEY FK_BC1CE64464E68B');
        $this->addSql('ALTER TABLE `blog_posts` DROP FOREIGN KEY FK_78B2F932BF396750');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A1906012469DE2');
        $this->addSql('ALTER TABLE `profile_profile_pictures` DROP FOREIGN KEY FK_ADC0C109DE12AB56');
        $this->addSql('ALTER TABLE `profile_profile_pictures` DROP FOREIGN KEY FK_ADC0C10916FE72E1');
        $this->addSql('ALTER TABLE `profile_profiles` DROP FOREIGN KEY FK_725AE481A76ED395');
        $this->addSql('ALTER TABLE `profile_profiles` DROP FOREIGN KEY FK_725AE481EE45BDBF');
        $this->addSql('ALTER TABLE `profile_profiles` DROP FOREIGN KEY FK_725AE481DE12AB56');
        $this->addSql('ALTER TABLE `profile_profiles` DROP FOREIGN KEY FK_725AE48116FE72E1');
        $this->addSql('ALTER TABLE `slider_slider_items` DROP FOREIGN KEY FK_4DBC40FB2CCC9638');
        $this->addSql('DROP TABLE `application_contents`');
        $this->addSql('DROP TABLE `application_settings`');
        $this->addSql('DROP TABLE `attachment_attachments`');
        $this->addSql('DROP TABLE `auth_users`');
        $this->addSql('DROP TABLE `blog_categories`');
        $this->addSql('DROP TABLE `blog_posts`');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE `contact_contact_requests`');
        $this->addSql('DROP TABLE `profile_profile_pictures`');
        $this->addSql('DROP TABLE `profile_profiles`');
        $this->addSql('DROP TABLE `slider_slider_items`');
        $this->addSql('DROP TABLE `slider_sliders`');
    }
}
