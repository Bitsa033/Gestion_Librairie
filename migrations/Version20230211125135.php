<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211125135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_AC634F9960BB6FE6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__livre AS SELECT id, auteur_id, nom, quantite FROM livre');
        $this->addSql('DROP TABLE livre');
        $this->addSql('CREATE TABLE livre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, quantite INTEGER NOT NULL, genre VARCHAR(255) NOT NULL, annee_edition INTEGER NOT NULL, CONSTRAINT FK_AC634F9960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO livre (id, auteur_id, nom, quantite) SELECT id, auteur_id, nom, quantite FROM __temp__livre');
        $this->addSql('DROP TABLE __temp__livre');
        $this->addSql('CREATE INDEX IDX_AC634F9960BB6FE6 ON livre (auteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_AC634F9960BB6FE6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__livre AS SELECT id, auteur_id, nom, quantite FROM livre');
        $this->addSql('DROP TABLE livre');
        $this->addSql('CREATE TABLE livre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, quantite INTEGER NOT NULL, edition DATE NOT NULL)');
        $this->addSql('INSERT INTO livre (id, auteur_id, nom, quantite) SELECT id, auteur_id, nom, quantite FROM __temp__livre');
        $this->addSql('DROP TABLE __temp__livre');
        $this->addSql('CREATE INDEX IDX_AC634F9960BB6FE6 ON livre (auteur_id)');
    }
}
