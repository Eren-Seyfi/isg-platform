<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyModel;
use App\Models\UnitModel;
use App\Models\StructureModel;
use App\Models\RegionModel;
use App\Models\RiskFrequencyModel;
use App\Models\RiskSizeModel;

class ApiController extends BaseController
{
    protected $companyModel;
    protected $unitModel;
    protected $structureModel;
    protected $regionModel;
    protected $riskFrequencyModel;
    protected $riskSizeModel;

    public $helpers = ['url', 'form', 'admin_helper'];


    public function __construct()
    {
        // Modelleri yükleyelim
        $this->companyModel = new CompanyModel();
        $this->unitModel = new UnitModel();
        $this->structureModel = new StructureModel();
        $this->regionModel = new RegionModel();
        $this->riskFrequencyModel = new RiskFrequencyModel();
        $this->riskSizeModel = new RiskSizeModel();
    }

    /**
     * Şirketleri birimler, binalar ve bölgelerle hiyerarşik şekilde döndür.
     */
    public function getCompanies()
    {
        $companies = $this->companyModel->where('deleted_at', null)->findAll();
        $units = $this->unitModel->where('deleted_at', null)->findAll();
        $structures = $this->structureModel->where('deleted_at', null)->findAll();
        $regions = $this->regionModel->where('deleted_at', null)->findAll();

        if (empty($companies)) {
            return $this->response->setJSON(['message' => 'No companies found'])->setStatusCode(404);
        }

        $companyData = [];

        foreach ($companies as $company) {
            // Şirkete ait birimleri al
            $companyUnits = array_filter($units, fn($u) => $u['company_id'] == $company['id']);
            $unitData = [];

            foreach ($companyUnits as $unit) {
                // Birime ait binaları al
                $unitStructures = array_filter($structures, fn($s) => $s['unit_id'] == $unit['id']);
                $structureData = [];

                foreach ($unitStructures as $structure) {
                    // Binaya ait bölgeleri al
                    $structureRegions = array_filter($regions, fn($r) => $r['structure_id'] == $structure['id']);

                    $structureData[] = [
                        'id' => $structure['id'],
                        'name' => $structure['name'],
                        'created_at' => $structure['created_at'],
                        'updated_at' => $structure['updated_at'],
                        'regions' => array_values($structureRegions),
                    ];
                }

                $unitData[] = [
                    'id' => $unit['id'],
                    'name' => $unit['name'],
                    'created_at' => $unit['created_at'],
                    'updated_at' => $unit['updated_at'],
                    'structures' => $structureData,
                ];
            }

            $companyData[] = [
                'id' => $company['id'],
                'name' => $company['name'],
                'image' => $company['image'],
                'note' => $company['note'],
                'created_at' => $company['created_at'],
                'updated_at' => $company['updated_at'],
                'units' => $unitData,
            ];
        }

        return $this->response->setJSON($companyData);
    }


    /**
     * Risk verilerini risk frekansları ve büyüklükleriyle hiyerarşik olarak döndür.
     */
    public function getRiskData()
    {
        $company_id = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        if (!$company_id) {
            return $this->response->setJSON(['message' => 'Company information not found in session'])->setStatusCode(400);
        }

        // Risk frekanslarını ve büyüklüklerini şirket ID'ye göre filtrele
        $frequencies = $this->riskFrequencyModel->where('company_id', $company_id)->where('deleted_at', null)->findAll();
        $sizes = $this->riskSizeModel->where('company_id', $company_id)->where('deleted_at', null)->findAll();

        if (empty($frequencies) && empty($sizes)) {
            return $this->response->setJSON(['message' => 'No risk data found'])->setStatusCode(404);
        }

        $riskData = [];

        foreach ($frequencies as $frequency) {
            // İlgili frekansa ait risk büyüklüklerini al
            $relatedSizes = array_filter($sizes, fn($s) => $s['risk_frequency_id'] == $frequency['id']);

            $riskData[] = [
                'id' => $frequency['id'],
                'name' => $frequency['name'],
                'created_at' => $frequency['created_at'],
                'updated_at' => $frequency['updated_at'],
                'risk_sizes' => array_values($relatedSizes),
            ];
        }

        return $this->response->setJSON([
            'company_id' => $company_id,
            'risk_frequencies' => $riskData,
        ]);
    }


    public function getStructuresByUnit()
    {
        $unitId = $this->request->getGet('unit_id');
        $company_id = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        if (!$unitId) {
            return $this->response->setJSON(['error' => 'Birim ID belirtilmedi'])->setStatusCode(400);
        }

        if (!$company_id) {
            return $this->response->setJSON(['error' => 'Şirket bilgisi bulunamadı'])->setStatusCode(403);
        }

        $structureModel = new StructureModel();

        // Yalnızca oturum açmış kullanıcının şirketine ait olan yapıları al
        $structures = $structureModel
            ->where('unit_id', $unitId)
            ->where('company_id', $company_id)  // Şirket doğrulaması
            ->where('deleted_at', null)         // Silinmiş yapıları gösterme
            ->findAll();

        if (empty($structures)) {
            return $this->response->setJSON(['message' => 'Bu birime ait yapı bulunamadı.'])->setStatusCode(404);
        }

        return $this->response->setJSON($structures);
    }



}
