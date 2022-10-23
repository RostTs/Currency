<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017171308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE coin_arch(
            id serial PRIMARY KEY NOT NULL,
            coin_id VARCHAR(255) NOT NULL,
            price NUMERIC (11,2) NOT NULL,
            updated date NOT NULL
            )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE coins");
    }
}
