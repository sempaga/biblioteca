<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702153518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) DEFAULT NULL, apodo VARCHAR(255) DEFAULT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editorial (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, pais VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, autor_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, isbn VARCHAR(20) NOT NULL, edicion INT NOT NULL, publicacion INT DEFAULT NULL, categoria VARCHAR(255) NOT NULL, INDEX IDX_5799AD2B14D45BBE (autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro_editorial (libro_id INT NOT NULL, editorial_id INT NOT NULL, INDEX IDX_B6067336C0238522 (libro_id), INDEX IDX_B6067336BAF1A24D (editorial_id), PRIMARY KEY(libro_id, editorial_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B14D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id)');
        $this->addSql('ALTER TABLE libro_editorial ADD CONSTRAINT FK_B6067336C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_editorial ADD CONSTRAINT FK_B6067336BAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B14D45BBE');
        $this->addSql('ALTER TABLE libro_editorial DROP FOREIGN KEY FK_B6067336BAF1A24D');
        $this->addSql('ALTER TABLE libro_editorial DROP FOREIGN KEY FK_B6067336C0238522');
        $this->addSql('DROP TABLE autor');
        $this->addSql('DROP TABLE editorial');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE libro_editorial');
    }
}
