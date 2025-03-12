<?php

namespace App\Models;

use CodeIgniter\Model;

class StructureModel extends Model
{
    protected $table = 'structure';  // Tablo adı
    protected $primaryKey = 'id';    // Primary key alanı

    protected $useSoftDeletes = true;  // Soft delete kullanımı

    // Tabloya eklenebilecek/güncellenebilecek alanlar
    protected $allowedFields = ['id', 'unit_id', 'name', 'description', 'company_id'];


    // Timestamps kullanımı
    protected $useTimestamps = true;   // created_at ve updated_at otomatik yönetilir
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Bina bilgilerini getirme fonksiyonu
    public function getBuilding($id = false)
    {
        if ($id === false) {
            return $this->findAll();  // Tüm binaları getir
        }
        return $this->find($id);  // Belirli ID'ye sahip binayı getir
    }

    // Tüm binaları getiren fonksiyon
    public function getBuildings()
    {
        return $this->findAll();  // Tüm binaları getir
    }

    // Birimye bağlı binaları getirme fonksiyonu
    public function getBuildingsByunit($unitId)
    {
        return $this->where('unit_id', $unitId)->findAll();  // Birimye ait binaları getir
    }
}
