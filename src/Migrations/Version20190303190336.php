<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190303190336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products_tags (product_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_E3AB5A2C4584665A (product_id), INDEX IDX_E3AB5A2CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_tags (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:product_name)\', UNIQUE INDEX UNIQ_34CC96375E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2C4584665A FOREIGN KEY (product_id) REFERENCES tb_products (id)');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2CBAD26311 FOREIGN KEY (tag_id) REFERENCES tb_tags (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products_tags DROP FOREIGN KEY FK_E3AB5A2CBAD26311');
        $this->addSql('DROP TABLE products_tags');
        $this->addSql('DROP TABLE tb_tags');
    }
}
