<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UnitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true, // BOŞ GEÇİLEBİLİR
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true, // Telefon numarası zorunlu olmayabilir
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true, // Açıklama zorunlu değil
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Otomatik oluşturulma zamanı
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'), // Otomatik güncellenme zamanı
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true, // Soft delete için nullable olabilir
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('unit'); // Tablonun oluşturulması
    }

    public function down()
    {
        $this->forge->dropTable('unit'); // Tabloyu geri almak için
    }
}
