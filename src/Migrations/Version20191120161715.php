<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120161715 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE disc (id VARCHAR(36) NOT NULL, type_id VARCHAR(255) DEFAULT NULL, manufacturer_id VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT \'0\', price_status VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, material VARCHAR(255) DEFAULT NULL, speed SMALLINT NOT NULL, glide SMALLINT NOT NULL, stability SMALLINT NOT NULL, fade DOUBLE PRECISION NOT NULL, additional LONGTEXT DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_missing TINYINT(1) DEFAULT \'0\', missing_description VARCHAR(255) DEFAULT NULL, is_sold TINYINT(1) DEFAULT \'0\', sold_at DATETIME DEFAULT NULL, sold_for DOUBLE PRECISION DEFAULT NULL, is_broken TINYINT(1) DEFAULT \'0\', is_hole_in_one TINYINT(1) DEFAULT \'0\', hole_in_one_date DATETIME DEFAULT NULL, hole_in_one_description VARCHAR(255) DEFAULT NULL, is_collection_item TINYINT(1) DEFAULT \'0\', is_own_stamp TINYINT(1) DEFAULT \'0\', is_donated TINYINT(1) DEFAULT \'0\', donation_description VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2AF5530C54C8C93 (type_id), INDEX IDX_2AF5530A23B42D (manufacturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF5530C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE disc ADD CONSTRAINT FK_2AF5530A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY FK_2AF5530C54C8C93');
        $this->addSql('ALTER TABLE disc DROP FOREIGN KEY FK_2AF5530A23B42D');
        $this->addSql('DROP TABLE disc');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE manufacturer');
    }
}
