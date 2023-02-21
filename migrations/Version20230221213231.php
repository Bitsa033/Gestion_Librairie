<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221213231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entree_livre (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, quantite INT NOT NULL, date_e DATETIME NOT NULL, INDEX IDX_3E6D61C337D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie_livre (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, quantite INT NOT NULL, date_s DATETIME NOT NULL, INDEX IDX_356DEA9D37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entree_livre ADD CONSTRAINT FK_3E6D61C337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE sortie_livre ADD CONSTRAINT FK_356DEA9D37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE entree_livre');
        $this->addSql('DROP TABLE sortie_livre');
    }
}
