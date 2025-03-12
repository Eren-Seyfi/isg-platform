<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StructureSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1,  // Nevşehir Hacı Bektaş Veli Üniversitesi
                'unit_id' => 1,  // HBMYO Birimi
                'name' => 'Ana Bina',
                'description' => 'Ana Bina',
            ],
            [
                'company_id' => 1,
                'unit_id' => 2,
                'name' => 'Ana Bina',
                'description' => 'Ana Bina',
            ]
        ];

        $this->db->table('structure')->insertBatch($data);
    }
}
