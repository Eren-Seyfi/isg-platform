<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RiskSizesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Bilinmiyor',
                'level' => 0
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Küçük',
                'level' => 1
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Orta',
                'level' => 5
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Büyük',
                'level' => 10
            ],
        ];

        // Verileri risk_sizes tablosuna ekleme
        $this->db->table('risk_sizes')->insertBatch($data);
    }
}
