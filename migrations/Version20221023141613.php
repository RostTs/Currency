<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023141613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE coins
        ADD image VARCHAR(255),
        ADD price NUMERIC (20,2),
        ADD price_updated date");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE coins
        DROP COLUMN image, 
        DROP COLUMN price, 
        DROP COLUMN price_updated");
    }
}
