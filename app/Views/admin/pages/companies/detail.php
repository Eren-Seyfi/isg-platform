<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<?= $this->section('style') ?>
<!-- Özel CSS: Tablonun renklerini özelleştiriyoruz -->
<style>
    /* Tablo başlığı */
    .table-custom thead {
        background-color: #2c3e50;
        /* Koyu mavi ton */
        color: #fff;
    }

    /* Hover efekti */
    .table-custom tbody tr:hover {
        background-color: rgb(0, 0, 0);
    }

    /* Tablo kenarlıkları */
    .table-custom td,
    .table-custom th {
        border: 1px solid #dee2e6;
    }
</style>
<?= $this->endSection() ?>

<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-building"></i> Şirket Detayları</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/companies') ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Sekme Menüsü -->
        <ul class="nav nav-pills mb-3" id="detailTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="company-tab" data-toggle="pill" href="#company" role="tab"
                    aria-controls="company" aria-selected="true">
                    <i class="fas fa-info-circle"></i> Firma Bilgileri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="personnel-tab" data-toggle="pill" href="#personnel" role="tab"
                    aria-controls="personnel" aria-selected="false">
                    <i class="fas fa-users"></i> Personel Bilgileri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notification-tab" data-toggle="pill" href="#notification" role="tab"
                    aria-controls="notification" aria-selected="false">
                    <i class="fas fa-bell"></i> Bildirim İstatistikleri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="location-tab" data-toggle="pill" href="#location" role="tab"
                    aria-controls="location" aria-selected="false">
                    <i class="fas fa-map-marker-alt"></i> Lokasyon & Bina
                </a>
            </li>
        </ul>

        <!-- Sekme İçerikleri -->
        <div class="tab-content" id="detailTabContent">
            <!-- Firma Bilgileri Sekmesi (Callout ile gösterişli) -->
            <div class="tab-pane fade show active" id="company" role="tabpanel" aria-labelledby="company-tab">
                <div class="row">
                    <div class="col-md-8">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info-circle"></i> Firma Bilgileri</h5>
                            <p><strong>ID:</strong> <?= esc($company['id']) ?></p>
                            <p><strong>Firma Adı:</strong> <?= esc($company['name']) ?></p>
                            <p><strong>Birim:</strong> <?= esc($company['unit']) ?></p>
                            <p><strong>Alt Başlık:</strong> <?= esc($company['subheading']) ?></p>
                            <p><strong>Açıklama:</strong> <?= esc($company['description']) ?></p>
                            <p><strong>Not:</strong> <?= esc($company['note']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url($company['image'] ?? 'uploads/default/1logo.png') ?>" alt="Logo"
                            class="img-fluid img-circle" style="max-height: 150px;">
                    </div>
                </div>
            </div>

            <!-- Personel Bilgileri Sekmesi -->
            <div class="tab-pane fade" id="personnel" role="tabpanel" aria-labelledby="personnel-tab">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Toplam Personel</span>
                                <span class="info-box-number"><?= count($personnel) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($personnel)): ?>
                    <div class="table-responsive">
                        <table id="personnelTable" class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad Soyad</th>
                                    <th>Email</th>
                                    <th>Görev</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($personnel as $person): ?>
                                    <tr>
                                        <td><?= esc($person['id']) ?></td>
                                        <td><?= esc($person['username']) ?>         <?= esc($person['surname']) ?></td>
                                        <td><?= esc($person['email']) ?></td>
                                        <td><?= esc($person['role']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Personel bulunmamaktadır.</p>
                <?php endif; ?>
            </div>

            <!-- Bildirim İstatistikleri Sekmesi -->
            <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-bell"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Toplam Bildirim</span>
                                <span class="info-box-number"><?= esc($notificationCount) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-hourglass-half"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Devam Eden Bildirimler</span>
                                <span class="info-box-number"><?= esc($pendingNotifications) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Çözülen Bildirimler</span>
                                <span class="info-box-number"><?= esc($resolvedNotifications) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Lokasyon & Bina Sekmesi: Tablolar Halinde -->
            <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                <h5>Birim Listesi</h5>
                <?php if (!empty($units)): ?>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Birim Adı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($units as $unit): ?>
                                    <tr>
                                        <td><?= esc($unit['id']) ?></td>
                                        <td><?= esc($unit['name']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Birim bulunmamaktadır.</p>
                <?php endif; ?>

                <h5>Bina Listesi</h5>
                <?php if (!empty($structures) && is_array($structures)): ?>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bina Adı</th>
                                    <th>Açıklama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($structures as $structure): ?>
                                    <tr>
                                        <td><?= esc($structure['id']) ?></td>
                                        <td><?= esc($structure['name']) ?></td>
                                        <td><?= esc($structure['description']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Bina bulunmamaktadır.</p>
                <?php endif; ?>

                <h5>Bölge Listesi</h5>
                <?php if (!empty($regions)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bölge Adı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($regions as $region): ?>
                                    <tr>
                                        <td><?= esc($region['id']) ?></td>
                                        <td><?= esc($region['name']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Bölge bulunmamaktadır.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="<?= base_url('admin/companies') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
</div>

<?= $this->section('javascript') ?>
<script>
    $(document).ready(function () {
        $('#personnelTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
            }
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>