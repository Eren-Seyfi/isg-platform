<?php
namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'id',
        'company_id',
        'unit_id',
        'structure_id',
        'regions_id',
        'description',
        'risk_frequency_id',
        'risk_size_id',
        'status',
        'image',
        'note', // Yeni eklenen alan
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Otomatik tarih ekleme, 'company_id' 
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getNotification($id = false)
    {
        if ($id === false) {
            return $this->orderBy('created_at', 'DESC')->findAll();  // Tüm bildirimleri getir
        }
        return $this->find($id);  // Belirli ID'ye sahip bildirimi getir
    }



    public function createNotification($data)
    {
        $this->insert($data);
    }

    /**
     * Günlük bildirimleri döndürür.
     */
    public function getDailyNotifications($companyId)
    {
        $today = date('Y-m-d');
        // DATE(created_at) kısmı, ham SQL ifadesi olduğu için üçüncü parametre false olarak verilmiştir.
        return $this->where('company_id', $companyId)
            ->where("DATE(created_at) = '$today'", null, false)
            ->findAll();
    }

    /**
     * Haftalık bildirimleri döndürür.
     */
    public function getWeeklyNotifications($companyId)
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        return $this->where('company_id', $companyId)
            ->where("DATE(created_at) BETWEEN '$startOfWeek' AND '$endOfWeek'", null, false)
            ->findAll();
    }

    /**
     * Aylık bildirimleri döndürür.
     */
    public function getMonthlyNotifications($companyId)
    {
        $currentMonth = date('Y-m');
        // 'like' metodu, created_at alanında geçerli ayı arar.
        return $this->where('company_id', $companyId)
            ->like('created_at', $currentMonth, 'after')
            ->findAll();
    }

}
