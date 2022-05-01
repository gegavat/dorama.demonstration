<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211131537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configurator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configurator_product (configurator_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C5A84231DF663348 (configurator_id), INDEX IDX_C5A842314584665A (product_id), PRIMARY KEY(configurator_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configurator_product ADD CONSTRAINT FK_C5A84231DF663348 FOREIGN KEY (configurator_id) REFERENCES configurator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE configurator_product ADD CONSTRAINT FK_C5A842314584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE configurator_product DROP FOREIGN KEY FK_C5A84231DF663348');
        $this->addSql('DROP TABLE configurator');
        $this->addSql('DROP TABLE configurator_product');
    }
}
