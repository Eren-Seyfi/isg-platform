<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class RiskSizesTable extends Migration
{
    public function up()
    {
        // Risk Şiddeti tablosu
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
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
                'constraint' => '100', // Risk Şiddeti açıklaması
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 5, // Risk Şiddeti derecesi (örneğin: 1-10)
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Anahtar tanımlama
        $this->forge->addKey('id', true);
        $this->forge->createTable('risk_sizes');
    }

    public function down()
    {
        // Tabloyu silme
        $this->forge->dropTable('risk_sizes');
    }
}
