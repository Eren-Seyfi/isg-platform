<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_id' => 1, // Nevşehir Hacı Bektaş Veli Üniversitesi
                'username' => 'user',
                'surname' => 'surname',
                'role' => 'user',
                'email' => 'user@example.com',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'profile' => 'uploads/default/profile.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_id' => null, // Superadmin olduğu için belirli bir şirkete ait değil
                'username' => 'super',
                'surname' => 'admin',
                'email' => 'superadmin@example.com',
                'role' => 'superadmin',
                'password' => password_hash('superadmin', PASSWORD_DEFAULT),
                'profile' => 'uploads/default/profile.png', // Varsayılan profil resmi eklendi
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
