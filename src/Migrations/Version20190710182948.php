<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190710182948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE region (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, region_code VARCHAR(255) NOT NULL, region_title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, route_from_id_id INTEGER NOT NULL, route_to_id_id INTEGER NOT NULL, user_id INTEGER NOT NULL, route_interval INTEGER NOT NULL, route_notification_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_2C42079484571AF ON route (route_from_id_id)');
        $this->addSql('CREATE INDEX IDX_2C420798A54E74C ON route (route_to_id_id)');
        $this->addSql('CREATE INDEX IDX_2C42079A76ED395 ON route (user_id)');
        $this->addSql('CREATE TABLE station (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, region_id INTEGER NOT NULL, station_title VARCHAR(255) NOT NULL, station_code VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9F39F8B198260155 ON station (region_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE user');
    }
}
