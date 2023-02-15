<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123135853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX key_idx ON application_setting');
        $this->addSql('DROP INDEX `primary` ON application_setting');
        $this->addSql('ALTER TABLE application_setting CHANGE `key` key_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE application_setting ADD PRIMARY KEY (key_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON `application_setting`');
        $this->addSql('ALTER TABLE `application_setting` CHANGE key_name `key` VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX key_idx ON `application_setting` (`key`)');
        $this->addSql('ALTER TABLE `application_setting` ADD PRIMARY KEY (`key`)');
    }
}
