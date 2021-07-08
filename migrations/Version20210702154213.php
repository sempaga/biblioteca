<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702154213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE libro_autor (libro_id INT NOT NULL, autor_id INT NOT NULL, INDEX IDX_F7588AEFC0238522 (libro_id), INDEX IDX_F7588AEF14D45BBE (autor_id), PRIMARY KEY(libro_id, autor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE libro_autor ADD CONSTRAINT FK_F7588AEFC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_autor ADD CONSTRAINT FK_F7588AEF14D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE libro_editorial');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B14D45BBE');
        $this->addSql('DROP INDEX IDX_5799AD2B14D45BBE ON libro');
        $this->addSql('ALTER TABLE libro CHANGE autor_id editorial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2BBAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2BBAF1A24D ON libro (editorial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE libro_editorial (libro_id INT NOT NULL, editorial_id INT NOT NULL, INDEX IDX_B6067336C0238522 (libro_id), INDEX IDX_B6067336BAF1A24D (editorial_id), PRIMARY KEY(libro_id, editorial_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE libro_editorial ADD CONSTRAINT FK_B6067336BAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_editorial ADD CONSTRAINT FK_B6067336C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE libro_autor');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2BBAF1A24D');
        $this->addSql('DROP INDEX IDX_5799AD2BBAF1A24D ON libro');
        $this->addSql('ALTER TABLE libro CHANGE editorial_id autor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B14D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2B14D45BBE ON libro (autor_id)');
    }
}
