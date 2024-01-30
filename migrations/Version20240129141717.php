<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129141717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_tag (comment_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_EC1BF7B3F8697D13 (comment_id), INDEX IDX_EC1BF7B3BAD26311 (tag_id), PRIMARY KEY(comment_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_tag ADD CONSTRAINT FK_EC1BF7B3F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_tag ADD CONSTRAINT FK_EC1BF7B3BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_tag DROP FOREIGN KEY FK_EC1BF7B3F8697D13');
        $this->addSql('ALTER TABLE comment_tag DROP FOREIGN KEY FK_EC1BF7B3BAD26311');
        $this->addSql('DROP TABLE comment_tag');
    }
}
