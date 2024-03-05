<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305230159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, publicite_id INT DEFAULT NULL, image_evenement VARCHAR(255) NOT NULL, theme_evenement VARCHAR(255) NOT NULL, type_evenement VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, nbr_participant INT NOT NULL, color VARCHAR(255) DEFAULT NULL, INDEX IDX_B26681E7C04F1B1 (publicite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_participation DATETIME NOT NULL, INDEX IDX_D79F6B11FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publicite (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, sponsor VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7C04F1B1 FOREIGN KEY (publicite_id) REFERENCES publicite (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7C04F1B1');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11FD02F13');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE publicite');
    }
}
