<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StructureModel;
use App\Models\RegionModel;
use App\Models\UnitModel;
use App\Models\NotificationModel;
use App\Models\RiskFrequencyModel;
use App\Models\RiskSizeModel;
use App\Models\SettingsModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];



    public function Notification($page = 1)
    {
        $settingsModel = new SettingsModel();
        $notificationModel = new NotificationModel();
        $frequencyModel = new RiskFrequencyModel();
        $sizeModel = new RiskSizeModel();
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();
        $regionModel = new RegionModel();
        $userModel = new UserModel();

        $company_id = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        if (!$company_id) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        $limit = 10;
        $offset = ($page - 1) * $limit;

        // 🔥 **Silinmemiş bildirimleri sadece ilgili şirket için çekiyoruz**
        $notifications = $notificationModel->where('company_id', $company_id)
            ->where('deleted_at', null) // **Silinmiş kayıtları dahil etme**
            ->orderBy('created_at', 'DESC')
            ->findAll($limit, $offset);

        // 🔥 **Toplam bildirim sayısını yalnızca ilgili şirket için ve silinmemiş kayıtlarla hesaplıyoruz**
        $totalNotifications = $notificationModel->where('company_id', $company_id)
            ->where('deleted_at', null)
            ->countAllResults();

        $totalPages = ceil($totalNotifications / $limit);

        // 🔥 **İlgili şirketin verilerini çekiyoruz**
        $frequencies = $frequencyModel->findAll();
        $sizes = $sizeModel->findAll();
        $faculties = $unitModel->where('company_id', $company_id)->where('deleted_at', null)->findAll();
        $buildings = $structureModel->where('company_id', $company_id)->where('deleted_at', null)->findAll();
        $departments = $regionModel->where('company_id', $company_id)->where('deleted_at', null)->findAll();
        $user = $userModel->where('company_id', $company_id)->first();

        // 🔥 **Map oluşturuyoruz (Performansı artırmak için)**
        $frequencyMap = array_column($frequencies, 'name', 'id');
        $sizeMap = array_column($sizes, 'name', 'id');
        $unitMap = array_column($faculties, 'name', 'id');
        $buildingMap = array_column($buildings, 'name', 'id');
        $departmentMap = array_column($departments, 'name', 'id');

        // 🔥 **Bildirimlere ilişkili bilgileri ekliyoruz**
        foreach ($notifications as &$notification) {
            $notification['frequency'] = $frequencyMap[$notification['risk_frequency_id']] ?? 'Bilinmiyor';
            $notification['size'] = $sizeMap[$notification['risk_size_id']] ?? 'Bilinmiyor';
            $notification['unit'] = $unitMap[$notification['unit_id']] ?? 'Bilinmiyor';
            $notification['building'] = $buildingMap[$notification['structure_id']] ?? 'Bilinmiyor';
            $notification['department'] = $departmentMap[$notification['regions_id']] ?? 'Bilinmiyor';
        }

        // 🔥 **View'e gönderilecek veriler**
        $data = [
            'settings' => $settingsModel->getSettings(),
            'notifications' => $notifications,
            'user' => $user,
            'frequencies' => $frequencies,
            'sizes' => $sizes,
            'faculties' => $faculties,
            'buildings' => $buildings,
            'departments' => $departments,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];

        return view('admin/pages/notifications', $data);
    }


    public function filterNotifications()
    {
        $notificationModel = new NotificationModel();
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();
        $regionModel = new RegionModel();

        $status = $this->request->getPost('status');
        $reportNumber = $this->request->getPost('report_number'); // Rapor numarası filtresi
        $searchQuery = $this->request->getPost('search_query'); // Arama filtresi
        $company_id = session()->get('company_id'); // Kullanıcının şirket ID'sini al

        if (!$company_id) {
            return $this->response->setJSON(["message" => "Şirket bilgisi bulunamadı!"])->setStatusCode(403);
        }

        // Bildirimleri alma sorgusu
        $query = $notificationModel->where('company_id', $company_id); // ✅ Şirket filtresi ekle

        if ($status && $status !== 'Tümü') {
            $query->where('status', $status);
        }

        if (!empty($reportNumber)) {
            $reportId = (int) str_replace("RPR-", "", $reportNumber);
            $query->where('id', $reportId)
                ->where('company_id', $company_id); // ✅ Şirket kontrolü ekle
        }

        if (!empty($searchQuery)) {
            $query->groupStart()
                ->like('description', $searchQuery)
                ->orLike('note', $searchQuery)
                ->groupEnd()
                ->where('company_id', $company_id); // ✅ Şirket kontrolü ekle
        }

        $notifications = $query->orderBy('created_at', 'DESC')->findAll();

        // ID -> İsim eşlemesi yapmak için map oluştur
        $unitMap = array_column($unitModel->where('company_id', $company_id)->findAll(), 'name', 'id');
        $buildingMap = array_column($structureModel->where('company_id', $company_id)->findAll(), 'name', 'id');
        $departmentMap = array_column($regionModel->where('company_id', $company_id)->findAll(), 'name', 'id');

        foreach ($notifications as &$notification) {
            $notification['unit'] = $unitMap[$notification['unit_id']] ?? 'Bilinmiyor';
            $notification['building'] = $buildingMap[$notification['structure_id']] ?? 'Bilinmiyor';
            $notification['department'] = $departmentMap[$notification['regions_id']] ?? 'Bilinmiyor';
            $notification['report_number'] = 'RPR-' . str_pad($notification['id'], 6, '0', STR_PAD_LEFT);
        }

        return $this->response->setJSON($notifications);
    }


    public function getApiNotifications()
    {
        $unitModel = new UnitModel();
        $structureModel = new StructureModel();
        $regionModel = new RegionModel();
        $company_id = session()->get('company_id');

        // Birim, bina ve bölgeleri getir
        $units = $unitModel->where('company_id', $company_id)->findAll();
        $buildings = $structureModel->where('company_id', $company_id)->findAll();
        $departments = $regionModel->where('company_id', $company_id)->findAll();

        // Birimleri eşleştir
        $schoolData = [];
        foreach ($units as $unit) {
            $unit_id = $unit['id'];
            $schoolData[$unit_id] = [
                'unit' => [
                    'id' => $unit_id,
                    'name' => $unit['name']
                ],
                'buildings' => []
            ];
        }

        // Binaları birimlere ekle
        foreach ($buildings as $building) {
            $unit_id = $building['unit_id'];
            if (isset($schoolData[$unit_id])) {
                $schoolData[$unit_id]['buildings'][] = [
                    'building' => [
                        'id' => $building['id'],
                        'name' => $building['name']
                    ],
                    'departments' => []
                ];
            }
        }

        // Bölümleri binalara ekle
        foreach ($departments as $department) {
            foreach ($schoolData as &$unit) {
                foreach ($unit['buildings'] as &$building) {
                    if ($building['building']['id'] === $department['structure_id']) {
                        $building['departments'][] = [
                            'id' => $department['id'],
                            'name' => $department['name']
                        ];
                    }
                }
            }
        }

        return $this->response->setJSON(array_values($schoolData));
    }



    public function update($id)
    {
        $notificationModel = new NotificationModel();
        $company_id = session()->get('company_id');

        // Şirket bazlı güncellenmesi gereken bildirimi al
        $existingNotification = $notificationModel->where('company_id', $company_id)->find($id);

        if (!$existingNotification) {
            return redirect()->to(base_url('admin/notifications'))->with('error', 'Bildirim bulunamadı veya yetkisiz erişim.');
        }

        $data = [
            'risk_frequency_id' => $this->request->getPost('risk_frequency_id'),
            'risk_size_id' => $this->request->getPost('risk_size_id'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'note' => $this->request->getPost('note'),
            'created_at' => $existingNotification['created_at'],
        ];

        $notificationModel->update($id, $data);

        return redirect()->to(base_url('admin/notifications'))->with('success', 'Bildirim başarıyla güncellendi.');
    }

    public function delete($id)
    {
        $notificationModel = new NotificationModel();
        $company_id = session()->get('company_id');

        // Şirket bazlı silme işlemi
        $notification = $notificationModel->where('company_id', $company_id)->find($id);

        if (!$notification) {
            return redirect()->to(base_url('admin/notifications'))->with('error', 'Bildirim bulunamadı veya yetkisiz erişim.');
        }

        $notificationModel->delete($id);

        return redirect()->to(base_url('admin/notifications'))->with('success', 'Bildirim başarıyla silindi.');
    }

    public function create()
    {
        $notificationModel = new NotificationModel();
        $company_id = session()->get('company_id');

        // Form verilerini al
        $data = [
            'company_id' => $company_id, // Bildirime şirket ID ekle
            'unit_id' => $this->request->getPost('unit_id'),
            'structure_id' => $this->request->getPost('structure_id'),
            'regions_id' => $this->request->getPost('regions_id'),
            'description' => $this->request->getPost('description'),
            'status' => 'Yeni',
            'note' => $this->request->getPost('note')
        ];

        // Resim yükleme işlemi
        $image = $this->request->getFile('image');
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

            $image->move($uploadPath, $newName);
            $data['image'] = 'uploads/notifications/' . $newName;
        }

        $notificationModel->insert($data);

        return redirect()->to(base_url('admin/notifications'))->with('success', 'Yeni bildirim başarıyla eklendi.');
    }
}
