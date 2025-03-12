<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CompanySeeder');
        $this->call('UnitSeeder');  // İsim düzeltildi
        $this->call('StructureSeeder');
        $this->call('RegionsSeeder');
        $this->call('RiskFrequenciesSeeder');
        $this->call('RiskSizesSeeder');
        $this->call('NotificationsSeeder');
        $this->call('UserSeeder');  // Kullanıcıyı en son eklemek daha mantıklı olabilir
        $this->call('SettingsSeeder');

    }
}
