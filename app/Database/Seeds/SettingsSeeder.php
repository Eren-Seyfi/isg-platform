<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'site_name' => 'İsg Plartformu', // Başlangıç site adı
            'site_logo' => 'uploads/default/logo.png', // Başlangıç logo dosya yolu
            'site_favicon' => 'uploads/default/logo.png', // Başlangıç favicon dosya yolu
            'site_description' => 'İş sağlığı ve güvenliği', // Başlangıç site açıklaması
            'maintenance_mode' => 0, // Başlangıç bakım modu (kapalı)
        ];

        // Veritabanına kayıt ekleme
        $this->db->table('settings')->insert($data); // Ayarları settings tablosuna ekleme
    }
}
