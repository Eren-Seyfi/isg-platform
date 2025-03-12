<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class NotificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5, // 5 karakter u
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'unit_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'structure_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'regions_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false, // ZORUNLU ALAN (NULL GEÇİLEMEZ)
            ],
            'risk_frequency_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,  // BOŞ GEÇİLEBİLİR
            ],
            'risk_size_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,  // BOŞ GEÇİLEBİLİR
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => 'Yeni', // Varsayılan "Yeni"
                'null' => false, // NULL OLAMAZ
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'note' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
