<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\UserModel;


class SettingsController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];


    public function index()
    {
        // Kullanıcı ve site ayarları bilgilerini almak için modelleri yükle
        $userModel = new UserModel();
        $settingsModel = new SettingsModel();


        // Oturumdaki kullanıcı bilgilerini al
        $user = $userModel->getUser();
        // Site ayarlarını al
        $settings = $settingsModel->getSettings();


        // View'e verileri gönder
        return view('admin/pages/settings', [
            'user' => $user,
            'settings' => $settings,

        ]);
    }


    // Profil güncelleme
    public function updateProfile()
    {
        $userModel = new UserModel();

        // Formdan gelen verileri al
        $profileData = [
            'username' => $this->request->getPost('username'),
            'surname' => $this->request->getPost('surname'),
            'email' => $this->request->getPost('email'),
        ];

        // Şifre değişikliği varsa hashleyip ekle
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $profileData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Mevcut kullanıcı verisini al
        $user = $userModel->getUser();

        // Kullanıcı adı veya e-posta değişmiş mi kontrol et
        $dataChanged = ($profileData['username'] !== $user['username']) ||
            ($profileData['surname'] !== $user['surname']) ||
            ($profileData['email'] !== $user['email']) ||
            (!empty($password));

        // Eğer herhangi bir veri değişmişse güncelle
        if ($dataChanged) {
            $userModel->updateUser($profileData);
            return redirect()->to('/admin/settings')->with('success', 'Profil bilgileri başarıyla güncellendi.');
        }

        return redirect()->to('/admin/settings')->with('info', 'Hiçbir değişiklik yapılmadı.');
    }




}