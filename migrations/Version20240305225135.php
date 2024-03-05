<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305225135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exposees (id INT AUTO_INCREMENT NOT NULL, nom_e VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, image_exposees VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, exposees_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, ressource VARCHAR(255) NOT NULL, INDEX IDX_BE2DDF8C6213800A (exposees_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C6213800A FOREIGN KEY (exposees_id) REFERENCES exposees (id)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7C04F1B1');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11FD02F13');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE publicite');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, publicite_id INT DEFAULT NULL, image_evenement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, theme_evenement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_evenement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, nbr_participant INT NOT NULL, color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B26681E7C04F1B1 (publicite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_participation DATETIME NOT NULL, INDEX IDX_D79F6B11FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE publicite (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sponsor VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7C04F1B1 FOREIGN KEY (publicite_id) REFERENCES publicite (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C6213800A');
        $this->addSql('DROP TABLE exposees');
        $this->addSql('DROP TABLE produits');
    }
}
