<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830201459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE coins(
            id serial PRIMARY KEY NOT NULL,
            coingecko_id VARCHAR(255) NOT NULL,
            symbol VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            is_favorite BOOLEAN NOT NULL,
            created date NOT NULL
            )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE coins");
    }
}
