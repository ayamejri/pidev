<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212183158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publicite ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publicite ADD CONSTRAINT FK_1D394E39FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_1D394E39FD02F13 ON publicite (evenement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publicite DROP FOREIGN KEY FK_1D394E39FD02F13');
        $this->addSql('DROP INDEX IDX_1D394E39FD02F13 ON publicite');
        $this->addSql('ALTER TABLE publicite DROP evenement_id');
    }
}
