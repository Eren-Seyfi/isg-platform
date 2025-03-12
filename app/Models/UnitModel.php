<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true; // Silme işlemlerinde soft delete kullanılması
    protected $allowedFields = ['id', 'name', 'phone', 'description', 'company_id']; // Güncellenebilir/veri eklenebilir alanlar

    protected $useTtimestamps = true; // created_at ve updated_at otomatik olarak yönetilir
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getunit($id = false)
    {
        if ($id === false) {
            return $this->findAll(); // ID verilmediyse tüm Birimleri getir
        }

        return $this->find($id); // ID verilmişse, o ID'ye sahip Birimyi getir
    }

    public function getCompanyUnits($companyId)
    {
        return $this->where('company_id', $companyId)->findAll();
    }

    public function updateunit($id, $data)
    {
        // Gelen verileri doğrula ve güncellemeyi gerçekleştir
        return $this->update($id, $data);
    }

    public function deleteunit($id)
    {
        return $this->delete($id); // Soft delete işlemi
    }
}
