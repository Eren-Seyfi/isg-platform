<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\UnitModel;
use App\Models\StructureModel;
use App\Models\RegionModel;

class ExcelController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];

    public function index()
    {
        return view('admin/pages/excel');
    }

    public function read()
    {
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();
        $regionModel = new RegionModel();

        $company_id = session()->get('company_id');

        if (!$company_id) {
            return $this->response->setJSON(["message" => "Oturumda şirket bilgisi bulunamadı!"])->setStatusCode(400);
        }

        $file = $this->request->getFile('excelFile');

        if (!$file->isValid() || !in_array($file->getExtension(), ['xls', 'xlsx'])) {
            return $this->response->setJSON(["message" => "Geçerli bir Excel dosyası yükleyin."])->setStatusCode(400);
        }

        $filePath = $file->getTempName();

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $expectedColumns = ['Birimler', 'Binalar', 'Bölgeler'];

            // Başlıkları al ve doğrula
            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                foreach ($row->getCellIterator() as $cell) {
                    $headerRow[] = trim($cell->getValue());
                }
            }

            if ($headerRow !== $expectedColumns) {
                return $this->response->setJSON([
                    "message" => "⚠️ Excel formatı hatalı! Beklenen başlık sırası: 'Birimler', 'Binalar', 'Bölgeler'.",
                    "expected" => $expectedColumns,
                    "received" => $headerRow
                ])->setStatusCode(400);
            }

            $units = [];
            $structures = [];
            $regions = [];

            // Excel verilerini oku
            foreach ($worksheet->getRowIterator(2) as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = trim($cell->getValue());
                }

                if (!empty($rowData[0])) {
                    $units[] = $rowData[0]; // Birimler
                }
                if (!empty($rowData[1])) {
                    $structures[] = ['unit_name' => $rowData[0], 'structure_name' => $rowData[1]]; // Binalar
                }
                if (!empty($rowData[2])) {
                    $regions[] = [
                        'unit_name' => $rowData[0],
                        'structure_name' => $rowData[1],
                        'region_name' => $rowData[2]
                    ]; // Bölgeler
                }
            }

            // Tekrar edenleri kaldır
            $uniqueUnits = array_unique($units);
            $uniqueStructures = array_unique(array_map("serialize", $structures));
            $uniqueStructures = array_map("unserialize", $uniqueStructures);
            $uniqueRegions = array_unique(array_map("serialize", $regions));
            $uniqueRegions = array_map("unserialize", $uniqueRegions);

            // Mevcut birimleri çek
            $existingUnits = array_column($unitModel->where('company_id', $company_id)->findAll(), 'name');
            $newUnits = array_diff($uniqueUnits, $existingUnits);

            $insertedUnits = [];
            $unitIds = [];

            // Yeni birimleri ekle
            foreach ($newUnits as $unitName) {
                $unitModel->insert([
                    'name' => $unitName,
                    'company_id' => $company_id
                ]);
                $unitIds[$unitName] = $unitModel->insertID(); // Eklenen birimin ID'sini al
                $insertedUnits[] = $unitName;
            }

            // Mevcut binaları çek
            $existingStructures = $structureModel->where('company_id', $company_id)->findAll();
            $existingStructureMap = [];
            foreach ($existingStructures as $structure) {
                $existingStructureMap[$structure['unit_id']][$structure['name']] = $structure['id'];
            }

            $insertedStructures = [];

            // Yeni binaları ekle
            foreach ($uniqueStructures as $structureData) {
                $unitName = $structureData['unit_name'];
                $structureName = $structureData['structure_name'];

                // Eğer birim veritabanında varsa ID'yi al, yoksa yeni eklenenlerden al
                $unitId = $unitIds[$unitName] ?? $unitModel->where('name', $unitName)->where('company_id', $company_id)->first()['id'] ?? null;

                if ($unitId && !isset($existingStructureMap[$unitId][$structureName])) {
                    $structureModel->insert([
                        'name' => $structureName,
                        'unit_id' => $unitId,
                        'company_id' => $company_id
                    ]);
                    $insertedStructures[] = $structureName;
                    $existingStructureMap[$unitId][$structureName] = $structureModel->insertID();
                }
            }

            // Mevcut bölgeleri çek
            $existingRegions = $regionModel->where('company_id', $company_id)->findAll();
            $existingRegionMap = [];
            foreach ($existingRegions as $region) {
                $existingRegionMap[$region['structure_id']][$region['name']] = $region['id'];
            }

            $insertedRegions = [];

            // Yeni bölgeleri ekle (✅ **unit_id de ekleniyor!**)
            foreach ($uniqueRegions as $regionData) {
                $unitName = $regionData['unit_name'];
                $structureName = $regionData['structure_name'];
                $regionName = $regionData['region_name'];

                // Eğer birim veritabanında varsa ID'yi al, yoksa yeni eklenenlerden al
                $unitId = $unitIds[$unitName] ?? $unitModel->where('name', $unitName)->where('company_id', $company_id)->first()['id'] ?? null;
                $structureId = $existingStructureMap[$unitId][$structureName] ?? $structureModel->where('name', $structureName)->where('unit_id', $unitId)->where('company_id', $company_id)->first()['id'] ?? null;

                if ($structureId && !isset($existingRegionMap[$structureId][$regionName])) {
                    $regionModel->insert([
                        'name' => $regionName,
                        'unit_id' => $unitId, // ✅ **Bölgeye bağlı birimin ID'si eklendi!**
                        'structure_id' => $structureId,
                        'company_id' => $company_id
                    ]);
                    $insertedRegions[] = $regionName;
                }
            }

            return $this->response->setJSON([
                "message" => "Excel başarıyla okundu ve veriler kayıt edildi.",
                "added_units" => $insertedUnits,
                "added_structures" => $insertedStructures,
                "added_regions" => $insertedRegions
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(["message" => "Excel okunurken hata oluştu.", "error" => $e->getMessage()])->setStatusCode(500);
        }
    }
}
