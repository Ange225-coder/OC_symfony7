<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828062202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE name name VARCHAR(255) NOT NULL, CHANGE date_of_death date_of_death DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE nationality nationality VARCHAR(55) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE name name INT NOT NULL, CHANGE date_of_death date_of_death DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE nationality nationality VARCHAR(55) NOT NULL');
    }
}
