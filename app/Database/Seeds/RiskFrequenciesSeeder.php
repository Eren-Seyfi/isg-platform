<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RiskFrequenciesSeeder extends Seeder
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
                'name' => 'Düşük',
                'level' => 1
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Orta',
                'level' => 5
            ],
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'name' => 'Yüksek',
                'level' => 10
            ],
        ];

        // Verileri risk_frequencies tablosuna ekleme
        $this->db->table('risk_frequencies')->insertBatch($data);
    }
}
