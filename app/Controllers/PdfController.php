<?php

namespace App\Controllers;


use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\NotificationModel;
use App\Models\UnitModel;
use App\Models\StructureModel;
use App\Models\RegionModel;
use App\Models\UserModel;
use App\Models\RiskFrequencyModel;
use App\Models\RiskSizeModel;
use App\Models\CompanyModel;

class PdfController extends Controller
{
    public $helpers = ['url', 'form', 'admin_helper'];

    public function generatePdf($id)
    {
        $RegionModel = new RegionModel();
        $notificationModel = new NotificationModel();
        $UnitModel = new UnitModel();
        $StructureModel = new StructureModel();
        $userModel = new UserModel();
        $frequencyModel = new RiskFrequencyModel();
        $sizeModel = new RiskSizeModel();
        $companyModel = new CompanyModel();

        $notification = $notificationModel->find($id);

        if (!$notification) {
            return redirect()->to('/')->with('error', 'Bölüm bulunamadı.');
        }

        $unit = $UnitModel->find($notification['unit_id']);
        $building = $StructureModel->find($notification['structure_id']);
        $department = $RegionModel->find($notification['regions_id']);
        $risksize = $sizeModel->find($notification['risk_size_id']);
        $riskfrequency = $frequencyModel->find($notification['risk_frequency_id']);
        $company = $companyModel->find(session()->get('company_id'));

        $user = $userModel->getUser();

        if (!$notification) {
            return redirect()->to('/')->with('error', 'Bölüme ait risk bildirimi bulunamadı.');
        }

        // DomPDF Türkçe karakter desteği
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Şirket logosunu Base64 formatına çevirme
        $defaultLogoPath = FCPATH . 'uploads/default/logo.png'; // Varsayılan logo
        $logoPath = !empty($company['image']) && file_exists(FCPATH . $company['image']) ? FCPATH . $company['image'] : $defaultLogoPath;

        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));


        // Risk resmi Base64 formatına çevirme
        $riskImageBase64 = '';
        if (!empty($notification['image'])) {
            $riskImagePath = FCPATH . '' . $notification['image'];
            if (file_exists($riskImagePath)) {
                $riskImageBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($riskImagePath));
            }
        }

        // Risk Durumu (Etiket Renkleri)
        $riskStatus = $notification['status'] ?? 'Yeni';
        $riskStatusColor = ($riskStatus == 'Çözüldü') ? 'green' : (($riskStatus == 'Devam Ediyor') ? 'orange' : 'red');

        // **Rapor Numarası** (ID üzerinden oluşturduk)
        $reportNumber = "RPR-" . str_pad($notification['id'], 6, "0", STR_PAD_LEFT);

        // PDF içeriği (HTML)
        $html = '
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <style>
                html,body {
                    font-family: DejaVu Sans, sans-serif;
                    padding: 0px;
                    margin: 0px;
                    color: #333;
                }
                .report-container {
                    width: 100vh;
                    border: 1px solid #ddd;
                    padding: 20px;
                    border-radius: 10px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header img {
                    width: 100px;
                }
                .title {
                    font-size: 20px;
                    font-weight: bold;
                    margin-top: 5px;
                }
                .subtitle {
                    font-size: 16px;
                    color: #007bff;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
              .report-number {
                font-size: 14px;
                font-weight: bold;
                background-color: #ddd;
                padding: 5px;
                border-radius: 5px;
                display: inline-block;
                 }
                .section {
                    margin-bottom: 15px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                }
                .section h4 {
                    background: #007bff;
                    color: white;
                    padding: 8px;
                    border-radius: 3px;
                    font-size: 16px;
                }
                .risk-image {
                    text-align: center;
                    margin-top: 10px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f1f1f1;
                }
                .risk-image img {
                    width: 400px;
                    height: 250px;
                    object-fit: cover;
                    border-radius: 5px;
                    border: 2px solid #007bff;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 1px solid #ddd;
                    color: #666;
                }
                .signature-container {
                    margin-top: 30px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    width: 50%;
                }
                .signature-line {
                    border-top: 1px solid #000;
                    width: 200px;
                    margin-top: 5px;
                }
            </style>
        </head>
        <body>
    
            <div class="report-container">
                <!-- Başlık ve Logo -->
                <div class="header">
                    <img src="' . $logoBase64 . '" alt="Şirket Logosu">
                    <div class="title">' . esc($company['name']) . '</div>
                    <div class="subtitle">' . esc($company['subheading']) . '</div>
                    <div class="report-number">Rapor No: ' . $reportNumber . '</div>
                </div>
    
                <!-- Rapor Bilgileri -->
                <div class="section">
                    <h4>Rapor Bilgileri</h4>
                    <p><strong>Raporu Oluşturan:</strong> ' . $user['username'] . ' ' . $user['surname'] . '</p>
                    <p><strong>Rapor Tarihi:</strong> ' . $notification['created_at'] . '</p>
                </div>
    
                <div class="section">
                    <h4>Birim ve Lokasyon</h4>
                    <p><strong>Birim:</strong> ' . ($unit['name'] ?? 'Mevcut değil') . '</p>
                    <p><strong>Bina:</strong> ' . ($building['name'] ?? 'Mevcut değil') . '</p>
                    <p><strong>Bölge:</strong> ' . ($department['name'] ?? 'Mevcut değil') . '</p>
                </div>
    
                <div class="section">
                    <h4>Risk Açıklaması</h4>
                    <p>' . ($notification['description'] ?? 'Mevcut değil') . '</p>
                </div>

                 <div class="section">
                    <h4>Yönetici Not</h4>
                    <p>' . ($notification['note'] ?? 'Mevcut değil') . '</p>
                </div>
    
                <div class="section">
                    <h4>Riskin Durumu</h4>
                    <p style="color: ' . $riskStatusColor . '; font-weight: bold;">' . $riskStatus . '</p>
                </div>
    
                <div class="section">
                    <h4>Risk Şiddet</h4>
                    <p>' . ($risksize['name'] ?? 'Mevcut değil') . '</p>
                </div>
    
                <div class="section">
                    <h4>Risk Olasılığı</h4>
                    <p>' . ($riskfrequency['name'] ?? 'Mevcut değil') . '</p>
                </div>
    
                ' . (!empty($riskImageBase64) ? '
                <div class="risk-image">
                    <h4>Riskin Resmi</h4>
                    <img src="' . $riskImageBase64 . '" alt="Risk Görseli">
                </div>' : '') . '
    
                <div class="footer">
                    <p>Bu rapor, ' . esc($company['name']) . ' tarafından oluşturulmuştur.</p>
                </div>
            </div>
    
        </body>
        </html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response->setHeader('Content-Type', 'application/pdf')->setHeader('Content-Disposition', 'attachment; filename="risk_raporu.pdf"')->setBody($dompdf->output());
    }
}
