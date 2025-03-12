<?php
namespace App\Models;

use CodeIgniter\Model;

class RiskFrequencyModel extends Model
{
    protected $table = 'risk_frequencies'; // Tablo adı
    protected $primaryKey = 'id'; // Birincil anahtar

    protected $allowedFields = ['id', 'name', 'level', 'company_id'];

    protected $useTimestamps = true;  // created_at ve updated_at otomatik işlenecek
    protected $dateFormat = 'datetime';  // Tarih formatı datetime
    protected $createdField = 'created_at';  // Oluşturulma zamanı alanı
    protected $updatedField = 'updated_at';  // Güncellenme zamanı alanı

    public function getFrequencies($id = false)
    {
        if ($id === false) {
            return $this->findAll();  // Tüm binaları getir
        }
        return $this->find($id);  // Belirli ID'ye sahip binayı getir
    }

    public function createFrequencies($data)
    {
        $this->insert($data);
    }

    public function updateFrequencies($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteFrequencies($id)
    {
        return $this->delete($id);
    }

}
