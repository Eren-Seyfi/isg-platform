<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\RiskFrequencyModel;
use App\Models\RiskSizeModel;
use App\Models\CompanyModel; // Şirket modeli

class RiskController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];


    public function index()
    {
        $userModel = new UserModel();
        $settingsModel = new SettingsModel();
        $frequencyModel = new RiskFrequencyModel();
        $sizeModel = new RiskSizeModel();
        $companyModel = new CompanyModel();

        // Oturum açan kullanıcının bilgilerini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null; // Kullanıcının şirket ID'si

        if (!$companyId) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // Şirkete özel risk ayarlarını çek
        $frequencies = $frequencyModel->where('company_id', $companyId)->findAll();
        $sizes = $sizeModel->where('company_id', $companyId)->findAll();

        // View'e verileri gönder
        return view('admin/pages/risk', [
            'user' => $user,
            'settings' => $settingsModel->getSettings(),
            'frequencies' => $frequencies,
            'sizes' => $sizes,
        ]);
    }

    // Risk Olasılığı işlemleri
    public function createFrequency()
    {
        $frequencyModel = new RiskFrequencyModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // Formdan gelen verileri al
        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
            'company_id' => $companyId, // Şirkete özel olarak kaydet
        ];

        // Yeni Risk Olasılığını kaydet
        $frequencyModel->insert($data);

        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Olasılığı başarıyla eklendi.');
    }

    public function updateFrequency($id)
    {
        $frequencyModel = new RiskFrequencyModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // İlgili risk verisini al ve şirket ID eşleşiyor mu kontrol et
        $risk = $frequencyModel->find($id);
        if (!$risk || $risk['company_id'] != $companyId) {
            return redirect()->back()->with('error', 'Bu risk ayarına erişiminiz yok.');
        }

        // Güncellenecek verileri al
        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
        ];

        $frequencyModel->update($id, $data);

        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Olasılığı başarıyla güncellendi.');
    }

    public function deleteFrequency($id)
    {
        $frequencyModel = new RiskFrequencyModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // İlgili risk verisini al ve şirket ID eşleşiyor mu kontrol et
        $risk = $frequencyModel->find($id);
        if (!$risk || $risk['company_id'] != $companyId) {
            return redirect()->back()->with('error', 'Bu risk ayarına erişiminiz yok.');
        }

        $frequencyModel->delete($id);
        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Olasılığı başarıyla silindi.');
    }

    // Risk Şiddeti işlemleri
    public function createSize()
    {
        $sizeModel = new RiskSizeModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // Formdan gelen verileri al
        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
            'company_id' => $companyId,
        ];

        $sizeModel->insert($data);
        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Şiddeti başarıyla eklendi.');
    }

    public function updateSize($id)
    {
        $sizeModel = new RiskSizeModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // İlgili risk verisini al ve şirket ID eşleşiyor mu kontrol et
        $risk = $sizeModel->find($id);
        if (!$risk || $risk['company_id'] != $companyId) {
            return redirect()->back()->with('error', 'Bu risk ayarına erişiminiz yok.');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
        ];

        $sizeModel->update($id, $data);
        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Şiddeti başarıyla güncellendi.');
    }

    public function deleteSize($id)
    {
        $sizeModel = new RiskSizeModel();
        $userModel = new UserModel();

        // Kullanıcının şirket ID'sini al
        $user = $userModel->getUser();
        $companyId = $user['company_id'] ?? null;

        if (!$companyId) {
            return redirect()->back()->with('error', 'Şirket bilgisi bulunamadı.');
        }

        // İlgili risk verisini al ve şirket ID eşleşiyor mu kontrol et
        $risk = $sizeModel->find($id);
        if (!$risk || $risk['company_id'] != $companyId) {
            return redirect()->back()->with('error', 'Bu risk ayarına erişiminiz yok.');
        }

        $sizeModel->delete($id);
        return redirect()->to(base_url('admin/risk'))->with('success', 'Risk Şiddeti başarıyla silindi.');
    }
}
