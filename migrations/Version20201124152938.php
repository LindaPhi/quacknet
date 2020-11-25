<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124152938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_83D44F6F14D45BBE ON quack (autor_id)');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE tag_quack (tag_id INTEGER NOT NULL, quack_id INTEGER NOT NULL, PRIMARY KEY(tag_id, quack_id))');
        $this->addSql('CREATE INDEX IDX_A1385669BAD26311 ON tag_quack (tag_id)');
        $this->addSql('CREATE INDEX IDX_A1385669D3950CA9 ON tag_quack (quack_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quack');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_quack');
    }
}
