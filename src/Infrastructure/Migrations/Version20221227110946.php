<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227110946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `attachment_attachment` (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_content ADD attachment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application_content ADD CONSTRAINT FK_157B359A464E68B FOREIGN KEY (attachment_id) REFERENCES `attachment_attachment` (id)');
        $this->addSql('CREATE INDEX IDX_157B359A464E68B ON application_content (attachment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `application_content` DROP FOREIGN KEY FK_157B359A464E68B');
        $this->addSql('DROP TABLE `attachment_attachment`');
        $this->addSql('DROP INDEX IDX_157B359A464E68B ON `application_content`');
        $this->addSql('ALTER TABLE `application_content` DROP attachment_id');
    }
}
