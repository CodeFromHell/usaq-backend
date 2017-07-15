<?php

namespace USaq\App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170715141916 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE users_friends (user_id INTEGER NOT NULL, friend_user_id INTEGER NOT NULL, PRIMARY KEY(user_id, friend_user_id))');
        $this->addSql('CREATE INDEX IDX_D1EE04A3A76ED395 ON users_friends (user_id)');
        $this->addSql('CREATE INDEX IDX_D1EE04A393D1119E ON users_friends (friend_user_id)');
        $this->addSql('DROP INDEX IDX_AA5A118EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tokens AS SELECT id, user_id, token_string, expire_at FROM tokens');
        $this->addSql('DROP TABLE tokens');
        $this->addSql('CREATE TABLE tokens (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token_string VARCHAR(255) NOT NULL COLLATE BINARY, expire_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_AA5A118EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tokens (id, user_id, token_string, expire_at) SELECT id, user_id, token_string, expire_at FROM __temp__tokens');
        $this->addSql('DROP TABLE __temp__tokens');
        $this->addSql('CREATE INDEX IDX_AA5A118EA76ED395 ON tokens (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE users_friends');
        $this->addSql('DROP INDEX IDX_AA5A118EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tokens AS SELECT id, user_id, token_string, expire_at FROM tokens');
        $this->addSql('DROP TABLE tokens');
        $this->addSql('CREATE TABLE tokens (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token_string VARCHAR(255) NOT NULL, expire_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO tokens (id, user_id, token_string, expire_at) SELECT id, user_id, token_string, expire_at FROM __temp__tokens');
        $this->addSql('DROP TABLE __temp__tokens');
        $this->addSql('CREATE INDEX IDX_AA5A118EA76ED395 ON tokens (user_id)');
    }
}
