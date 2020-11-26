<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125144226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6F14D45BBE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, autor_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_83D44F6F14D45BBE FOREIGN KEY (autor_id) REFERENCES duck (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, autor_id, content, created_at, picture) SELECT id, autor_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6F14D45BBE ON quack (autor_id)');
        $this->addSql('DROP INDEX IDX_C7845150D3950CA9');
        $this->addSql('DROP INDEX IDX_C7845150BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_tag AS SELECT quack_id, tag_id FROM quack_tag');
        $this->addSql('DROP TABLE quack_tag');
        $this->addSql('CREATE TABLE quack_tag (quack_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(quack_id, tag_id), CONSTRAINT FK_C7845150D3950CA9 FOREIGN KEY (quack_id) REFERENCES quack (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C7845150BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack_tag (quack_id, tag_id) SELECT quack_id, tag_id FROM __temp__quack_tag');
        $this->addSql('DROP TABLE __temp__quack_tag');
        $this->addSql('CREATE INDEX IDX_C7845150D3950CA9 ON quack_tag (quack_id)');
        $this->addSql('CREATE INDEX IDX_C7845150BAD26311 ON quack_tag (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6F14D45BBE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, autor_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, comment CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO quack (id, autor_id, content, created_at, picture) SELECT id, autor_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6F14D45BBE ON quack (autor_id)');
        $this->addSql('DROP INDEX IDX_C7845150D3950CA9');
        $this->addSql('DROP INDEX IDX_C7845150BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_tag AS SELECT quack_id, tag_id FROM quack_tag');
        $this->addSql('DROP TABLE quack_tag');
        $this->addSql('CREATE TABLE quack_tag (quack_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(quack_id, tag_id))');
        $this->addSql('INSERT INTO quack_tag (quack_id, tag_id) SELECT quack_id, tag_id FROM __temp__quack_tag');
        $this->addSql('DROP TABLE __temp__quack_tag');
        $this->addSql('CREATE INDEX IDX_C7845150D3950CA9 ON quack_tag (quack_id)');
        $this->addSql('CREATE INDEX IDX_C7845150BAD26311 ON quack_tag (tag_id)');
    }
}
