<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723083806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `comment_comments` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', content_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) DEFAULT NULL, username VARCHAR(180) DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_42DAF52CF675F31B (author_id), INDEX IDX_42DAF52C727ACA70 (parent_id), INDEX IDX_42DAF52C84A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `comment_comments` ADD CONSTRAINT FK_42DAF52CF675F31B FOREIGN KEY (author_id) REFERENCES `auth_users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `comment_comments` ADD CONSTRAINT FK_42DAF52C727ACA70 FOREIGN KEY (parent_id) REFERENCES `comment_comments` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `comment_comments` ADD CONSTRAINT FK_42DAF52C84A0A3ED FOREIGN KEY (content_id) REFERENCES `application_contents` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `comment_comments` DROP FOREIGN KEY FK_42DAF52CF675F31B');
        $this->addSql('ALTER TABLE `comment_comments` DROP FOREIGN KEY FK_42DAF52C727ACA70');
        $this->addSql('ALTER TABLE `comment_comments` DROP FOREIGN KEY FK_42DAF52C84A0A3ED');
        $this->addSql('DROP TABLE `comment_comments`');
    }
}
