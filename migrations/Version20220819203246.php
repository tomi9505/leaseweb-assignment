<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819203246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE server_item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model VARCHAR(255) NOT NULL, ram INTEGER NOT NULL, ram_type VARCHAR(255) NOT NULL, hdd_count INTEGER NOT NULL, hdd_storage_capacity INTEGER NOT NULL, hdd_type VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(10) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server_list AS SELECT id, file_name, created_at FROM server_list');
        $this->addSql('DROP TABLE server_list');
        $this->addSql('CREATE TABLE server_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO server_list (id, file_name, created_at) SELECT id, file_name, created_at FROM __temp__server_list');
        $this->addSql('DROP TABLE __temp__server_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE server_item');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server_list AS SELECT id, file_name, created_at FROM server_list');
        $this->addSql('DROP TABLE server_list');
        $this->addSql('CREATE TABLE server_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO server_list (id, file_name, created_at) SELECT id, file_name, created_at FROM __temp__server_list');
        $this->addSql('DROP TABLE __temp__server_list');
    }
}
