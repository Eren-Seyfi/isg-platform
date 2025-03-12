<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class SettingsTable extends Migration
{
    public function up()
    {
        // settings tablosu oluşturma
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
            'site_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false, // Site adı zorunlu
            ],
            'site_subheading' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false, // Site adı zorunlu
            ],
            'site_logo' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // Logo yolu (URL veya dosya yolu)
                'null' => true, // Logo null olabilir
            ],
            'site_favicon' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // Favicon yolu
                'null' => true, // Favicon null olabilir
            ],
            'site_description' => [
                'type' => 'TEXT', // Site açıklaması
                'null' => true, // Site açıklaması null olabilir
            ],
            'maintenance_mode' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 0, // Bakım modu varsayılan olarak kapalı
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        // Anahtar tanımlama
        $this->forge->addKey('id', true); // id alanını anahtar olarak belirleme
        $this->forge->createTable('settings'); // settings tablosunu oluşturma
    }

    public function down()
    {
        // settings tablosunu silme
        $this->forge->dropTable('settings');
    }
}
