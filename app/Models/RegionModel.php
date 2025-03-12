<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionModel extends Model
{
    protected $table = 'regions';  // Tablo adı
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'unit_id', 'structure_id', 'name', 'description', 'company_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Bölgeleri Birim ve bina bilgileriyle birlikte getir
    public function getDepartmentsWithDetails($unitIds, $buildingIds)
    {
        // Tüm Bölgeleri alalım
        $departments = $this->findAll();

        // Gelen Birim ve bina ID'lerine göre Birim ve bina bilgilerini manuel olarak ekleyelim
        foreach ($departments as &$department) {
            // Birim adı için ID'den gelen Birim bilgisi
            if (isset($unitIds[$department['unit_id']])) {
                $department['unit_name'] = $unitIds[$department['unit_id']];
            } else {
                $department['unit_name'] = 'Bilinmiyor';
            }

            // Bina adı için ID'den gelen bina bilgisi
            if (isset($buildingIds[$department['structure_id']])) {
                $department['building_name'] = $buildingIds[$department['structure_id']];
            } else {
                $department['building_name'] = 'Bilinmiyor';
            }
        }

        return $departments;
    }

}
