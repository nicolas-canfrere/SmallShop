<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227201009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tb_products (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:product_name)\', alias VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, on_sale TINYINT(1) NOT NULL, price_amount BIGINT NOT NULL, price_currency_code VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_8B1D4F445E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_shop_users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', civility VARCHAR(50) NOT NULL COMMENT \'(DC2Type:civility)\', firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, canonical_email VARCHAR(255) NOT NULL, canonical_username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_stock_rows (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', payload VARCHAR(255) NOT NULL, record_on DATETIME NOT NULL, UNIQUE INDEX UNIQ_AA0D4FF6422C6A15 (payload), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tb_products');
        $this->addSql('DROP TABLE tb_shop_users');
        $this->addSql('DROP TABLE tb_stock_rows');
    }
}
