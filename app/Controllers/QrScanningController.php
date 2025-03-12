<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitModel;
use App\Models\StructureModel;
use App\Models\RegionModel;
use App\Models\NotificationModel;
use App\Models\CompanyModel;

class QrScanningController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];

    public function index($id)
    {
        $regionModel = new RegionModel();
        $department = $regionModel->find($id);
        $companyModel = new CompanyModel();

        // Eğer bölüm bulunamazsa hata döndür
        if (!$department) {
            return redirect()->to('/')->with('error', 'Bölüm bulunamadı.');
        }

        $unitModel = new UnitModel();
        $structureModel = new StructureModel();

        $unit = $unitModel->find($department['unit_id'] ?? null);
        $building = $structureModel->find($department['structure_id'] ?? null);
        $company = ($unit) ? $companyModel->find($unit['company_id'] ?? null) : null;

        $data = [
            'department' => $department,
            'unit' => $unit,
            'building' => $building,
            'company' => $company
        ];

        return view('web/qrscanning', $data);
    }

    public function create()
    {
        $notificationModel = new NotificationModel();

        // Form verilerini al
        $company_id = $this->request->getPost('company_id');
        $unit_id = $this->request->getPost('unit_id');
        $structure_id = $this->request->getPost('structure_id');
        $regions_id = $this->request->getPost('regions_id');
        $description = $this->request->getPost('description');

        // Boş alan kontrolü
        if (empty($company_id) || empty($unit_id) || empty($structure_id) || empty($regions_id) || empty($description)) {
            return redirect()->back()->withInput()->with('error', 'Tüm alanları doldurmanız gerekmektedir.');
        }

        $status = 'Yeni'; // Varsayılan durum

        // Resim yükleme işlemi
        $image = $this->request->getFile('image');
        $imagePath = null; // Resim yüklenmemişse boş bırak

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $fileType = $image->getMimeType();
            if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()->back()->withInput()->with('error', 'Yüklediğiniz dosya bir resim olmalıdır (JPEG, PNG, GIF).');
            }

            $newName = $image->getRandomName();
            $uploadPath =  'uploads/notifications/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($image->move($uploadPath, $newName)) {
                $imagePath = 'uploads/notifications/' . $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Resim yüklenirken bir hata oluştu.');
            }
        }

        // Veriyi kaydet
        $data = [
            'company_id' => $company_id, // Şirket ID ekledik
            'unit_id' => $unit_id,
            'structure_id' => $structure_id,
            'regions_id' => $regions_id,
            'description' => $description,
            'status' => $status,
        ];

        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        if ($notificationModel->insert($data)) {
            return redirect()->to('/')->with('success', 'Bildirim başarıyla kaydedildi.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Bildirimi kaydederken hata oluştu.');
        }
    }
}
