<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011195935 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disc CHANGE price_status price_status VARCHAR(255) DEFAULT NULL, CHANGE color color VARCHAR(255) DEFAULT NULL, CHANGE material material VARCHAR(255) DEFAULT NULL, CHANGE weight weight DOUBLE PRECISION DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE missing_description missing_description VARCHAR(255) DEFAULT NULL, CHANGE sold_at sold_at DATE DEFAULT NULL, CHANGE sold_for sold_for DOUBLE PRECISION DEFAULT NULL, CHANGE hole_in_one_date hole_in_one_date DATE DEFAULT NULL, CHANGE donation_description donation_description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disc CHANGE price_status price_status VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE color color VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE material material VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE weight weight DOUBLE PRECISION DEFAULT \'NULL\', CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE missing_description missing_description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE sold_at sold_at DATE DEFAULT \'NULL\', CHANGE sold_for sold_for DOUBLE PRECISION DEFAULT \'NULL\', CHANGE hole_in_one_date hole_in_one_date DATE DEFAULT \'NULL\', CHANGE donation_description donation_description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
