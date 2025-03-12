<?php

namespace App\Models;

use CodeIgniter\Model;

class RiskSizeModel extends Model
{
    protected $table = 'risk_sizes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','name', 'level', 'company_id' ];

    protected $useTimestamps = true;  // created_at ve updated_at otomatik işlenecek
    protected $dateFormat = 'datetime';  // Tarih formatı datetime
    protected $createdField = 'created_at';  // Oluşturulma zamanı alanı
    protected $updatedField = 'updated_at';  // Güncellenme zamanı alanı


    public function getSizes($id = false)
    {
        if ($id === false) {
            return $this->findAll();  // Tüm binaları getir
        }
        return $this->find($id);  // Belirli ID'ye sahip binayı getir
    }
    public function createSize($data)
    {
        $this->insert($data);
    }

    public function updateSize($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteSize($id)
    {
        return $this->delete($id);
    }
}
