<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CompanyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => '50', // Daha düşük bir limit olabilir
            ],
            'subheading' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true, // Opsiyonel olabilir
            ],
            'description' => [
                'type' => 'TEXT', // Daha esnek bir veri türü
                'null' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('id', true);
        $this->forge->addKey('deleted_at'); // Soft delete için index ekledim
        $this->forge->createTable('companies');
    }

    public function down()
    {
        $this->forge->dropTable('companies', true);
    }
}
