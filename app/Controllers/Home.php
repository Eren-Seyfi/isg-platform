<?php

namespace App\Controllers;
use App\Models\NotificationModel;
use CodeIgniter\Controller;

class Home extends BaseController
{
    public $helpers = ['url', 'form', 'admin_helper'];


    public function index(): string
    {
        return view('web/home');
    }

  public function form()
{
    $notificationModel = new NotificationModel();

    // Form verilerini al
    $data = [
        'company_id' => $this->request->getPost('company_id'), // Formdan gelen company_id kullanılıyor
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
        $newName = $image->getRandomName();
        $uploadPath = 'uploads/notifications/'; // Public dizini içinde olacak

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($image->move($uploadPath, $newName)) {
            $data['image'] = $uploadPath . $newName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Resim yüklenirken hata oluştu.');
        }
    }

    // Veritabanına kaydet
    if ($notificationModel->insert($data)) {
        return redirect()->to(base_url('/#form-doldur'))->with('success', 'Yeni bildirim başarıyla gönderildi.');
    } else {
        return redirect()->back()->withInput()->with('error', 'Bildirim gönderilirken hata oluştu.');
    }
}

}
