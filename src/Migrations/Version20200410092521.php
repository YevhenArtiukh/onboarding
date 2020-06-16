<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410092521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE onboarding_training_user (onboarding_training_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B508477E8523AF38 (onboarding_training_id), INDEX IDX_B508477EA76ED395 (user_id), PRIMARY KEY(onboarding_training_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE onboarding_training_user ADD CONSTRAINT FK_B508477E8523AF38 FOREIGN KEY (onboarding_training_id) REFERENCES onboarding_training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE onboarding_training_user ADD CONSTRAINT FK_B508477EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE onboarding ADD days LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD status VARCHAR(255) NOT NULL, DROP date');
        $this->addSql('ALTER TABLE onboarding_training DROP FOREIGN KEY FK_BBB844F4235CA921');
        $this->addSql('ALTER TABLE onboarding_training DROP FOREIGN KEY FK_BBB844F4BEFD98D1');
        $this->addSql('ALTER TABLE onboarding_training ADD id INT AUTO_INCREMENT NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD time TIME NOT NULL, ADD day INT NOT NULL, CHANGE onboarding_id onboarding_id INT DEFAULT NULL, CHANGE training_id training_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4235CA921 FOREIGN KEY (onboarding_id) REFERENCES onboarding (id)');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE onboarding_training_user');
        $this->addSql('DROP TABLE place');
        $this->addSql('ALTER TABLE onboarding ADD date DATE NOT NULL, DROP days, DROP status');
        $this->addSql('ALTER TABLE onboarding_training MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE onboarding_training DROP FOREIGN KEY FK_BBB844F4235CA921');
        $this->addSql('ALTER TABLE onboarding_training DROP FOREIGN KEY FK_BBB844F4BEFD98D1');
        $this->addSql('ALTER TABLE onboarding_training DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE onboarding_training DROP id, DROP type, DROP time, DROP day, CHANGE onboarding_id onboarding_id INT NOT NULL, CHANGE training_id training_id INT NOT NULL');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4235CA921 FOREIGN KEY (onboarding_id) REFERENCES onboarding (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE onboarding_training ADD PRIMARY KEY (onboarding_id, training_id)');
    }
}
