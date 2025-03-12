<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::form');


$routes->get('/login', 'AuthController::index'); // login sayfası
$routes->post('/login', 'AuthController::login'); // login sayfası kontırol işlemleri


$routes->get('/logout', 'AuthController::logout');


$routes->get('/qrcode/(:num)', 'QrScanningController::index/$1');
$routes->post('/qrcode/create', 'QrScanningController::create');





// 'admin' grubuna auth filtresini uygula
$routes->group('admin', ['filter' => 'auth'], function (RouteCollection $routes) {


    $routes->get('excel', 'ExcelController::index'); // Exel sayfası
    $routes->post('excel/save', 'ExcelController::read');



    $routes->group('companies', function (RouteCollection $routes) {
        $routes->get('', 'CompanyController::index'); // Şirketleri listeleme
        $routes->get('detail/(:num)', 'CompanyController::detail/$1'); // Şirket Bilgileri Detaylı Listeleme
        $routes->post('create', 'CompanyController::create'); // Yeni şirket ekleme
        $routes->post('update/(:num)', 'CompanyController::update/$1'); // Şirket güncelleme
        $routes->post('delete/(:num)', 'CompanyController::delete/$1'); // Şirket silme


        $routes->get('users', 'CompanyController::getUsers');
        $routes->post('users/create', 'CompanyController::createUser'); // Yeni kullanıcı ekleme
        $routes->post('users/delete/(:num)', 'CompanyController::deleteUser/$1');
        $routes->post('users/update/(:num)', 'CompanyController::updateUser/$1'); // Kullanıcı güncelleme


    });



    $routes->get('api/notifications', 'AdminController::getApiNotifications');


    $routes->get('generate-pdf/(:num)', 'PdfController::generatePdf/$1');


    $routes->group('notifications', function (RouteCollection $routes) {
        $routes->get('/', 'AdminController::Notification');
        $routes->get('page/(:num)', 'AdminController::Notification/$1'); // Sayfalama desteği
        $routes->post('filter', 'AdminController::filterNotifications'); // AJAX ile filtreleme
        $routes->post('update/(:num)', 'AdminController::update/$1');
        $routes->post('delete/(:num)', 'AdminController::delete/$1');
        $routes->post('create', 'AdminController::create');
    });





    $routes->group('schools', function ($routes) {
        $routes->get('units', 'SchoolsController::getUnits'); // ✅ Faculties yerine Units kullanıyoruz
        $routes->post('units/create', 'SchoolsController::createUnit');
        $routes->post('units/update/(:num)', 'SchoolsController::updateUnit/$1');
        $routes->delete('units/delete/(:num)', 'SchoolsController::deleteUnit/$1');

        $routes->get('structures', 'SchoolsController::getStructures');
        $routes->post('structures', 'SchoolsController::createStructure');
        $routes->put('structures/(:num)', 'SchoolsController::updateStructure/$1');
        $routes->delete('structures/delete/(:num)', 'SchoolsController::deleteStructure/$1');


        $routes->get('regions', 'SchoolsController::getRegions');
        $routes->post('regions/create', 'SchoolsController::createRegion'); // Yeni bölge oluşturma
        $routes->post('regions/update/(:num)', 'SchoolsController::updateRegion/$1'); // Güncelleme işlemi için
        $routes->delete('regions/(:num)', 'SchoolsController::deleteRegion/$1');



    });



    $routes->get('settings', 'SettingsController::index'); // Tek sayfa görüntüleme (GET)

    $routes->group('update', function (RouteCollection $routes) {
        $routes->post('profile', 'SettingsController::updateProfile'); // Profil güncelleme
        $routes->post('settings', 'SettingsController::updateSiteSettings'); // Site ayarları güncelleme
        $routes->post('email', 'SettingsController::updateEmail'); // Email ayarları güncelleme
    });

    $routes->group('risk', function (RouteCollection $routes) {

        // Risk profil sayfası (Index)
        $routes->get('/', 'RiskController::index'); // Risk ana sayfası veya profil görüntüleme

        // Risk Olasılığı işlemleri
        $routes->post('frequencies', 'RiskController::createFrequency'); // Yeni Risk Olasılığı ekleme
        $routes->put('frequencies/(:segment)', 'RiskController::updateFrequency/$1'); // Risk Olasılığını güncelleme
        $routes->delete('frequencies/(:segment)', 'RiskController::deleteFrequency/$1'); // Risk Olasılığını silme

        // Risk Şiddeti işlemleri
        $routes->post('sizes', 'RiskController::createSize'); // Yeni Risk Şiddeti ekleme
        $routes->put('sizes/(:segment)', 'RiskController::updateSize/$1'); // Risk Şiddetinü güncelleme
        $routes->delete('sizes/(:segment)', 'RiskController::deleteSize/$1'); // Risk Şiddetinü silme
    });


});




$routes->group('api', function (RouteCollection $routes) {
    $routes->get('companies', 'ApiController::getCompanies'); // Şirket → Birimler → Binalar → Bölgeler
    $routes->get('risk-data', 'ApiController::getRiskData');  // Risk → Frekans → Büyüklük
    $routes->get('get-structures-by-unit', 'ApiController::getStructuresByUnit');
});

