<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<div class="row">
    
    <div class="col-12">
        <div class="card">

        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
    <h3 class="card-title text-primary mb-3 mb-md-0">
        <i class="fas fa-bell"></i> Bildirimler
    </h3>

    <div class="d-flex flex-wrap gap-2 align-items-center">
        <!-- Filtreleme Butonları -->
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-danger filter-button" data-status="Yeni">Yeni</button>
            <button type="button" class="btn btn-outline-warning filter-button" data-status="Devam Ediyor">Devam</button>
            <button type="button" class="btn btn-outline-success filter-button" data-status="Çözüldü">Çözüldü</button>
            <button type="button" class="btn btn-outline-secondary filter-button" data-status="Tümü">Tümü</button>
        </div>

        <!-- Yeni Bildirim Ekle Butonu -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNotificationModal">
            <i class="fas fa-plus-circle"></i> Ekle
        </button>
        
    </div>
    
</div>

<div class="input-group mb-3 px-4">
    <input type="text" id="reportNumberInput" class="form-control" placeholder="Rapor Numarası (Örn: RPR-000123)">
    <input type="text" id="searchQueryInput" class="form-control" placeholder="Açıklama veya Not Ara">
    <button class="btn btn-primary" id="searchReportButton">
        <i class="fas fa-search"></i> Ara
    </button>
</div>



<!-- Sayfalama (Pagination) -->
<div class="d-flex justify-content-center mt-3">
    <nav>
        <ul class="pagination pagination-sm">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= base_url('admin/notifications/page/' . ($currentPage - 1)) ?>">
                        <i class="fas fa-chevron-left"></i> Önceki
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="<?= base_url('admin/notifications/page/' . $i) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= base_url('admin/notifications/page/' . ($currentPage + 1)) ?>">
                        Sonraki <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarih</th>
                                <th>Resim</th>
                                <th>Birim</th>
                                <th>Bina</th>
                                <th>Bölge</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $index => $notification): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?=  date('Y-m-d H:i', strtotime($notification['created_at'])) ?>
                                    </td>
                                            <!-- Resim Alanı -->
            <td>
                <?php if (!empty($notification['image'])): ?>
                    <a href="<?= base_url($notification['image']) ?>" 
                       data-gallery="gallery<?= $notification['id'] ?>" 
                       data-glightbox="<?= base_url($notification['image']) ?>">
                        <img src="<?= base_url($notification['image']) ?>" 
                             alt="Risk Resmi" 
                             class="img-fluid img-thumbnail"
                             style="width: 80px; height: 60px; object-fit: cover;">
                    </a>
                <?php else: ?>
                    <p class="text-muted">Resim mevcut değil</p>
                <?php endif; ?>
            </td>
                                    <td><?= $notification['unit'] ?></td>
                                    <td><?= $notification['building'] ?></td>
                                    <td><?= $notification['department'] ?></td>

                                    <!-- Durum Yazıları -->
                                    <td>


                                        <?php if ($notification['status'] == 'Yeni'): ?>
                                            <button type="button" class="btn btn-danger btn-sm" disabled>
                                                <?= $notification['status'] ?>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($notification['status'] == 'Devam Ediyor'): ?>

                                            <button type="button" class="btn btn-warning btn-sm" disabled>
                                                <?= $notification['status'] ?>
                                            </button>

                                            <a href="<?= base_url('admin/generate-pdf/'.$notification['id'])?>" target="_blank" type="button" class="btn btn-primary btn-sm">
                                                Raporla <i class="fas fa-file-pdf"></i>
                                            </a>
                                          

                                        <?php endif; ?>

                                        <?php if ($notification['status'] == 'Çözüldü'): ?>

                                            <button type="button" class="btn btn-success btn-sm" disabled>
                                                <?= $notification['status'] ?>
                                            </button>

                                            <a href="<?= base_url('admin/generate-pdf/'.$notification['id'])?>" target="_blank" type="button" class="btn btn-primary btn-sm">
                                                Raporla <i class="fas fa-file-pdf"></i>
                                            </a>

                                        <?php endif; ?>


                                    </td>
                                    <!-- İşlem Butonları -->
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#editModal-<?= $notification['id'] ?>">Düzenle</button>

                                        <form method="post"
                                            action="<?= base_url('admin/notifications/delete/' . $notification['id']) ?>"
                                            onsubmit="return confirm('Bu bildirimi silmek istediğinizden emin misiniz?');"
                                            class="d-inline">
                                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                        </form>



                                    </td>



                                </tr>

                                <!-- Güncelleme Modalı -->
                                <div class="modal fade" id="editModal-<?= $notification['id'] ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Bildirim Güncelle</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post"
                                                action="<?= base_url('admin/notifications/update/' . $notification['id']) ?>">
                                                <div class="modal-body">
                                                    <div class="card bg-light p-3">
                                                        <h5 class="text-primary">Risk Detayları</h5>
                                                        <hr>
                                                        <div class="mb-3">
                                                            <label><strong>Risk Açıklaması:</strong></label>
                                                            <textarea name="description"
                                                                class="form-control"><?= $notification['description'] ?></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label><strong>Yönetici Not:</strong></label>
                                                            <textarea name="note" class="form-control"><?= $notification['note'] ?></textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label><strong>Risk Tarihi:</strong></label>
                                                                <input disabled type="datetime-local" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($notification['created_at'])) ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label><strong>Durum:</strong></label>
                                                                <select name="status" class="form-control">
                                                                    <option value="Yeni" <?= (isset($notification['status']) && $notification['status'] == 'Yeni') ? 'selected' : '' ?>>Yeni</option>
                                                                    <option value="Devam Ediyor"
                                                                        <?= (isset($notification['status']) && $notification['status'] == 'Devam Ediyor') ? 'selected' : '' ?>>Devam Ediyor</option>
                                                                    <option value="Çözüldü"
                                                                        <?= (isset($notification['status']) && $notification['status'] == 'Çözüldü') ? 'selected' : '' ?>>Çözüldü</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label><strong>Risk Olasılığı:</strong></label>
                                                                <select name="risk_frequency_id" class="form-control">
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach ($frequencies as $freq): ?>
                                                                        <option value="<?= $freq['id'] ?? 'Bilinmiyor'; ?>" <?= $notification['risk_frequency_id'] == $freq['id'] ? 'selected' : '' ?> >
                                                                            <?= $freq['name'] ?? 'Bilinmiyor'; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label><strong>Risk Şiddet:</strong></label>
                                                                <select name="risk_size_id" class="form-control">
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach ($sizes as $size): ?>
                                                                        <option value="<?= $size['id'] ?>"
                                                                            <?= $notification['risk_size_id'] == $size['id'] ? 'selected' : '' ?>>
                                                                            <?= $size['name'] ?? 'Bilinmiyor'; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($notification['image'])): ?>
    <div class="mt-3">
        <label><strong>Resimler:</strong></label>
        <div class="d-flex flex-wrap">
            <a href="<?= base_url(  $notification['image']) ?>"
                data-gallery="gallery<?= $notification['id'] ?>"
                data-glightbox="<?= base_url( $notification['image']) ?>"
                class="me-2 mb-2">
                <img src="<?= base_url( $notification['image']) ?>"
                    alt="Risk Resmi"
                    class="img-fluid img-thumbnail"
                    style="width: 150px; height: 100px; object-fit: cover;">
            </a>
        </div>
    </div>
<?php else: ?>
    <p class="text-muted">Resim bulunmamaktadır.</p>
<?php endif; ?>

                                                           
                                                     
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Kapat</button>
                                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Güncelleme Modalı -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Yeni Bildirim Ekle Modalı -->
<div class="modal fade" id="addNotificationModal" tabindex="-1" role="dialog" aria-labelledby="addNotificationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Başlık -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNotificationLabel">
                    <i class="fas fa-plus-circle"></i> Yeni Bildirim Ekle
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Kapat">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal İçerik -->
            <div class="modal-body">
                <form action="<?= base_url('admin/notifications/create') ?>" method="post" enctype="multipart/form-data">
                    
                <div class="form-group">
    <label for="birim-adı"><i class="fas fa-university"></i> Birim</label>
    <select id="birim-adı" name="unit_id" class="form-control">
        <option value="">Seçiniz</option>
    </select>
</div>

<div class="form-group">
    <label for="bina"><i class="fas fa-building"></i> Bina</label>
    <select id="bina" name="structure_id" class="form-control" disabled>
        <option value="">Seçiniz</option>
    </select>
</div>

<div class="form-group">
    <label for="bölge"><i class="fas fa-map-marker-alt"></i> Bölge</label>
    <select id="bölge" name="regions_id" class="form-control" disabled>
        <option value="">Seçiniz</option>
    </select>
</div>


                    <!-- Açıklama -->
                    <div class="form-group">
                        <label for="description"><i class="fas fa-file-alt"></i> Açıklama</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Örneğin: Bölgedeki laboratuvar ekipmanları eksik."></textarea>
                    </div>

                    <!-- Not -->
                    <div class="form-group">
                        <label for="note"><i class="fas fa-sticky-note"></i> Not</label>
                        <textarea id="note" name="note" class="form-control" rows="2" placeholder="Ekstra açıklama ekleyin..."></textarea>
                    </div>

                    <!-- Resim Yükleme -->
                    <div class="form-group">
                        <label for="image"><i class="fas fa-camera"></i> Resim Ekle</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>

                    <!-- Gönder Butonu -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<?= $this->endSection() ?>


<?= $this->section('javascript') ?>



<script>


document.addEventListener("DOMContentLoaded", function () {
    const birimSelect = document.getElementById("birim-adı");
    const binaSelect = document.getElementById("bina");
    const bolgeSelect = document.getElementById("bölge");

    binaSelect.disabled = true;
    bolgeSelect.disabled = true;

    let fakulteler = [];

    async function fetchFaculties() {
        try {
            const response = await fetch("<?= base_url('admin/api/notifications') ?>");
            const data = await response.json();
            fakulteler = data;

            birimSelect.innerHTML = '<option value="">Seçiniz</option>';
            fakulteler.forEach(item => {
                const option = document.createElement("option");
                option.value = item.unit.id;
                option.textContent = item.unit.name;
                birimSelect.appendChild(option);
            });

        } catch (error) {
            console.error("Fakülteler yüklenirken hata oluştu:", error);
        }
    }

    $('#addNotificationModal').on('shown.bs.modal', function () {
        fetchFaculties();
        binaSelect.innerHTML = '<option value="">Seçiniz</option>';
        bolgeSelect.innerHTML = '<option value="">Seçiniz</option>';
        binaSelect.disabled = true;
        bolgeSelect.disabled = true;
    });

    birimSelect.addEventListener("change", function () {
        const seciliBirimID = this.value;
        binaSelect.innerHTML = '<option value="">Seçiniz</option>';
        bolgeSelect.innerHTML = '<option value="">Seçiniz</option>';
        binaSelect.disabled = true;
        bolgeSelect.disabled = true;

        console.log("Seçilen Birim ID:", seciliBirimID);
        console.log("Tüm Fakülteler:", fakulteler);

        if (seciliBirimID) {
            const seciliBirim = fakulteler.find(item => String(item.unit.id) === String(seciliBirimID));
            console.log("Eşleşen Birim:", seciliBirim);

            if (seciliBirim && seciliBirim.buildings.length > 0) {
                seciliBirim.buildings.forEach(buildingItem => {
                    const option = document.createElement("option");
                    option.value = buildingItem.building.id;
                    option.textContent = buildingItem.building.name;
                    binaSelect.appendChild(option);
                });

                binaSelect.disabled = false;
            } else {
                console.warn("Bu birime bağlı bina bulunamadı!");
            }
        }
    });

    binaSelect.addEventListener("change", function () {
        const seciliBirimID = birimSelect.value;
        const seciliBinaID = this.value;
        bolgeSelect.innerHTML = '<option value="">Seçiniz</option>';
        bolgeSelect.disabled = true;

        console.log("Seçilen Bina ID:", seciliBinaID);

        if (seciliBirimID && seciliBinaID) {
            const seciliBirim = fakulteler.find(item => String(item.unit.id) === String(seciliBirimID));
            if (seciliBirim) {
                const seciliBina = seciliBirim.buildings.find(buildingItem => String(buildingItem.building.id) === String(seciliBinaID));
                if (seciliBina && seciliBina.departments.length > 0) {
                    seciliBina.departments.forEach(department => {
                        const option = document.createElement("option");
                        option.value = department.id;
                        option.textContent = department.name;
                        bolgeSelect.appendChild(option);
                    });

                    bolgeSelect.disabled = false;
                } else {
                    console.warn("Bu binaya bağlı bölge bulunamadı!");
                }
            }
        }
    });
});



</script>

<script>


document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".filter-button");
    const tableBody = document.querySelector("tbody");

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            const status = this.getAttribute("data-status");

            fetch("<?= base_url('admin/notifications/filter') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: "status=" + encodeURIComponent(status)
            })
            .then(response => response.json())
            .then(data => {
                console.log("Filtrelenmiş veri:", data);
                tableBody.innerHTML = ""; 

                data.forEach((notification, index) => {
                    // Resim alanını kontrol edip HTML çıktısını oluşturuyoruz.
                    let imageHTML = "";
                    if (notification.image) {
                        imageHTML = `<a href="<?= base_url() ?>${notification.image}" 
                                           data-gallery="gallery${notification.id}" 
                                           data-glightbox="<?= base_url() ?>${notification.image}">
                                        <img src="<?= base_url() ?>${notification.image}" 
                                             alt="Risk Resmi" 
                                             class="img-fluid img-thumbnail"
                                             style="width: 80px; height: 60px; object-fit: cover;">
                                     </a>`;
                    } else {
                        imageHTML = '<p class="text-muted">Resim mevcut değil</p>';
                    }

                    // Rapor butonunu ilgili statülerde ekliyoruz.
                    let reportButton = "";
                    if (notification.status === "Devam Ediyor" || notification.status === "Çözüldü") {
                        reportButton = `
                            <a href="<?= base_url('admin/generate-pdf/') ?>${notification.id}" target="_blank" 
                               class="btn btn-primary btn-sm">
                               Raporla <i class="fas fa-file-pdf"></i>
                            </a>`;
                    }

                    let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${notification.created_at}</td>
                        <td>${imageHTML}</td>
                        <td>${notification.unit || 'Bilinmiyor'}</td>
                        <td>${notification.building || 'Bilinmiyor'}</td>
                        <td>${notification.department || 'Bilinmiyor'}</td>
                        <td>
                            <button type="button" class="btn btn-${getStatusClass(notification.status)} btn-sm" disabled>
                                ${notification.status}
                            </button>
                            ${reportButton}
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-${notification.id}">Düzenle</button>
                            <form method="post" action="<?= base_url('admin/notifications/delete/') ?>${notification.id}" class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                            </form>
                        </td>
                    </tr>`;

                    tableBody.innerHTML += row;
                });

                // Yeni eklenen resim bağlantılarının lightbox etkisini aktive etmek için GLightbox'ı yeniden başlatıyoruz.
                if (typeof GLightbox !== 'undefined') {
                    const lightbox = GLightbox({
                        selector: '[data-glightbox]'
                    });
                    // Eğer kütüphaneniz reload methodu destekliyorsa; örn.:
                    // lightbox.reload();
                }
            })
            .catch(error => console.error("Filtreleme sırasında hata oluştu:", error));
        });
    });

    function getStatusClass(status) {
        return status === "Yeni" ? "danger" : status === "Devam Ediyor" ? "warning" : "success";
    }
});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("searchReportButton");
    const reportInput = document.getElementById("reportNumberInput");
    const searchInput = document.getElementById("searchQueryInput");
    const filterButtons = document.querySelectorAll(".filter-button");
    const tableBody = document.querySelector("tbody");

    function filterNotifications(status = "Tümü", reportNumber = "", searchQuery = "") {
        fetch("<?= base_url('admin/notifications/filter') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: `status=${encodeURIComponent(status)}&report_number=${encodeURIComponent(reportNumber)}&search_query=${encodeURIComponent(searchQuery)}`
        })
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = "";

            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='8' class='text-center text-danger'>Sonuç bulunamadı.</td></tr>";
                return;
            }

            data.forEach((notification, index) => {
                let imageHTML = notification.image ? `
                    <a href="<?= base_url() ?>${notification.image}" 
                       data-gallery="gallery${notification.id}" 
                       data-glightbox="<?= base_url() ?>${notification.image}">
                        <img src="<?= base_url() ?>${notification.image}" 
                             alt="Risk Resmi" 
                             class="img-fluid img-thumbnail"
                             style="width: 80px; height: 60px; object-fit: cover;">
                    </a>` : '<p class="text-muted">Resim mevcut değil</p>';

                let reportButton = notification.status === "Devam Ediyor" || notification.status === "Çözüldü" ? `
                    <a href="<?= base_url('admin/generate-pdf/') ?>${notification.id}" target="_blank" 
                       class="btn btn-primary btn-sm">
                       Raporla <i class="fas fa-file-pdf"></i>
                    </a>` : "";

                let row = `<tr>
                    <td>${notification.report_number}</td>
                    <td>${notification.created_at}</td>
                    <td>${imageHTML}</td>
                    <td>${notification.unit || 'Bilinmiyor'}</td>
                    <td>${notification.building || 'Bilinmiyor'}</td>
                    <td>${notification.department || 'Bilinmiyor'}</td>
                    <td>
                        <button type="button" class="btn btn-${getStatusClass(notification.status)} btn-sm" disabled>
                            ${notification.status}
                        </button>
                        ${reportButton}
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-${notification.id}">Düzenle</button>
                        <form method="post" action="<?= base_url('admin/notifications/delete/') ?>${notification.id}" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                        </form>
                    </td>
                </tr>`;

                tableBody.innerHTML += row;
            });

            if (typeof GLightbox !== 'undefined') {
                const lightbox = GLightbox({
                    selector: '[data-glightbox]'
                });
            }
        })
        .catch(error => console.error("Filtreleme sırasında hata oluştu:", error));
    }

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            filterNotifications(this.getAttribute("data-status"));
        });
    });

    searchButton.addEventListener("click", function () {
        const reportNumber = reportInput.value.trim();
        const searchQuery = searchInput.value.trim();
        filterNotifications("Tümü", reportNumber, searchQuery);
    });

    function getStatusClass(status) {
        return status === "Yeni" ? "danger" : status === "Devam Ediyor" ? "warning" : "success";
    }
});

</script>

<?= $this->endSection() ?>