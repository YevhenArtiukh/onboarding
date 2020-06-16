<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410103656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE onboarding_training (id INT AUTO_INCREMENT NOT NULL, onboarding_id INT DEFAULT NULL, training_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, time TIME NOT NULL, day INT NOT NULL, INDEX IDX_BBB844F4235CA921 (onboarding_id), INDEX IDX_BBB844F4BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4235CA921 FOREIGN KEY (onboarding_id) REFERENCES onboarding (id)');
        $this->addSql('ALTER TABLE onboarding_training ADD CONSTRAINT FK_BBB844F4BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE exam ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE onboarding ADD days LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD status VARCHAR(255) NOT NULL, DROP date');
        $this->addSql('ALTER TABLE onboarding_training_user ADD CONSTRAINT FK_B508477E8523AF38 FOREIGN KEY (onboarding_training_id) REFERENCES onboarding_training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE onboarding_training_user ADD CONSTRAINT FK_B508477EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE onboarding_training_user DROP FOREIGN KEY FK_B508477E8523AF38');
        $this->addSql('DROP TABLE onboarding_training');
        $this->addSql('ALTER TABLE exam DROP is_active');
        $this->addSql('ALTER TABLE onboarding ADD date DATE NOT NULL, DROP days, DROP status');
        $this->addSql('ALTER TABLE onboarding_training_user DROP FOREIGN KEY FK_B508477EA76ED395');
    }
}
