<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403124931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE checklist_item_template ADD checklist_template_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE checklist_item_template ADD CONSTRAINT FK_414DF8121316BF28 FOREIGN KEY (checklist_template_id) REFERENCES checklist_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_414DF8121316BF28 ON checklist_item_template (checklist_template_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE checklist_item_template DROP CONSTRAINT FK_414DF8121316BF28
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_414DF8121316BF28
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE checklist_item_template DROP checklist_template_id
        SQL);
    }
}
