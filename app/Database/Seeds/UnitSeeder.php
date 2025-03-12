<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'HBMYO Birimi',
                'phone' => '1234567890',
                'description' => 'Bu birim Hacıbektaş Meslek Yüksek Okulu\'dur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Hacıbektaş Güzel Sanatlar Birimi',
                'phone' => '0987654321',
                'description' => 'Bu birim Hacıbektaş Güzel Sanatlar Okulu\'dur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
           
        ];

        $this->db->table('unit')->insertBatch($data);
    }
}
