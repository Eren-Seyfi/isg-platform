<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1,  // Nevşehir Hacı Bektaş Veli Üniversitesi
                'unit_id' => 1,  // HBMYO Birimi
                'structure_id' => 1,  // A Blok
                'name' => 'Bilgisayar Labaratuvarı 1',
                'description' => 'Bilgisayar Labaratuvarı 1',
            ],
            [
                'company_id' => 1,
                'unit_id' => 2,
                'structure_id' => 2,
                'name' => 'Resim Atölyesi 1',
                'description' => 'Resim Atölyesi 1',
            ]
        ];

        $this->db->table('regions')->insertBatch($data);
    }
}
