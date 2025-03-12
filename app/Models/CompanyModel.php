<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'unit',
        'subheading',
        'description',
        'image',
        'logo',
        'note'
    ];

    // Zaman damgalarını otomatik yönet
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Soft delete etkin
    protected $useSoftDeletes = true;

    /**
     * Silinmemiş tüm şirketleri getir
     *
     * @return array
     */
    public function getActiveCompanies()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    /**
     * ID'ye göre şirketi getir (soft delete'e dikkat eder)
     *
     * @param int $id
     * @return array|null
     */
    public function getCompanyById($id)
    {
        return $this->find($id);
    }

    /**
     * Şirket logosunu güncelle
     *
     * @param int $id
     * @param string $logoPath
     * @return bool
     */
    public function updateCompanyLogo($id, $logoPath)
    {
        return $this->update($id, ['logo' => $logoPath]);
    }

    /**
     * Şirket resmini güncelle
     *
     * @param int $id
     * @param string $imagePath
     * @return bool
     */
    public function updateCompanyImage($id, $imagePath)
    {
        return $this->update($id, ['image' => $imagePath]);
    }

    /**
     * Silinmiş şirketleri dahil ederek listele
     *
     * @return array
     */
    public function getAllCompaniesWithDeleted()
    {
        return $this->withDeleted()->findAll();
    }

    /**
     * Şirketi yumuşak bir şekilde sil (soft delete)
     *
     * @param int $id
     * @return bool
     */
    public function softDeleteCompany($id)
    {
        return $this->delete($id);
    }

    /**
     * Şirketi kalıcı olarak sil
     *
     * @param int $id
     * @return bool
     */
    public function forceDeleteCompany($id)
    {
        return $this->where('id', $id)->purgeDeleted();
    }

    /**
     * Silinmiş şirketi geri yükle
     *
     * @param int $id
     * @return bool
     */
    public function restoreCompany($id)
    {
        return $this->update($id, ['deleted_at' => null]);
    }
}
