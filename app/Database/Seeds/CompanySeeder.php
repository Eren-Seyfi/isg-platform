<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Örnek şirket verileri
        $data = [
            [
                'name' => 'Nevşehir Hacı Bektaş Veli Üniversitesi',
                'unit' => 'Eğitim',
                'subheading' => 'Üniversite',
                'description' => 'Nevşehir Hacı Bektaş Veli Üniversitesi resmi şirketi',
                'image' => 'uploads/company/nevü_logo.jpg',
                'note' => 'Üniversite için test şirketi',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        ];

        // Verileri tabloya ekle
        $this->db->table('companies')->insertBatch($data);
    }
}
