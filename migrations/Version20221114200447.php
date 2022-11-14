<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221114200447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ordered_test_questions DROP INDEX UNIQ_6BE877E01E27F6BF, ADD INDEX IDX_6BE877E01E27F6BF (question_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ordered_test_questions DROP INDEX IDX_6BE877E01E27F6BF, ADD UNIQUE INDEX UNIQ_6BE877E01E27F6BF (question_id)');
    }
}
