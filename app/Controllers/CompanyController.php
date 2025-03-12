<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyModel;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\StructureModel;
use App\Models\NotificationModel;
use App\Models\UnitModel;
use App\Models\RegionModel;

class CompanyController extends BaseController
{
    // Model nesnelerini sınıf genelinde kullanılabilir hale getiriyoruz.
    protected $companyModel;
    protected $userModel;
    protected $settingsModel;
    protected $notificationModel;
    protected $unitModel;
    protected $regionModel;
    protected $structureModel;
    public $helpers = ['url', 'form', 'admin_helper'];


    // Constructor içerisinde tüm modelleri yüklüyoruz.
    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->userModel = new UserModel();
        $this->settingsModel = new SettingsModel();
        $this->notificationModel = new NotificationModel();
        $this->unitModel = new UnitModel();
        $this->regionModel = new RegionModel();
        $this->structureModel = new StructureModel();
    }




    public function index()
    {
        // View'de kullanılacak verileri hazırlıyoruz.
        $data = [
            'user' => $this->userModel->getUser(),                    // Oturumdaki kullanıcı bilgileri
            'settings' => $this->settingsModel->getSettings(),            // Site ayarları
            'companies' => $this->companyModel->getActiveCompanies(),      // Aktif şirketlerin listesi
            'message' => session()->getFlashdata('message'),             // İşlem sonrası mesaj (başarılı)
            'error' => session()->getFlashdata('error')                // İşlem sırasında oluşan hata mesajı
        ];
        return view('admin/pages/companies/index', $data);
    }

    public function create()
    {
        $id = $this->request->getPost('company_id');
        $name = $this->request->getPost('name');
        $unit = $this->request->getPost('unit');
        $subheading = $this->request->getPost('subheading');
        $description = $this->request->getPost('description');
        $note = $this->request->getPost('note');

        if (!$name) {
            session()->setFlashdata('error', 'Şirket adı zorunludur.');
            return redirect()->to('admin/companies');
        }

        $data = [
            'name' => $name,
            'unit' => $unit,
            'subheading' => $subheading,
            'description' => $description,
            'note' => $note,
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newImageName = $image->getRandomName();
            $image->move('uploads/company', $newImageName);
            $data['image'] = 'uploads/company/' . $newImageName;
            if ($id) {
                $oldCompany = $this->companyModel->find($id);
                if ($oldCompany && $oldCompany['image'] !== 'uploads/company/default-logo.png') {
                    @unlink($oldCompany['image']);
                }
            }
        } else {
            if (!$id) {
                $data['image'] = 'uploads/default/1logo.png';
            }
        }

        if ($id) {
            $this->companyModel->update($id, $data);
            session()->setFlashdata('message', 'Şirket başarıyla güncellendi.');
        } else {
            $this->companyModel->insert($data);
            session()->setFlashdata('message', 'Şirket başarıyla eklendi.');
        }

        return redirect()->to('admin/companies');
    }

    public function delete($id)
    {
        if (!$this->companyModel->find($id)) {
            return redirect()->to('admin/companies')->with('error', 'Şirket bulunamadı.');
        }

        if ($this->companyModel->forceDeleteCompany($id)) {
            $this->companyModel->delete($id);
            return redirect()->to('admin/companies')->with('message', 'Şirket başarıyla silindi.');
        }

        return redirect()->to('admin/companies')->with('error', 'Şirket silinemedi.');
    }

    public function update($id)
    {
        $name = $this->request->getPost('name');
        $unit = $this->request->getPost('unit');
        $subheading = $this->request->getPost('subheading');
        $description = $this->request->getPost('description');
        $note = $this->request->getPost('note');

        $company = $this->companyModel->find($id);
        if (!$company) {
            session()->setFlashdata('error', 'Şirket bulunamadı.');
            return redirect()->to('admin/companies');
        }

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if ($company['image'] !== 'uploads/company/default-logo.png') {
                @unlink($company['image']);
            }
            $newImageName = $image->getRandomName();
            $image->move('uploads/company', $newImageName);
            $imagePath = 'uploads/company/' . $newImageName;
        } else {
            $imagePath = $company['image'];
        }

        $updated = $this->companyModel->update($id, [
            'name' => $name,
            'unit' => $unit,
            'subheading' => $subheading,
            'description' => $description,
            'note' => $note,
            'image' => $imagePath
        ]);

        if ($updated) {
            session()->setFlashdata('message', 'Şirket başarıyla güncellendi.');
        } else {
            session()->setFlashdata('error', 'Şirket güncellenirken hata oluştu.');
        }

        return redirect()->to('admin/companies');
    }

    public function detail($id)
    {
        // İlgili şirketi veritabanından çekiyoruz.
        $company = $this->companyModel->find($id);

        // Eğer şirket bulunamazsa, hata mesajı ile listeye yönlendiriyoruz.
        if (!$company) {
            session()->setFlashdata('error', 'Şirket bulunamadı.');
            return redirect()->to('admin/companies');
        }

        // Şirkete ait personel bilgilerini alıyoruz. (Sadece "user" rolündekiler)
        $personnel = $this->userModel
            ->where('company_id', $id)
            ->where('role', 'user')
            ->findAll();

        // Bildirim istatistiklerini çekiyoruz.
        $notificationCount = $this->notificationModel->where('company_id', $id)->countAllResults();
        $pendingNotifications = $this->notificationModel->where('company_id', $id)->where('status', 'Devam Ediyor')->countAllResults();
        $resolvedNotifications = $this->notificationModel->where('company_id', $id)->where('status', 'Çözüldü')->countAllResults();

        // Şirkete ait birim, bölge ve bina (yapı) listelerini çekiyoruz.
        $units = $this->unitModel->where('company_id', $id)->findAll();
        $regions = $this->regionModel->where('company_id', $id)->findAll();
        $structures = $this->structureModel->where('company_id', $id)->findAll();

        // View'e gönderilecek veriler.
        $data = [
            'company' => $company,
            'user' => $this->userModel->getUser(),
            'settings' => $this->settingsModel->getSettings(),
            'personnel' => $personnel,
            'notificationCount' => $notificationCount,
            'pendingNotifications' => $pendingNotifications,
            'resolvedNotifications' => $resolvedNotifications,
            'units' => $units,
            'regions' => $regions,
            'structures' => $structures
        ];

        // Detay view'ini yüklüyoruz.
        return view('admin/pages/companies/detail', $data);
    }


    public function getUsers()
    {
        $companyId = $this->request->getGet('company_id');
        $search = $this->request->getGet('search');

        $builder = $this->userModel
            ->select('users.id, users.username, users.surname, users.email, users.created_at, users.company_id, users.role, companies.name as company_name')
            ->join('companies', 'companies.id = users.company_id', 'left')
            ->where('users.role !=', 'superadmin');

        // Şirket filtrelemesi
        if (!empty($companyId)) {
            $builder->where('users.company_id', $companyId);
        }

        // Ad, soyad veya e-posta arama filtrelemesi
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('users.username', $search);
            $builder->orLike('users.surname', $search);
            $builder->orLike('users.email', $search);
            $builder->groupEnd();
        }

        $users = $builder->findAll();
        $companies = $this->companyModel->findAll();

        $data = [
            'user' => $this->userModel->getUser(),
            'settings' => $this->settingsModel->getSettings(),
            'users' => $users,
            'companies' => $companies,
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error')
        ];
        return view('admin/pages/companies/users', $data);
    }


    public function deleteUser($id)
    {
        if ($this->userModel->delete($id)) {
            session()->setFlashdata('message', 'Kullanıcı başarıyla silindi.');
        } else {
            session()->setFlashdata('error', 'Kullanıcı silinemedi.');
        }
        return redirect()->to('admin/companies/users');
    }

    public function updateUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Kullanıcı bulunamadı.');
            return redirect()->to('admin/companies/users');
        }

        $username = $this->request->getPost('username');
        $surname = $this->request->getPost('surname');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $company_id = $this->request->getPost('company_id');

        $data = [
            'username' => $username,
            'surname' => $surname,
            'email' => $email,
            'company_id' => $company_id
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $data);

        session()->setFlashdata('message', 'Kullanıcı başarıyla güncellendi.');
        return redirect()->to('admin/companies/users');
    }

    public function createUser()
    {
        $company_id = $this->request->getPost('company_id');
        $username = $this->request->getPost('username');
        $surname = $this->request->getPost('surname');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$company_id || !$username || !$surname || !$email || !$password) {
            session()->setFlashdata('error', 'Tüm alanları doldurmanız gerekmektedir.');
            return redirect()->to('admin/companies/users');
        }

        $existingUser = $this->userModel->where('email', $email)->first();
        if ($existingUser) {
            session()->setFlashdata('error', 'Bu e-posta adresi zaten kullanımda.');
            return redirect()->to('admin/companies/users');
        }

        $data = [
            'company_id' => $company_id,
            'username' => $username,
            'surname' => $surname,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->insert($data)) {
            session()->setFlashdata('message', 'Kullanıcı başarıyla eklendi.');
        } else {
            session()->setFlashdata('error', 'Kullanıcı eklenirken hata oluştu.');
        }

        return redirect()->to('admin/companies/users');
    }
}
