<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123161447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_83D44F6F14D45BBE FOREIGN KEY (autor_id) REFERENCES duck (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, content, created_at, picture) SELECT id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6F14D45BBE ON quack (autor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6F14D45BBE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO quack (id, content, created_at, picture) SELECT id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
    }
}
