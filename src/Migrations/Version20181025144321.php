<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181025144321 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie ADD title VARCHAR(255) NOT NULL, ADD original_title VARCHAR(255) NOT NULL, ADD poster_path VARCHAR(255) NOT NULL, ADD backdrop_path VARCHAR(255) NOT NULL, ADD overview LONGTEXT NOT NULL, ADD release_date VARCHAR(255) NOT NULL, ADD budget INT NOT NULL, ADD runtime INT NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD video VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie DROP title, DROP original_title, DROP poster_path, DROP backdrop_path, DROP overview, DROP release_date, DROP budget, DROP runtime, DROP status, DROP video');
    }
}
