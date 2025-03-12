<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

use App\Models\SettingsModel;

class AuthController extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];


    public function index(): string
    {
        $settingsModel = new SettingsModel();

        $data = [
            'settings' => $settingsModel->getSettings(),
        ];

        return view('admin/pages/login', $data);
    }

    public function login()
    {
        $model = new UserModel();
        $validation = \Config\Services::validation();
        $settingsModel = new SettingsModel();

        $validation->setRules([
            'email' => [
                'rules' => 'required|max_length[254]|is_not_unique[users.email]|valid_email',
                'errors' => [
                    'required' => 'E-posta alanı zorunludur.',
                    'max_length' => 'E-posta en fazla 254 karakter olmalıdır.',
                    'is_not_unique' => 'Bu e-posta mevcut değildir.',
                    'valid_email' => 'Lütfen geçerli bir e-posta adresi girin.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'Şifre alanı zorunludur.',
                    'min_length' => 'Şifre en az 4 karakter olmalıdır.'
                ]
            ]
        ]);

        if ($this->request->getMethod() === 'POST' && $validation->withRequest($this->request)->run()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $model->getEmail($email);

            if (!$user) {
                return view("admin/pages/login", [
                    'checklogin' => 'E-posta veya şifre hatalı.',
                    'settings' => $settingsModel->getSettings(),
                ]);
            }

            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id' => $user['id'],
                    'company_id' => $user['company_id'] ?? null,
                    'role' => $user['role'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'isLoggedIn' => true
                ]);

                // Kullanıcının rolüne göre yönlendirme yap
                if ($user['role'] === 'user') {
                    return redirect()->to('/admin/notifications');
                } else {
                    return redirect()->to('/admin/companies');
                }
            } else {
                return view("admin/pages/login", [
                    'checklogin' => 'E-posta veya şifre hatalı.',
                    'settings' => $settingsModel->getSettings(),
                ]);
            }
        } else {
            $errors = $validation->getErrors();
            return view('admin/pages/login', [
                'errors_login' => $errors,
                'settings' => $settingsModel->getSettings(),
            ]);
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
