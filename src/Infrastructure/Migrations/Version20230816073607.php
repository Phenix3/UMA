<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816073607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_page_translations ADD translatable_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD locale VARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE page_page_translations ADD CONSTRAINT FK_F7AFEF7E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES `page_pages` (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F7AFEF7E2C2AC5D3 ON page_page_translations (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX page_page_translations_unique_translation ON page_page_translations (translatable_id, locale)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `page_page_translations` DROP FOREIGN KEY FK_F7AFEF7E2C2AC5D3');
        $this->addSql('DROP INDEX IDX_F7AFEF7E2C2AC5D3 ON `page_page_translations`');
        $this->addSql('DROP INDEX page_page_translations_unique_translation ON `page_page_translations`');
        $this->addSql('ALTER TABLE `page_page_translations` DROP translatable_id, DROP locale');
    }
}
