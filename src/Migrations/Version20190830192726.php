<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190830192726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE settlement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, region_id INTEGER NOT NULL, settlement_code VARCHAR(255) NOT NULL, settlement_title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DD9F1B5198260155 ON settlement (region_id)');
        $this->addSql('DROP INDEX IDX_2C42079A76ED395');
        $this->addSql('DROP INDEX IDX_2C420798A54E74C');
        $this->addSql('DROP INDEX IDX_2C42079484571AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route AS SELECT id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification FROM route');
        $this->addSql('DROP TABLE route');
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, route_from_id_id INTEGER NOT NULL, route_to_id_id INTEGER NOT NULL, user_id INTEGER NOT NULL, route_interval TIME NOT NULL, route_notification TIME DEFAULT NULL, CONSTRAINT FK_2C42079484571AF FOREIGN KEY (route_from_id_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2C420798A54E74C FOREIGN KEY (route_to_id_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2C42079A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO route (id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification) SELECT id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification FROM __temp__route');
        $this->addSql('DROP TABLE __temp__route');
        $this->addSql('CREATE INDEX IDX_2C42079A76ED395 ON route (user_id)');
        $this->addSql('CREATE INDEX IDX_2C420798A54E74C ON route (route_to_id_id)');
        $this->addSql('CREATE INDEX IDX_2C42079484571AF ON route (route_from_id_id)');
        $this->addSql('DROP INDEX IDX_9F39F8B198260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__station AS SELECT id, region_id, station_title, station_code FROM station');
        $this->addSql('DROP TABLE station');
        $this->addSql('CREATE TABLE station (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, settlement_id INTEGER NOT NULL, station_title VARCHAR(255) NOT NULL COLLATE BINARY, station_code VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_9F39F8B1C2B9C425 FOREIGN KEY (settlement_id) REFERENCES settlement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO station (id, settlement_id, station_title, station_code) SELECT id, region_id, station_title, station_code FROM __temp__station');
        $this->addSql('DROP TABLE __temp__station');
        $this->addSql('CREATE INDEX IDX_9F39F8B1C2B9C425 ON station (settlement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE settlement');
        $this->addSql('DROP INDEX IDX_2C42079484571AF');
        $this->addSql('DROP INDEX IDX_2C420798A54E74C');
        $this->addSql('DROP INDEX IDX_2C42079A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route AS SELECT id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification FROM route');
        $this->addSql('DROP TABLE route');
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, route_from_id_id INTEGER NOT NULL, route_to_id_id INTEGER NOT NULL, user_id INTEGER NOT NULL, route_interval TIME NOT NULL, route_notification TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO route (id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification) SELECT id, route_from_id_id, route_to_id_id, user_id, route_interval, route_notification FROM __temp__route');
        $this->addSql('DROP TABLE __temp__route');
        $this->addSql('CREATE INDEX IDX_2C42079484571AF ON route (route_from_id_id)');
        $this->addSql('CREATE INDEX IDX_2C420798A54E74C ON route (route_to_id_id)');
        $this->addSql('CREATE INDEX IDX_2C42079A76ED395 ON route (user_id)');
        $this->addSql('DROP INDEX IDX_9F39F8B1C2B9C425');
        $this->addSql('CREATE TEMPORARY TABLE __temp__station AS SELECT id, settlement_id, station_title, station_code FROM station');
        $this->addSql('DROP TABLE station');
        $this->addSql('CREATE TABLE station (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, region_id INTEGER NOT NULL, station_title VARCHAR(255) NOT NULL, station_code VARCHAR(255) NOT NULL, CONSTRAINT FK_9F39F8B1C2B9C425 FOREIGN KEY (region_id) REFERENCES settlement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO station (id, region_id, station_title, station_code) SELECT id, settlement_id, station_title, station_code FROM __temp__station');
        $this->addSql('DROP TABLE __temp__station');
        $this->addSql('CREATE INDEX IDX_9F39F8B198260155 ON station (region_id)');
    }
}
