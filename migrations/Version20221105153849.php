<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221105153849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE coin_archive_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE coins_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coin_archive (id INT NOT NULL, coin_id_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9AF00C6DA13C630 ON coin_archive (coin_id_id)');
        $this->addSql('CREATE TABLE coins (id INT NOT NULL, coingecko_id VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, is_favorite BOOLEAN NOT NULL, created DATE NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, price_updated DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE coin_archive ADD CONSTRAINT FK_9AF00C6DA13C630 FOREIGN KEY (coin_id_id) REFERENCES coins (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coin_archive_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE coins_id_seq CASCADE');
        $this->addSql('ALTER TABLE coin_archive DROP CONSTRAINT FK_9AF00C6DA13C630');
        $this->addSql('DROP TABLE coin_archive');
        $this->addSql('DROP TABLE coins');
    }
}
