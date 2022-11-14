<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114201110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_questions (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, question_id INT NOT NULL, sort_order INT NOT NULL, INDEX IDX_841C31F1E5D0459 (test_id), INDEX IDX_841C31F1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_questions ADD CONSTRAINT FK_841C31F1E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id)');
        $this->addSql('ALTER TABLE test_questions ADD CONSTRAINT FK_841C31F1E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE ordered_test_questions DROP FOREIGN KEY FK_6BE877E01E27F6BF');
        $this->addSql('ALTER TABLE ordered_test_questions DROP FOREIGN KEY FK_6BE877E01E5D0459');
        $this->addSql('DROP TABLE ordered_test_questions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordered_test_questions (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, question_id INT NOT NULL, sort_order INT NOT NULL, INDEX IDX_6BE877E01E27F6BF (question_id), INDEX IDX_6BE877E01E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ordered_test_questions ADD CONSTRAINT FK_6BE877E01E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ordered_test_questions ADD CONSTRAINT FK_6BE877E01E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE test_questions DROP FOREIGN KEY FK_841C31F1E5D0459');
        $this->addSql('ALTER TABLE test_questions DROP FOREIGN KEY FK_841C31F1E27F6BF');
        $this->addSql('DROP TABLE test_questions');
    }
}
