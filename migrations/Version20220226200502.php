<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220226200502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_52EA1F098D9F6D38 (order_id), UNIQUE INDEX UNIQ_52EA1F094584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item_configurator_item (order_item_id INT NOT NULL, configurator_item_id INT NOT NULL, INDEX IDX_A363C3ACE415FB15 (order_item_id), INDEX IDX_A363C3AC48D14C2 (configurator_item_id), PRIMARY KEY(order_item_id, configurator_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item_configurator_item ADD CONSTRAINT FK_A363C3ACE415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_item_configurator_item ADD CONSTRAINT FK_A363C3AC48D14C2 FOREIGN KEY (configurator_item_id) REFERENCES configurator_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE buyer CHANGE call_me call_me TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item_configurator_item DROP FOREIGN KEY FK_A363C3ACE415FB15');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_item_configurator_item');
        $this->addSql('ALTER TABLE buyer CHANGE call_me call_me TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
