<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011192626 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disc CHANGE price price DOUBLE PRECISION DEFAULT \'0\', CHANGE color color VARCHAR(255) DEFAULT NULL, CHANGE material material VARCHAR(255) DEFAULT NULL, CHANGE additional additional LONGTEXT DEFAULT NULL, CHANGE weight weight DOUBLE PRECISION DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE is_missing is_missing TINYINT(1) DEFAULT \'0\', CHANGE missing_description missing_description VARCHAR(255) DEFAULT NULL, CHANGE is_sold is_sold TINYINT(1) DEFAULT \'0\', CHANGE sold_at sold_at DATE DEFAULT NULL, CHANGE sold_for sold_for DOUBLE PRECISION DEFAULT NULL, CHANGE is_broken is_broken TINYINT(1) DEFAULT \'0\', CHANGE is_hole_in_one is_hole_in_one TINYINT(1) DEFAULT \'0\', CHANGE hole_in_one_date hole_in_one_date DATE DEFAULT NULL, CHANGE is_collection_item is_collection_item TINYINT(1) DEFAULT \'0\', CHANGE is_own_stamp is_own_stamp TINYINT(1) DEFAULT \'0\', CHANGE is_donated is_donated TINYINT(1) DEFAULT \'0\', CHANGE donation_description donation_description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disc CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE color color VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE material material VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE additional additional LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE weight weight DOUBLE PRECISION NOT NULL, CHANGE image image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE is_missing is_missing TINYINT(1) NOT NULL, CHANGE missing_description missing_description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE is_sold is_sold TINYINT(1) NOT NULL, CHANGE sold_at sold_at DATE NOT NULL, CHANGE sold_for sold_for DOUBLE PRECISION NOT NULL, CHANGE is_broken is_broken TINYINT(1) NOT NULL, CHANGE is_hole_in_one is_hole_in_one TINYINT(1) NOT NULL, CHANGE hole_in_one_date hole_in_one_date DATE NOT NULL, CHANGE is_collection_item is_collection_item TINYINT(1) NOT NULL, CHANGE is_own_stamp is_own_stamp TINYINT(1) NOT NULL, CHANGE is_donated is_donated TINYINT(1) NOT NULL, CHANGE donation_description donation_description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
