# İSG Platformu

İş Sağlığı ve Güvenliği (İSG) Platformu, iş yerlerinde güvenlik önlemlerini artırmak, riskleri yönetmek ve hızlı aksiyon almayı sağlamak için geliştirilen bir sistemdir. Kullanıcılar, web uygulaması aracılığıyla iş yerindeki güvenlik ihlallerini QR kod tarayarak rapor edebilir.

## 📌 Özellikler

- 📷 **QR Kod ile Raporlama**: Kullanıcılar, çalışma alanlarında bulunan QR kodları tarayarak hızlıca rapor oluşturabilir.
- 📝 **Detaylı Risk Değerlendirmesi**: Risk seviyelerini belirleme ve önceliklendirme özellikleri.
- 📊 **İstatistikler ve Raporlar**: Toplanan verilerle kapsamlı analizler.
- 🔔 **Gerçek Zamanlı Bildirimler**: Yetkililere anında bilgilendirme yaparak hızlı aksiyon alma imkanı.
- 👥 **Çoklu Kullanıcı Desteği**: İşçiler, yöneticiler ve denetçiler için farklı kullanıcı rollerine sahip sistem.

## 🚀 Kurulum

### Gereksinimler
- **Backend ve Frontend**: CodeIgniter 4.6.0
- **Veritabanı**: MySQL / PostgreSQL
- **Diğer**: Docker (isteğe bağlı), Redis (önbellekleme için)

### 💻 Sistem Gereksinimleri
- PHP 8.2 veya üstü
- MySQL 8 veya PostgreSQL
- Apache/Nginx
- Redis (isteğe bağlı)
- Docker (isteğe bağlı)

### Adımlar

#### 1️⃣ Depoyu Klonlayın
```sh
 git clone https://github.com/Eren-Seyfi/isg-platform.git
 cd isg-platform
```

#### 2️⃣ CodeIgniter Bağımlılıklarını Yükleyin
```sh
 composer install
```

#### 3️⃣ .env Dosyasını Tanımlayın
Ana dizine `.env` dosyanızı oluşturun ve aşağıdaki gibi yapılandırın:

```
# CI_ENVIRONMENT = production
# CI_ENVIRONMENT = development

# CodeIgniter .env
app.baseURL = 'http://localhost:8000'
database.default.hostname = 'localhost'
database.default.database = 'isg'
database.default.username = 'root'
database.default.password = 'password'
database.default.DBDriver = 'MySQLi'
```

#### 4️⃣ Veritabanını Hazırlayın
```sh
php spark migrate
```

#### 5️⃣ Veritabanınına Örnek Veri Ekleyin
```sh
php spark db:seed DatabaseSeeder
```

#### 6️⃣ Sunucuyu Başlatın
```sh
php spark serve
```

## 📂 Proje Yapısı
```
├── app
│   ├── Controllers
│   │   ├── AdminController.php
│   │   ├── ApiController.php
│   │   ├── AuthController.php
│   │   ├── CompanyController.php
│   │   ├── ExcelController.php
│   │   ├── Home.php
│   │   ├── PdfController.php
│   │   ├── QrScanningController.php
│   │   ├── RiskController.php
│   │   ├── SchoolsController.php
│   │   ├── SettingsController.php
│   ├── Database
│   │   ├── Migrations
│   │   │   ├── UsersTable.php
│   │   │   ├── NotificationsTable.php
│   │   │   ├── SettingsTable.php
│   │   │   ├── UnitTable.php
│   │   │   ├── StructureTable.php
│   │   │   ├── RegionsTable.php
│   │   │   ├── RiskFrequenciesTable.php
│   │   │   ├── RiskSizesTable.php
│   │   │   ├── CompanyTable.php
│   │   ├── Seeds
│   │   │   ├── CompanySeeder.php
│   │   │   ├── DatabaseSeeder.php
│   │   │   ├── NotificationsSeeder.php
│   │   │   ├── RegionsSeeder.php
│   │   │   ├── RiskFrequenciesSeeder.php
│   │   │   ├── RiskSizesSeeder.php
│   │   │   ├── SettingsSeeder.php
│   │   │   ├── StructureSeeder.php
│   │   │   ├── UnitSeeder.php
│   │   │   ├── UserSeeder.php
│   ├── Filters
│   │   ├── AuthFilter.php
│   ├── Helpers
│   │   ├── admin_helper.php
│   ├── Models
│   │   ├── CompanyModel.php
│   │   ├── NotificationModel.php
│   │   ├── RegionModel.php
│   │   ├── RiskFrequencyModel.php
│   │   ├── RiskSizeModel.php
│   │   ├── SettingsModel.php
│   │   ├── StructureModel.php
│   │   ├── UnitModel.php
│   │   ├── UserModel.php
├── public
│   ├── assets
│   ├── uploads
│   ├── index.php
├── writable
│   ├── cache
│   ├── logs
│   ├── session
│   ├── uploads
```

## 🛠 API Dökümantasyonu
### 🔹 **Kullanıcı Girişi**

#### 📝 Örnek Hesaplar
- **Kullanıcı:** `user@example.com` / `user`
- **Super Admin:** `superadmin@example.com` / `superadmin`

## 📜 Lisans
Bu proje MIT Lisansı altında lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasına bakabilirsiniz.

---

🛠 **Geliştirici:** [Eren Seyfi](https://github.com/Eren-Seyfi/)
📧 **İletişim:** eren2002seyfi@gmail.com
🌍 **LinkedIn:** [linkedin.com/in/erenseyfi](https://www.linkedin.com/in/erenseyfi/)
🐦 **Twitter:** [twitter.com/_eren_seyfi](https://x.com/_eren_seyfi)