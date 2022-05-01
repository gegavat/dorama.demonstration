<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211140204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configurator_item (id INT AUTO_INCREMENT NOT NULL, configurator_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT DEFAULT 0, INDEX IDX_F10648F5DF663348 (configurator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configurator_item ADD CONSTRAINT FK_F10648F5DF663348 FOREIGN KEY (configurator_id) REFERENCES configurator (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE configurator_item');
    }
}
