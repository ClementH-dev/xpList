<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403130117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE project_checklist_item (id SERIAL NOT NULL, project_id INT NOT NULL, label VARCHAR(255) NOT NULL, is_required BOOLEAN NOT NULL, is_checked BOOLEAN NOT NULL, position INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_705C145B166D1F9C ON project_checklist_item (project_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_item ADD CONSTRAINT FK_705C145B166D1F9C FOREIGN KEY (project_id) REFERENCES project_checklist (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_item DROP CONSTRAINT FK_705C145B166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_checklist_item
        SQL);
    }
}
