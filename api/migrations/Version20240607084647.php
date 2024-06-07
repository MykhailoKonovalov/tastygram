<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607084647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add likes table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE likes (recipe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F2888C9659D8A214 (recipe_id), INDEX IDX_F2888C96A76ED395 (user_id), PRIMARY KEY(recipe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_F2888C9659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_F2888C96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_F2888C9659D8A214');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_F2888C96A76ED395');
        $this->addSql('DROP TABLE likes');
    }
}
