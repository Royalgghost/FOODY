<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115033056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP shipping_address, DROP billing_address, DROP payment_method, DROP payment_id, DROP special_instructions, CHANGE status status VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD shipping_address LONGTEXT NOT NULL, ADD billing_address LONGTEXT DEFAULT NULL, ADD payment_method VARCHAR(255) NOT NULL, ADD payment_id VARCHAR(255) DEFAULT NULL, ADD special_instructions LONGTEXT DEFAULT NULL, CHANGE status status VARCHAR(20) NOT NULL');
    }
}
