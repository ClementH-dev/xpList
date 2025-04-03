<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403125357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE project_checklist (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, client VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN project_checklist.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_checklist_checklist_template (project_checklist_id INT NOT NULL, checklist_template_id INT NOT NULL, PRIMARY KEY(project_checklist_id, checklist_template_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5246F2F69BCAECC4 ON project_checklist_checklist_template (project_checklist_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5246F2F61316BF28 ON project_checklist_checklist_template (checklist_template_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_checklist_template ADD CONSTRAINT FK_5246F2F69BCAECC4 FOREIGN KEY (project_checklist_id) REFERENCES project_checklist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_checklist_template ADD CONSTRAINT FK_5246F2F61316BF28 FOREIGN KEY (checklist_template_id) REFERENCES checklist_template (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_checklist_template DROP CONSTRAINT FK_5246F2F69BCAECC4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE project_checklist_checklist_template DROP CONSTRAINT FK_5246F2F61316BF28
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_checklist
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_checklist_checklist_template
        SQL);
    }
}
