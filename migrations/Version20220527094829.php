<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527094829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD topics_id INT DEFAULT NULL, ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FBF06A414 FOREIGN KEY (topics_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FBF06A414 ON message (topics_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F67B3B43D ON message (users_id)');
        $this->addSql('ALTER TABLE topic ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B67B3B43D ON topic (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FBF06A414');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F67B3B43D');
        $this->addSql('DROP INDEX IDX_B6BD307FBF06A414 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F67B3B43D ON message');
        $this->addSql('ALTER TABLE message DROP topics_id, DROP users_id');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B67B3B43D');
        $this->addSql('DROP INDEX IDX_9D40DE1B67B3B43D ON topic');
        $this->addSql('ALTER TABLE topic DROP users_id');
    }
}
