<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003204114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordered_test_questions (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, question_id INT NOT NULL, sort_order INT NOT NULL, INDEX IDX_6BE877E01E5D0459 (test_id), UNIQUE INDEX UNIQ_6BE877E01E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_categories (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_5D27D9E0F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_images (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, question_category_id INT NOT NULL, description VARCHAR(255) NOT NULL, answer VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8ADC54D53DA5256D (image_id), INDEX IDX_8ADC54D5F142426F (question_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_types (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tests (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, test_type_id INT NOT NULL, question_category_id INT DEFAULT NULL, theme VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, questions_number INT NOT NULL, create_date DATETIME NOT NULL, finish_date DATETIME DEFAULT NULL, execution_time TIME NOT NULL, INDEX IDX_1260FC5EF675F31B (author_id), INDEX IDX_1260FC5E190D585B (test_type_id), INDEX IDX_1260FC5EF142426F (question_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_question_answers (id INT AUTO_INCREMENT NOT NULL, user_test_id INT NOT NULL, question_id INT NOT NULL, answer VARCHAR(100) NOT NULL, INDEX IDX_231951C646501A53 (user_test_id), INDEX IDX_231951C61E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tests (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, user_id INT NOT NULL, result DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F0A207061E5D0459 (test_id), INDEX IDX_F0A20706A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, first_name VARCHAR(20) NOT NULL, full_name VARCHAR(50) NOT NULL, active INT NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordered_test_questions ADD CONSTRAINT FK_6BE877E01E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id)');
        $this->addSql('ALTER TABLE ordered_test_questions ADD CONSTRAINT FK_6BE877E01E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE question_categories ADD CONSTRAINT FK_5D27D9E0F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D53DA5256D FOREIGN KEY (image_id) REFERENCES question_images (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F142426F FOREIGN KEY (question_category_id) REFERENCES question_categories (id)');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5EF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5E190D585B FOREIGN KEY (test_type_id) REFERENCES test_types (id)');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5EF142426F FOREIGN KEY (question_category_id) REFERENCES question_categories (id)');
        $this->addSql('ALTER TABLE user_question_answers ADD CONSTRAINT FK_231951C646501A53 FOREIGN KEY (user_test_id) REFERENCES user_tests (id)');
        $this->addSql('ALTER TABLE user_question_answers ADD CONSTRAINT FK_231951C61E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE user_tests ADD CONSTRAINT FK_F0A207061E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id)');
        $this->addSql('ALTER TABLE user_tests ADD CONSTRAINT FK_F0A20706A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordered_test_questions DROP FOREIGN KEY FK_6BE877E01E5D0459');
        $this->addSql('ALTER TABLE ordered_test_questions DROP FOREIGN KEY FK_6BE877E01E27F6BF');
        $this->addSql('ALTER TABLE question_categories DROP FOREIGN KEY FK_5D27D9E0F675F31B');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D53DA5256D');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F142426F');
        $this->addSql('ALTER TABLE tests DROP FOREIGN KEY FK_1260FC5EF675F31B');
        $this->addSql('ALTER TABLE tests DROP FOREIGN KEY FK_1260FC5E190D585B');
        $this->addSql('ALTER TABLE tests DROP FOREIGN KEY FK_1260FC5EF142426F');
        $this->addSql('ALTER TABLE user_question_answers DROP FOREIGN KEY FK_231951C646501A53');
        $this->addSql('ALTER TABLE user_question_answers DROP FOREIGN KEY FK_231951C61E27F6BF');
        $this->addSql('ALTER TABLE user_tests DROP FOREIGN KEY FK_F0A207061E5D0459');
        $this->addSql('ALTER TABLE user_tests DROP FOREIGN KEY FK_F0A20706A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('DROP TABLE ordered_test_questions');
        $this->addSql('DROP TABLE question_categories');
        $this->addSql('DROP TABLE question_images');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE test_types');
        $this->addSql('DROP TABLE tests');
        $this->addSql('DROP TABLE user_question_answers');
        $this->addSql('DROP TABLE user_tests');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_role');
    }
}
