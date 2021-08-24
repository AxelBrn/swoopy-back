<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824194013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE association_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE property_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE association (id INT NOT NULL, entity_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, position_x NUMERIC(10, 5) NOT NULL, position_y NUMERIC(10, 5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD8521CC81257D5D ON association (entity_id)');
        $this->addSql('CREATE TABLE entity (id INT NOT NULL, project_id INT NOT NULL, name VARCHAR(150) NOT NULL, position_x NUMERIC(10, 5) NOT NULL, position_y NUMERIC(10, 5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E284468166D1F9C ON entity (project_id)');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(150) NOT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE7E3C61F9 ON project (owner_id)');
        $this->addSql('CREATE TABLE property (id INT NOT NULL, entity_id INT NOT NULL, type_id INT NOT NULL, association_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, size INT NOT NULL, nullable BOOLEAN NOT NULL, default_value VARCHAR(50) NOT NULL, unsigned_value BOOLEAN NOT NULL, unique_value BOOLEAN NOT NULL, primary_key BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8BF21CDE81257D5D ON property (entity_id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEC54C8C93 ON property (type_id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEEFB9C8A5 ON property (association_id)');
        $this->addSql('CREATE TABLE type (id INT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE association ADD CONSTRAINT FK_FD8521CC81257D5D FOREIGN KEY (entity_id) REFERENCES entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity ADD CONSTRAINT FK_E284468166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE81257D5D FOREIGN KEY (entity_id) REFERENCES entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEEFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE property DROP CONSTRAINT FK_8BF21CDEEFB9C8A5');
        $this->addSql('ALTER TABLE association DROP CONSTRAINT FK_FD8521CC81257D5D');
        $this->addSql('ALTER TABLE property DROP CONSTRAINT FK_8BF21CDE81257D5D');
        $this->addSql('ALTER TABLE entity DROP CONSTRAINT FK_E284468166D1F9C');
        $this->addSql('ALTER TABLE property DROP CONSTRAINT FK_8BF21CDEC54C8C93');
        $this->addSql('DROP SEQUENCE association_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE property_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_id_seq CASCADE');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE entity');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE type');
    }
}
