<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings'; // Veritabanındaki tablo adı
    protected $primaryKey = 'id'; // Birincil anahtar

    // Otomatik artışlı birincil anahtar kullan
    protected $useAutoIncrement = true;

    // Veriyi array formatında geri döndür
    protected $returnType = 'array';

    // Model üzerinden düzenlenebilir alanlar
    protected $allowedFields = [
        'id',
        'company_id',
        'site_name',
        'site_subheading',
        'site_logo',
        'site_favicon',
        'site_description',
        'admin_email',
        'maintenance_mode',
        'created_at',
        'updated_at'
    ];

    // Otomatik tarih damgalarını kullan
    protected $useTimestamps = true;

    // Tarih formatı
    protected $dateFormat = 'datetime';

    // Otomatik doldurulacak alanlar
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Tüm ayarları almak için bir fonksiyon (tek satır)
    public function getSettings()
    {
        return $this->find(1);
    }
    public function updateSettings($data)
    {
        // Kullanıcının id'sine göre güncellemeyi yap
        return $this->update(1, $data); // 1, ilk kaydın id'si
    }
}
