<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'unit_id' => 1, // Örnek Birim ID'si
                'structure_id' => 1, // Örnek bina ID'si
                'regions_id' => 1, // Örnek bölüm ID'si
                'description' => 'Bu bir test bildirimi.',
                'risk_frequency_id' => 2, // Risk Olasılığı tablosundan referans
                'risk_size_id' => 2, // Risk Şiddeti tablosundan referans
                'image' => 'uploads/notifications/resim1.jpg',
                'status' => 'Yeni',
                'note' => 'Bu bir test notudur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'unit_id' => 2, // Örnek Birim ID'si
                'structure_id' => 2, // Örnek bina ID'si
                'regions_id' => 2, // Örnek bölüm ID'si
                'description' => 'Başka bir test bildirimi.',
                'risk_frequency_id' => 3, // Risk Olasılığı tablosundan referans
                'risk_size_id' => 3, // Risk Şiddeti tablosundan referans
                'status' => 'Yeni',
                'note' => 'Bu bir test notudur',
                'image' => 'uploads/notifications/resim2.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Veritabanına kayıt ekleme
        $this->db->table('notifications')->insertBatch($data);
    }
}
