<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422111204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, thumb VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, external_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C19F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', author VARCHAR(255) NOT NULL, INDEX IDX_9474526C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, external_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6BAF78709F75D7B0 (external_id), INDEX idx_ingredient_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE measurement (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT NOT NULL, recipe_id INT NOT NULL, measure VARCHAR(255) NOT NULL, INDEX IDX_2CE0D811933FE08C (ingredient_id), INDEX IDX_2CE0D81159D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, area VARCHAR(255) DEFAULT NULL, instructions LONGTEXT NOT NULL, meal_thumb VARCHAR(255) DEFAULT NULL, tags VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, date_modified DATE DEFAULT NULL, external_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DA88B1379F75D7B0 (external_id), INDEX IDX_DA88B13712469DE2 (category_id), INDEX idx_recipe_title (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD CONSTRAINT FK_9474526C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE measurement ADD CONSTRAINT FK_2CE0D811933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE measurement ADD CONSTRAINT FK_2CE0D81159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP FOREIGN KEY FK_9474526C59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE measurement DROP FOREIGN KEY FK_2CE0D811933FE08C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE measurement DROP FOREIGN KEY FK_2CE0D81159D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13712469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE measurement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe
        SQL);
    }
}
