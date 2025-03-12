<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\UnitModel;
use App\Models\StructureModel;
use App\Models\RegionModel;

class SchoolsController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];




    // ============================= Birim (Unit) İşlemleri =============================

    public function getUnits()
    {
        $unitModel = new UnitModel();
        $settingsModel = new SettingsModel();
        $userModel = new UserModel();

        $company_id = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        // GET üzerinden gelen arama terimini al
        $search = $this->request->getGet('search');

        // Query Builder kullanarak şirket filtrelemesi ve arama koşullarını ekleyelim
        $builder = $unitModel->builder();
        $builder->where('deleted_at IS NULL'); // ❌ Silinen verileri hariç tut
        $builder->where('company_id', $company_id);
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('name', $search)
                ->orLike('phone', $search)
                ->orLike('description', $search);
            $builder->groupEnd();
        }
        $units = $builder->get()->getResultArray();

        $data = [
            'settings' => $settingsModel->getSettings(),
            'user' => $userModel->getUser(),
            'units' => $units,
        ];

        return view('admin/pages/schools/unit', $data);
    }

    public function createUnit()
    {
        $unitModel = new UnitModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'description' => $this->request->getPost('description'),
            'company_id' => session()->get('company_id'), // Şirket ID'si session'dan alınır.
        ];

        $unitModel->insert($data);

        return redirect()->to('/admin/schools/units')->with('success', 'Yeni birim başarıyla eklendi');
    }

    public function updateUnit($id)
    {
        $unitModel = new UnitModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'description' => $this->request->getPost('description'),
        ];

        if ($unitModel->update($id, $data)) {
            return redirect()->to('/admin/schools/units')->with('success', 'Birim başarıyla güncellendi');
        } else {
            return redirect()->back()->with('error', 'Birim güncellenirken bir hata oluştu');
        }
    }

    public function deleteUnit($id)
    {
        $unitModel = new UnitModel();

        if ($unitModel->delete($id)) {
            return redirect()->to('/admin/schools/units')->with('success', 'Birim başarıyla silindi');
        } else {
            return redirect()->back()->with('error', 'Birim silinirken bir hata oluştu.');
        }
    }

    // ============================= Bina (Structure) İşlemleri =============================

    public function getStructures()
    {
        $settingsModel = new SettingsModel();
        $userModel = new UserModel();
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();

        $companyId = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        // Şirkete ait aktif birimleri getiriyoruz.
        $units = $unitModel->where('company_id', $companyId)
            ->where('deleted_at IS NULL') // ❌ Silinmiş birimleri hariç tut
            ->findAll();

        if (empty($units)) {
            return redirect()->back()->with('error', 'Bu şirkete ait birim bulunamadı.');
        }

        $unitIds = array_column($units, 'id');

        // GET üzerinden arama ve birim filtre parametrelerini alıyoruz.
        $search = $this->request->getGet('search');
        $unitFilter = $this->request->getGet('unit_filter');

        // Query Builder kullanarak join işlemi gerçekleştiriyoruz.
        $builder = $structureModel->builder();
        $builder->select('structure.*, unit.name as unit_name')
            ->join('unit', 'unit.id = structure.unit_id', 'left')
            ->whereIn('structure.unit_id', $unitIds)
            ->where('structure.deleted_at IS NULL') // ❌ Silinmiş yapıları hariç tut
            ->where('unit.deleted_at IS NULL'); // ❌ Silinmiş birimleri de filtrele

        // Metin araması için filtre
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('structure.name', $search)
                ->orLike('structure.description', $search)
                ->orLike('unit.name', $search);
            $builder->groupEnd();
        }

        // Birim seçimine göre filtre
        if (!empty($unitFilter)) {
            $builder->where('structure.unit_id', $unitFilter);
        }

        $structures = $builder->get()->getResultArray();

        $data = [
            'settings' => $settingsModel->getSettings(),
            'user' => $userModel->getUser(),
            'units' => $units,       // View'a gönderilecek birimler
            'structures' => $structures,
        ];

        return view('admin/pages/schools/structure', $data);
    }


    public function createStructure()
    {
        $structureModel = new StructureModel();

        $data = [
            'unit_id' => $this->request->getPost('unit_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'company_id' => session()->get('company_id'), // Şirket ID'si session'dan alınır.
        ];

        if ($structureModel->insert($data)) {
            return redirect()->to('/admin/schools/structures')->with('success', 'Bina başarıyla eklendi.');
        } else {
            return redirect()->back()->with('error', 'Bina eklenirken bir hata oluştu.');
        }
    }

    public function updateStructure($id)
    {
        $structureModel = new StructureModel();

        $data = [
            'unit_id' => $this->request->getPost('unit_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($structureModel->update($id, $data)) {
            return redirect()->to('/admin/schools/structures')->with('success', 'Bina başarıyla güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Bina güncellenirken bir hata oluştu.');
        }
    }

    public function deleteStructure($id)
    {
        $structureModel = new StructureModel();

        if ($structureModel->delete($id)) {
            return redirect()->to('/admin/schools/structures')->with('success', 'Bina başarıyla silindi.');
        } else {
            return redirect()->back()->with('error', 'Bina silinirken bir hata oluştu.');
        }
    }


    // ============================= Bölge (Region) İşlemleri =============================

    public function getRegions()
    {
        $settingsModel = new SettingsModel();
        $userModel = new UserModel();
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();
        $regionModel = new RegionModel();

        $companyId = session()->get('company_id'); // Kullanıcının şirket ID’sini al

        // Şirkete ait aktif birimleri çek
        $units = $unitModel->where('company_id', $companyId)
            ->where('deleted_at IS NULL') // ❌ Silinmiş birimleri liste dışı bırak
            ->findAll();

        // Şirkete ait aktif yapıları çek
        $structures = $structureModel->where('company_id', $companyId)
            ->where('deleted_at IS NULL') // ❌ Silinmiş yapıları liste dışı bırak
            ->findAll();

        $unitIds = array_column($units, 'id');
        $structureIds = array_column($structures, 'id');

        // Birim ve Yapı adlarını ID ile eşleştir
        $unitNames = [];
        foreach ($units as $unit) {
            $unitNames[$unit['id']] = $unit['name'];
        }
        $structureNames = [];
        foreach ($structures as $structure) {
            $structureNames[$structure['id']] = $structure['name'];
        }

        // GET üzerinden filtre parametrelerini al
        $search = $this->request->getGet('search');
        $unitFilter = $this->request->getGet('unit_filter');
        $structureFilter = $this->request->getGet('structure_filter');

        // Bölgeleri yalnızca kullanıcının şirketine ait olanlarla sınırlayarak al ve filtre uygula
        $regionModel->whereIn('unit_id', $unitIds)
            ->whereIn('structure_id', $structureIds)
            ->where('deleted_at IS NULL'); // ❌ Silinmiş bölgeleri liste dışı bırak

        if (!empty($unitFilter)) {
            $regionModel->where('unit_id', $unitFilter);
        }
        if (!empty($structureFilter)) {
            $regionModel->where('structure_id', $structureFilter);
        }
        if (!empty($search)) {
            // Bölge ismi veya açıklaması üzerinden arama
            $regionModel->groupStart();
            $regionModel->like('name', $search)
                ->orLike('description', $search);
            $regionModel->groupEnd();
        }

        $regions = $regionModel->findAll();

        // Her bölgeye unit_name ve structure_name ekle
        foreach ($regions as &$region) {
            $region['unit_name'] = $unitNames[$region['unit_id']] ?? 'Bilinmeyen Birim';
            $region['structure_name'] = $structureNames[$region['structure_id']] ?? 'Bilinmeyen Yapı';
        }
        unset($region); // Referans hatası olmaması için

        // Logo dosya yolunu belirle
        $logoPath = FCPATH . $settingsModel->getSettings()['site_logo'];
        $logoBase64 = '';

        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            $logoBase64 = ''; // Eğer logo yoksa boş bırak
        }

        $data = [
            'settings' => $settingsModel->getSettings(),
            'user' => $userModel->getUser(),
            'units' => $units,
            'structures' => $structures,
            'regions' => $regions,
            'logoBase64' => $logoBase64,
        ];

        return view('admin/pages/schools/region', $data);
    }




    public function createRegion()
    {
        $regionModel = new RegionModel();
        $companyId = session()->get('company_id');

        $data = [
            'company_id' => $companyId,
            'unit_id' => $this->request->getPost('unit_id'),
            'structure_id' => $this->request->getPost('structure_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($regionModel->insert($data)) {
            return redirect()->to('admin/schools/regions')->with('success', 'Bölge başarıyla eklendi.');
        } else {
            return redirect()->back()->with('error', 'Bölge eklenirken bir hata oluştu.');
        }
    }


    public function deleteRegion($id)
    {
        $regionModel = new RegionModel();

        if ($regionModel->delete($id)) {
            return redirect()->to('admin/schools/regions')->with('success', 'Bölge başarıyla silindi.');
        } else {
            return redirect()->back()->with('error', 'Bölge silinirken bir hata oluştu.');
        }
    }


    public function updateRegion($id)
    {
        $regionModel = new RegionModel();

        $data = [
            'unit_id' => $this->request->getPost('unit_id'),
            'structure_id' => $this->request->getPost('structure_id'),
            'region_name' => $this->request->getPost('region_name'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($regionModel->update($id, $data)) {
            return redirect()->to('admin/schools/regions')->with('success', 'Bölge başarıyla güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Bölge güncellenirken bir hata oluştu.');
        }
    }

}
