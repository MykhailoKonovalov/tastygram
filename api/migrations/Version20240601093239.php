<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601093239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP name, DROP description');
    }
}
