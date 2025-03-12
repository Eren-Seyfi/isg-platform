<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="İş Sağlığı Güvenliği Platformu">
    <meta name="keywords" content="İSG, İş Sağlığı, Güvenlik, Risk Yönetimi">
    <title>İSG Platformu</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/default/1logo.png') ?>" type="image/x-icon">
</head>

<body class="index-page bg-light">


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('uploads/default/logo.png') ?>" alt="İSG Logo" class="img-fluid" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Menüyü Aç/Kapat">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#uygulama-hakkında">Hakkında</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#form-doldur">Form Doldur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#biz-kimiz">Biz Kimiz?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#iletisim">İletişim</a>
                    </li>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a class="btn btn-outline-success ms-3"
                            href="<?= base_url(session()->get('role') == 'user' ? 'admin/notifications' : 'admin/companies'); ?>">
                            Admin
                        </a>
                    <?php else: ?>
                        <a class="btn btn-primary ms-3" href="<?= base_url('login'); ?>">Giriş Yap</a>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>


    <!-- Anasayfa -->
    <section id="home" class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="fw-bold">İş Sağlığı Güvenliği Platformu</h2>
                    <p>İSG Platformu, iş yerleri ve okullar için geliştirilen bir uygulamadır.</p>
                    <a href="#form-doldur" class="btn btn-primary mt-3">
                        <i class="fas fa-edit"></i> Form Doldur
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="<?= base_url('uploads/default/img_1.png') ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Uygulama Hakkında -->
    <section id="uygulama-hakkında" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Uygulama Hakkında</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <i class="fas fa-bullseye fa-3x text-primary"></i>
                    <h5 class="mt-3">Amacımız</h5>
                    <p>Amacımız, eğitim kurumları, şirketler ve diğer tüm işletmelerde iş sağlığı ve güvenliği
                        standartlarını yükseltmek ve bu alanlarda oluşabilecek risklerin hızla tespit edilmesini
                        sağlamaktır. Uygulamamız, lavabolar, kantin, laboratuvar gibi kritik alanlarda QR kodları
                        aracılığıyla, kullanıcıların gördükleri sorunları anında bildirmelerine olanak tanır. Böylece,
                        herhangi bir su borusu patlaması, elektrik kesintisi veya benzeri acil durumlar karşısında hızlı
                        ve etkili bir çözüm süreci başlatılır. İleri teknolojimizi kullanarak, iş sağlığı ve güvenliği
                        süreçlerini herkes için daha erişilebilir hale getiriyoruz.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-shield-alt fa-3x text-success"></i>
                    <h5 class="mt-3">Misyonumuz</h5>
                    <p>Misyonumuz, kullanıcıların güvenli çalışma ortamlarına sahip olmalarını sağlamak için yenilikçi
                        teknolojiler geliştirmektir. Mobilden taratılan QR kod ile, kullanıcıların yaşadıkları sorunları
                        kolayca
                        bildirerek resimli ve açıklamalı bir şekilde raporlamalarına imkan tanır. Bu bildirimler,
                        merkezi bir web admin paneline iletilir ve buradan yetkililer tarafından incelenerek gerekli
                        aksiyonlar alınır. İş sağlığı ve güvenliği alanında farkındalığı artırmayı, çalışanların
                        güvenliğine katkıda bulunmayı ve süreçlerin her zamankinden daha şeffaf ve yönetilebilir
                        olmasını sağlamayı amaçlıyoruz.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-eye fa-3x text-warning"></i>
                    <h5 class="mt-3">Vizyonumuz</h5>
                    <p>Vizyonumuz, dijital çözümler aracılığıyla iş sağlığı ve güvenliği alanında yenilikçi bir öncü
                        olmaktır. Eğitim kurumlarından büyük şirketlere kadar tüm sektörlerde güvenli ve sağlıklı
                        alanların oluşturulmasına katkıda bulunmayı hedefliyoruz. Kullanıcı dostu mobil ve web
                        çözümlerimizle, her kurumun iş sağlığı ve güvenliği süreçlerini daha etkili bir şekilde
                        yönetmesine olanak tanıyoruz. Uzun vadeli hedefimiz, teknolojiyi iş sağlığı süreçleriyle entegre
                        ederek risklerin minimuma indirildiği bir dünya yaratmaktır.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- form bilgilerinin istenilceği yer -->
    <section id="form-doldur" class="form_wrapper py-5">

        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 col-sm-12 mb-5 mb-md-0 text-center">
                    <img src="<?= base_url('uploads/default/logo.png') ?>" class="img-fluid rounded"
                        alt="Form Arkaplanı">
                </div>
                <div class="col-md-6 col-sm-12 ps-md-5">
                    <div class="card shadow-lg p-4 border-0 rounded">
                        <h2 class="text-center text-primary mb-4">Form Doldur</h2>
                        <!-- Flashdata mesajları -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('info')): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('info'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/') ?>" method="post" enctype="multipart/form-data">
                            <!-- Firma - Kurum Seçimi -->
                            <div class="mb-3">
                                <label for="company" class="form-label fw-bold">Firma - Kurum</label>
                                <select id="company" name="company_id" class="form-select">
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>

                            <!-- Birim Seçimi -->
                            <div class="mb-3">
                                <label for="unit" class="form-label fw-bold">Birim Adı</label>
                                <select id="unit" name="unit_id" class="form-select" disabled>
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>

                            <!-- Bina Seçimi -->
                            <div class="mb-3">
                                <label for="structure" class="form-label fw-bold">Bina</label>
                                <select id="structure" name="structure_id" class="form-select" disabled>
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>

                            <!-- Bölge Seçimi -->
                            <div class="mb-3">
                                <label for="region" class="form-label fw-bold">Bölge</label>
                                <select id="region" name="regions_id" class="form-select" disabled>
                                    <option value="">Seçiniz</option>
                                </select>
                            </div>

                            <!-- Açıklama -->
                            <div class="mb-3">
                                <label for="aciklama" class="form-label fw-bold">Açıklama</label>
                                <textarea id="aciklama" name="description" class="form-control"
                                    placeholder="Örneğin: Bölgedeki laboratuvar ekipmanları eksik." rows="3"></textarea>
                            </div>

                            <!-- Resim Yükleme -->
                            <div class="mb-3">
                                <label for="resim" class="form-label fw-bold">Resim Ekle</label>
                                <input type="file" id="resim" name="image" class="form-control">
                            </div>

                            <!-- Gönder Butonu -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Gönder
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- TÜBİTAK Logosu -->
    <section class="py-3 text-center bg-white">
        <img src="<?= base_url('assets/web/img/TUBITAK-Logo-png/Dikey.png') ?>" alt="TÜBİTAK" class="img-fluid"
            width="250">
        <p class="mt-2"><strong>Bu proje TÜBİTAK 2209-A desteği ile geliştirilmiştir.</strong></p>
    </section>

    <!-- Biz Kimiz? - Kayan Menü -->
    <section id="biz-kimiz" class="py-5 bg-dark text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Biz Kimiz?</h2>
            <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <!-- Üye 1 -->
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-md-4 text-center">
                                <img src="<?= base_url('assets/web/img/gokhankeven.jpeg') ?>"
                                    class="rounded-circle mb-3" width="150" height="150">
                                <h5>Dr. Öğr. Üyesi Gökhan Keven</h5>
                                <p>Proje Sorumlusu</p>
                                <small>Nevşehir Hacıbektaş Veli Üniversitesi Hacıbektaş Teknik Bilimler Meslek
                                    Yüksek Okulu Elektronik ve Otomasyon Bölüm Bşk.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Üye 2 -->
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-md-4 text-center">
                                <img src="<?= base_url('assets/web/img/eren.jpg') ?>" class="rounded-circle mb-3"
                                    width="150" height="150">
                                <h5>Eren Seyfi</h5>
                                <p>DevOps Engineer</p>
                                <small>Nevşehir Hacı Bektaş Veli Üniversitesi Bilgisayar Programcılığı
                                    bölümünden hem üniversite hem de bölüm birincisi olarak mezun oldum.
                                    Yazılım geliştirme ve sistem yönetimi konularında uzmanlaşarak DevOps
                                    alanında çalışıyorum.
                                    Backend ve altyapı optimizasyonu konusunda çeşitli projeler geliştirdim.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Üye 3 -->
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-md-4 text-center">
                                <img src="<?= base_url('assets/web/img/fatih.jpeg') ?>" class="rounded-circle mb-3"
                                    width="150" height="150">
                                <h5>Fatih Gönülkırmaz</h5>
                                <p>Frontend Developer</p>
                                <small>Nevşehir HacıBektaş Veli Üniversitesi Bilgisayar Programcılığı bölümünden
                                    mezun oldum.Sitenin Frontend Developer görevini üstlendim.Hali hazırda
                                    bir yazılım şirketinin teknik destek biriminde çalışmaktayım.</small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Carousel Navigasyon -->
                <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="iletisim" class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center text-lg-start">
                    <img src="<?= base_url('assets/web/img/logo.png') ?>" width="120" class="mb-3">
                    <p>Bu proje, <strong>TÜBİTAK 2209-A</strong> desteğiyle geliştirilmiştir.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <h5>İletişim</h5>
                    <p>
                        <a class="text-white" href="mailto:info@isgplatformu.com.tr">
                            <i class="fas fa-envelope"></i> info@isgplatformu.com.tr
                        </a>
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <h5>Bizi Takip Edin</h5>
                    <div class="d-flex flex-column align-items-center align-items-lg-end">
                        <a href="https://www.instagram.com/isgplatformu2025/" target="_blank"
                            class="text-white mb-2 d-flex align-items-center">
                            <i class="fab fa-instagram fa-lg me-2"></i> isgplatformu2025
                        </a>
                        <a href="https://www.linkedin.com/in/isg-platformu-b9067b354/" target="_blank"
                            class="text-white d-flex align-items-center">
                            <i class="fab fa-linkedin fa-lg me-2"></i> İSG Platformu
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form otomatik doldurma -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const companySelect = document.getElementById("company");
            const unitSelect = document.getElementById("unit");
            const structureSelect = document.getElementById("structure");
            const regionSelect = document.getElementById("region");
            // Başlangıçta tüm seçimleri devre dışı bırak
            unitSelect.disabled = true;
            structureSelect.disabled = true;
            regionSelect.disabled = true;

            let companyData = [];

            // API'den firma verilerini çekme
            async function fetchCompanies() {
                try {
                    const response = await fetch("/api/companies");
                    const data = await response.json();

                    companyData = data;

                    // Şirketleri dropdown'a ekleme
                    companySelect.innerHTML = '<option value="">Seçiniz</option>';
                    companyData.forEach((company) => {
                        const option = document.createElement("option");
                        option.value = company.id;
                        option.textContent = company.name;
                        companySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error("Error loading companies:", error);
                }
            }

            fetchCompanies();

            // Firma seçildiğinde bağlı birimleri getir
            companySelect.addEventListener("change", function () {
                const selectedCompanyID = this.value;
                unitSelect.innerHTML = '<option value="">Seçiniz</option>';
                structureSelect.innerHTML = '<option value="">Seçiniz</option>';
                regionSelect.innerHTML = '<option value="">Seçiniz</option>';
                unitSelect.disabled = true;
                structureSelect.disabled = true;
                regionSelect.disabled = true;

                if (selectedCompanyID) {
                    const selectedCompany = companyData.find(company => company.id == selectedCompanyID);

                    if (selectedCompany && selectedCompany.units.length > 0) {
                        selectedCompany.units.forEach((unit) => {
                            const option = document.createElement("option");
                            option.value = unit.id;
                            option.textContent = unit.name;
                            unitSelect.appendChild(option);
                        });

                        unitSelect.disabled = false;
                    }
                }
            });

            // Birim seçildiğinde binaları getir
            unitSelect.addEventListener("change", function () {
                const selectedCompanyID = companySelect.value;
                const selectedUnitID = this.value;
                structureSelect.innerHTML = '<option value="">Seçiniz</option>';
                regionSelect.innerHTML = '<option value="">Seçiniz</option>';
                structureSelect.disabled = true;
                regionSelect.disabled = true;

                if (selectedCompanyID && selectedUnitID) {
                    const selectedCompany = companyData.find(company => company.id == selectedCompanyID);
                    const selectedUnit = selectedCompany.units.find(unit => unit.id == selectedUnitID);

                    if (selectedUnit && selectedUnit.structures.length > 0) {
                        selectedUnit.structures.forEach((structure) => {
                            const option = document.createElement("option");
                            option.value = structure.id;
                            option.textContent = structure.name;
                            structureSelect.appendChild(option);
                        });

                        structureSelect.disabled = false;
                    }
                }
            });

            // Bina seçildiğinde bölgeleri getir
            structureSelect.addEventListener("change", function () {
                const selectedCompanyID = companySelect.value;
                const selectedUnitID = unitSelect.value;
                const selectedStructureID = this.value;
                regionSelect.innerHTML = '<option value="">Seçiniz</option>';
                regionSelect.disabled = true;

                if (selectedCompanyID && selectedUnitID && selectedStructureID) {
                    const selectedCompany = companyData.find(company => company.id == selectedCompanyID);
                    const selectedUnit = selectedCompany.units.find(unit => unit.id == selectedUnitID);
                    const selectedStructure = selectedUnit.structures.find(structure => structure.id == selectedStructureID);

                    if (selectedStructure && selectedStructure.regions.length > 0) {
                        selectedStructure.regions.forEach((region) => {
                            const option = document.createElement("option");
                            option.value = region.id;
                            option.textContent = region.name;
                            regionSelect.appendChild(option);
                        });

                        regionSelect.disabled = false;
                    }
                }
            });
        });
    </script>

    <!-- Navbar Altif Butonlar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let navLinks = document.querySelectorAll(".navbar-nav .nav-link");
            let navbarBrand = document.querySelector(".navbar-brand"); // Logo için
            let currentURL = window.location.hash; // Sayfa hash kısmını alır (örn. #form-doldur)

            function activateNavLink(target) {
                navLinks.forEach(link => link.classList.remove("active", "fw-bold", "text-primary"));
                target.classList.add("active", "fw-bold", "text-primary");
            }

            // Sayfa açıldığında "Anasayfa"yı aktif yap
            if (!currentURL || currentURL === "#home") {
                activateNavLink(document.querySelector('.navbar-nav .nav-link[href="#home"]'));
            } else {
                // URL'de hash varsa ilgili menüyü aktif yap
                let targetLink = document.querySelector(`.navbar-nav .nav-link[href="${currentURL}"]`);
                if (targetLink) {
                    activateNavLink(targetLink);
                }
            }

            // Bağlantıya tıklandığında aktif sınıfı değiştir
            navLinks.forEach(link => {
                link.addEventListener("click", function () {
                    activateNavLink(this);
                });
            });

            // **LOGO'ya tıklanınca Anasayfa butonu aktif olsun**
            if (navbarBrand) {
                navbarBrand.addEventListener("click", function () {
                    let homeLink = document.querySelector('.navbar-nav .nav-link[href="#home"]');
                    if (homeLink) {
                        activateNavLink(homeLink);
                    }
                });
            }
        });
    </script>

</body>

</html>