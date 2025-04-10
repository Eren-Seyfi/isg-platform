<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<!-- Flash Mesajlar: Hata veya başarı mesajlarının gösterildiği alan -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- Bölge Oluşturma Formu -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Bölge Bilgileri</h3>
    </div>
    <!-- Form Başlangıcı: Yeni bölge ekleme formu -->
    <form action="<?= base_url('admin/schools/regions/create') ?>" method="post">
        <?= csrf_field(); ?>
        <div class="card-body">
            <!-- Birim Seçimi: Kullanıcının yeni bölge için ait olduğu birimi seçmesi -->
            <div class="form-group">
                <label for="unit">Birim Seçimi</label>
                <select class="form-control" id="unit" name="unit_id" required>
                    <option value="">Birim Seçin</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Bina Seçimi: Seçilen birime bağlı bina seçimi (önce birim seçilmesi gerekir) -->
            <div class="form-group">
                <label for="structure">Bina Seçimi</label>
                <select class="form-control" id="structure" name="structure_id" required disabled>
                    <option value="">Önce Birim Seçin</option>
                </select>
            </div>
            <!-- Bölge İsmi: Oluşturulacak bölgenin isminin girileceği alan -->
            <div class="form-group">
                <label for="region_name">Bölge İsmi</label>
                <input type="text" name="name" id="region_name" class="form-control" placeholder="Bölge ismi girin"
                    required disabled>
            </div>
            <!-- Bölge Açıklaması: Oluşturulacak bölge ile ilgili açıklamanın girileceği alan -->
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea name="description" id="description" class="form-control" placeholder="Açıklama girin"
                    disabled></textarea>
            </div>
        </div>
        <!-- Form Kaydet Butonu: Form gönderildiğinde yeni bölge kaydedilir (başlangıçta devre dışı) -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Kaydet</button>
        </div>
    </form>
</div>

<!-- Bölge Listesi: Kayıtlı bölgelerin listelendiği alan -->
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Bölgeler</h3>
                <div class="card-tools">
                    <!-- Filtreleme Formu: Bölge listesini birim, bina ve metin aramasına göre filtreler -->
                    <form action="<?= base_url('admin/schools/regions') ?>" method="get" style="display:inline-block;">
                        <div class="input-group input-group-sm" style="width: 600px;">
                            <!-- Birim Filtreleme Dropdown'u -->
                            <select name="unit_filter" class="form-control">
                                <option value="">Tüm Birimler</option>
                                <?php foreach ($units as $unit): ?>
                                    <option value="<?= $unit['id'] ?>" <?= request()->getGet('unit_filter') == $unit['id'] ? 'selected' : '' ?>>
                                        <?= $unit['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Bina Filtreleme Dropdown'u -->
                            <select name="structure_filter" class="form-control">
                                <option value="">Tüm Binalar</option>
                                <?php foreach ($structures as $structure): ?>
                                    <option value="<?= $structure['id'] ?>"
                                        <?= request()->getGet('structure_filter') == $structure['id'] ? 'selected' : '' ?>>
                                        <?= $structure['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Bölge Arama Alanı: Bölge ismine göre arama yapar -->
                            <input type="text" name="search" class="form-control" placeholder="Bölge Ara"
                                value="<?= esc(request()->getGet('search')) ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Toplu PDF İndirme Butonu: Listelenen bölgelerin tümü için PDF oluşturur -->
                    <button type="button" class="btn btn-success btn-sm" onclick="generateBulkPDF()"
                        style="margin-left:10px;">
                        <i class="fas fa-file-pdf"></i> Toplu PDF İndir
                    </button>
                </div>
            </div>
            <!-- Tablo: Bölge verilerinin listelendiği alan -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Birim</th>
                            <th>Bina</th>
                            <th>Bölge İsmi</th>
                            <th>Açıklama</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($regions as $region): ?>
                            <tr>
                                <td><?= $region['id'] ?></td>
                                <td><?= $region['unit_name'] ?></td> <!-- Birim adı -->
                                <td><?= $region['structure_name'] ?></td> <!-- Bina adı -->
                                <td><?= $region['name'] ?></td> <!-- Bölge adı -->
                                <td><?= $region['description'] ?></td>
                                <td><?= $region['created_at'] ?></td>
                                <td>
                                    <!-- Düzenle Butonu: Modal açarak düzenleme yapmayı sağlar -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editRegionModal-<?= $region['id'] ?>">
                                        <i class="fas fa-edit"></i> Düzenle
                                    </button>
                                    <!-- PDF İndir Butonu: Tekil PDF oluşturur -->
                                    <button type="button"
                                       onclick="generatePDF(
    '<?= $region['id'] ?>', 
    '<?= $region['name'] ?>',
    '<?= $region['unit_name'] ?>',
    '<?= $region['description'] ?>',
    '<?= $region['structure_name'] ?>'
)"

                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-file-pdf"></i> PDF İndir
                                    </button>
                                    <!-- Silme Butonu: Bölge kaydını siler -->
                                    <form action="<?= base_url('/admin/schools/regions/' . $region['id']) ?>" method="post"
                                        onsubmit="return confirm('Bu bölgeyi silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger">Sil</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Düzenleme Modalı: Bölge düzenleme formu modal içinde -->
                            <div class="modal fade" id="editRegionModal-<?= $region['id'] ?>" tabindex="-1"
                                aria-labelledby="editRegionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRegionModalLabel">Bölge Düzenle:
                                                <?= $region['name'] ?>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('/admin/schools/regions/update/' . $region['id']) ?>"
                                            method="post">
                                            <input type="hidden" name="_method" value="POST">
                                            <div class="modal-body">
                                                <!-- Modal içindeki form alanları: Birim, Bina, Bölge İsmi ve Açıklama -->
                                                <div class="form-group">
                                                    <label for="unit-<?= $region['id'] ?>">Birim Seçimi</label>
                                                    <select class="form-control unit-select" id="unit-<?= $region['id'] ?>"
                                                        name="unit_id" required data-region-id="<?= $region['id'] ?>">
                                                        <option value="">Birim Seçin</option>
                                                        <?php foreach ($units as $unit): ?>
                                                            <option value="<?= $unit['id'] ?>"
                                                                <?= $unit['id'] == $region['unit_id'] ? 'selected' : '' ?>>
                                                                <?= $unit['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="structure-<?= $region['id'] ?>">Bina Seçimi</label>
                                                    <select class="form-control structure-select"
                                                        id="structure-<?= $region['id'] ?>" name="structure_id" required
                                                        data-selected-id="<?= $region['structure_id'] ?>">
                                                        <option value="">Yükleniyor...</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="region_name-<?= $region['id'] ?>">Bölge İsmi</label>
                                                    <input type="text" name="name" id="region_name-<?= $region['id'] ?>"
                                                        class="form-control" value="<?= $region['name'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description-<?= $region['id'] ?>">Açıklama</label>
                                                    <textarea name="description" class="form-control"
                                                        id="description-<?= $region['id'] ?>"
                                                        required><?= $region['description'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Filtre verilerinin ve diğer değişkenlerin JavaScript'e aktarılması -->
<script>
    // regionsData: Liste halinde tüm bölge verileri (JSON formatında)
    var regionsData = <?= json_encode($regions) ?>;
    // logoBase64: Logonun base64 kodlu verisi
    var logoBase64 = "<?= $logoBase64 ?>";
  var logo2Base64 = "<?= $logo2Base64 ?>";

</script>

<?= $this->section('javascript') ?>

<!-- Filtre formundaki Birim seçimine göre Bina filtre seçeneklerini güncelleyen AJAX kodu -->
<script>
    $(document).ready(function () {
        // 'unit_filter' dropdown'unda seçim değiştiğinde çalışır
        $('select[name="unit_filter"]').change(function () {
            var unitId = $(this).val();
            var structureFilter = $('select[name="structure_filter"]');
            if (unitId) {
                // Belirli birim seçildiyse, ilgili binaları getirmek için AJAX isteği yapılır
                $.ajax({
                    url: "<?= base_url('/api/get-structures-by-unit') ?>",
                    type: "GET",
                    data: { unit_id: unitId },
                    dataType: "json",
                    success: function (data) {
                        structureFilter.empty();
                        // İlk seçenek "Tüm Binalar" olarak eklenir
                        structureFilter.append('<option value="">Tüm Binalar</option>');
                        if (data.length > 0) {
                            $.each(data, function (i, structure) {
                                structureFilter.append('<option value="' + structure.id + '">' + structure.name + '</option>');
                            });
                        } else {
                            structureFilter.append('<option value="">Bina Bulunamadı</option>');
                        }
                    },
                    error: function () {
                        structureFilter.empty();
                        structureFilter.append('<option value="">Hata Oluştu</option>');
                    }
                });
            } else {
                // "Tüm Birimler" seçiliyse, tüm binalar listelenir
                structureFilter.empty();
                structureFilter.append('<option value="">Tüm Binalar</option>');
                var allStructures = <?= json_encode($structures) ?>;
                if (allStructures.length > 0) {
                    $.each(allStructures, function (i, structure) {
                        structureFilter.append('<option value="' + structure.id + '">' + structure.name + '</option>');
                    });
                }
            }
        });
    });
</script>

<!-- Tekil PDF oluşturma fonksiyonu: Belirtilen bölge için PDF oluşturur -->
<script>

    function generatePDF(regionId, regionName, unitName,description, structureName) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        // Roboto fontunu ekliyoruz (Türkçe karakter desteği için)
        doc.addFont("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf", "Roboto", "normal");
        doc.setFont("Roboto");
        // QR kod için URL oluşturulur
        let qrCodeUrl = `${window.location.origin}/qrcode/${regionId}`;
        // PDF sayfası çerçevesi çizilir
        doc.setDrawColor(0);
        doc.setLineWidth(1);
        doc.rect(10, 10, 190, 270);
        if (logoBase64) {
            // Logoyu PDF'ye ekler
            doc.addImage(logoBase64, "PNG", 15, 15, 40, 30);
            
            // Aynı logoyu sağ üst köşeye ekler (sayfa genişliği 210mm, sağdan 15mm boşluk kalacak şekilde)
            doc.addImage(logo2Base64, "PNG", 155, 15, 40, 30);
            
        }
        doc.setFontSize(22);
        doc.setFont("Roboto");
        doc.text("Bölge Bilgileri", 70, 30);
        doc.setFontSize(14);
        doc.setFont("Roboto");
        doc.text(`Birim: ${unitName}`, 20, 50);
        doc.text(`Bina: ${structureName}`, 20, 60);
        doc.text(`Bölge: ${regionName}`, 20, 70);
        
    // Açıklamayı satırlara bölerek yazdır
  

        
        // QR kodu oluşturmak için geçici bir canvas kullanılır
        let qrCanvas = document.createElement("canvas");
        let qrCode = new QRCode(qrCanvas, {
            text: qrCodeUrl,
            width: 100,
            height: 100
        });
       
        setTimeout(() => {
            let qrImage = qrCanvas.querySelector("img");
            if (qrImage) {
                let imgData = qrImage.src;
                doc.addImage(imgData, "PNG", 75, 100, 60, 60);
            }
            
            
// =======================================================================
    const pageHeight = doc.internal.pageSize.getHeight();
    const pageWidth = doc.internal.pageSize.getWidth();

        // Açıklama yazısını yazdır: QR altı = 200
        doc.setFontSize(16);

        const maxWidth = 160;
        const lineHeight = 8;
        const startY = 200;
        const descLines = doc.splitTextToSize(description, maxWidth);
        let y = startY;

        descLines.forEach((line, index) => {
            if (y + lineHeight > pageHeight - 10) {
                doc.addPage();
                y = 20;
            }
            const textWidth = doc.getTextWidth(line);
            const x = (pageWidth - textWidth) / 2;
            doc.text(line, x, y);
            y += lineHeight;
        });



// =======================================================================
            
            // Tekil PDF dosyası ismi, bölge ismine göre oluşturulur
            doc.save(`Bölge_${regionName}.pdf`);
        }, 1000);
    }
</script>

<!-- Toplu PDF oluşturma fonksiyonu: Filtreye göre listelenen tüm bölgeler için tek PDF oluşturur -->
<script>
    async function generateBulkPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        // Roboto fontu eklenir
        doc.addFont("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf", "Roboto", "normal");
        doc.setFont("Roboto");
        if (regionsData.length === 0) {
            alert("İndirilecek bölge bulunamadı.");
            return;
        }
        // Her bölge için döngü
        for (let i = 0; i < regionsData.length; i++) {
            const region = regionsData[i];
            if (i > 0) {
                doc.addPage();
            }
            if (logoBase64) {
                doc.addImage(logoBase64, "PNG", 15, 15, 40, 30);
                
                // Aynı logoyu sağ üst köşeye ekler (sayfa genişliği 210mm, sağdan 15mm boşluk kalacak şekilde)
                doc.addImage(logo2Base64, "PNG", 155, 15, 40, 30);
            }
            doc.setFontSize(22);
            doc.setFont("Roboto");
            doc.text("Bölge Bilgileri", 70, 30);
            doc.setFontSize(14);
            doc.setFont("Roboto");
            doc.text(`Birim: ${region.unit_name}`, 20, 50);
            doc.text(`Bina: ${region.structure_name}`, 20, 60);
            doc.text(`Bölge: ${region.name}`, 20, 70);
            
            // Her bölge için asenkron QR kod oluşturulur ve eklenir
            let qrImgData = await generateQR(region.id);
            if (qrImgData) {
                doc.addImage(qrImgData, "PNG", 75, 100, 60, 60);
                
              
            }
// =======================================================================

doc.setFontSize(16);

const maxWidth = 160;
const lineHeight = 8;
const startY = 200;
const descLines = doc.splitTextToSize(region.description, maxWidth);
let y = startY;

descLines.forEach((line) => {
    if (y + lineHeight > doc.internal.pageSize.getHeight() - 10) {
        doc.addPage();
        y = 20;
    }
    const textWidth = doc.getTextWidth(line);
    const x = (doc.internal.pageSize.getWidth() - textWidth) / 2;
    doc.text(line, x, y);
    y += lineHeight;
});


// =======================================================================
        }
        // Dosya adı için varsayılan olarak "Tüm Birimler" ve "Tüm Binalar" kullanılacak
        let unitText = <?= json_encode(request()->getGet('unit_filter') ? request()->getGet('unit_filter') : "Tüm_Birimler") ?>;
        let structureText = <?= json_encode(request()->getGet('structure_filter') ? request()->getGet('structure_filter') : "Tüm_Binalar") ?>;
        // Dosya adı oluşturulur; arama filtresi varsa eklenir
        let fileName = `Toplu_${unitText}_${structureText}`;
        let searchFilter = <?= json_encode(request()->getGet('search') ? request()->getGet('search') : "") ?>;
        if (searchFilter) {
            fileName += `_search-${encodeURIComponent(searchFilter)}`;
        }
        fileName += ".pdf";
        doc.save(fileName);
    }

    // Asenkron QR kod oluşturma fonksiyonu: Belirtilen bölge ID'sine göre QR kodu üretir
    function generateQR(regionId) {
        return new Promise((resolve, reject) => {
            let qrCanvas = document.createElement("canvas");
            new QRCode(qrCanvas, {
                text: `${window.location.origin}/qrcode/${regionId}`,
                width: 100,
                height: 100
            });
            // QR kodun render edilmesi için 1 saniye bekletiyoruz
            setTimeout(() => {
                let qrImage = qrCanvas.querySelector("img");
                if (qrImage) {
                    resolve(qrImage.src);
                } else {
                    resolve(null);
                }
            }, 1000);
        });
    }
</script>

<!-- Düzenle modalı için birim ve bina seçimlerinin güncellenmesi: Modal içinde seçilen birime göre ilgili binalar getirilir -->
<script>
    $(document).ready(function () {
        $(".unit-select").each(function () {
            let unitSelect = $(this);
            let unitId = unitSelect.val(); // Seçili birim ID'si
            let regionId = unitSelect.data("region-id"); // Modal için bölge ID'si
            let structureSelect = $("#structure-" + regionId);
            if (unitId) {
                fetchStructures(unitId, structureSelect, structureSelect.attr("data-selected-id"));
            }
        });
        $(".unit-select").change(function () {
            let unitSelect = $(this);
            let unitId = unitSelect.val();
            let regionId = unitSelect.data("region-id");
            let structureSelect = $("#structure-" + regionId);
            structureSelect.html('<option value="">Yükleniyor...</option>');
            if (unitId) {
                fetchStructures(unitId, structureSelect, null);
            } else {
                structureSelect.html('<option value="">Önce Birim Seçin</option>');
            }
        });
        // Belirli birim için bina seçeneklerini getiren AJAX fonksiyonu
        function fetchStructures(unitId, structureSelect, selectedStructureId) {
            $.ajax({
                url: "<?= base_url('/api/get-structures-by-unit') ?>",
                type: "GET",
                data: { unit_id: unitId },
                dataType: "json",
                success: function (response) {
                    structureSelect.html('');
                    if (response.length > 0) {
                        response.forEach(function (structure) {
                            let isSelected = selectedStructureId == structure.id ? "selected" : "";
                            structureSelect.append(
                                `<option value="${structure.id}" ${isSelected}>${structure.name}</option>`
                            );
                        });
                    } else {
                        structureSelect.html('<option value="">Bina Bulunamadı</option>');
                    }
                },
                error: function () {
                    structureSelect.html('<option value="">Hata Oluştu</option>');
                },
            });
        }
    });
</script>

<!-- Yeni bölge oluşturma formu için birim ve bina seçimi: Ana formdaki dropdown'lar güncellenir -->
<script>
    $(document).ready(function () {
        let unitSelect = $("#unit");
        let structureSelect = $("#structure");
        let regionNameInput = $("#region_name");
        let descriptionInput = $("#description");
        let submitButton = $("#submit-btn");
        // Ana formdaki birim seçildiğinde ilgili binalar getirilir
        unitSelect.change(function () {
            let unitId = $(this).val();
            structureSelect.html('<option value="">Yükleniyor...</option>');
            structureSelect.prop("disabled", true);
            regionNameInput.prop("disabled", true);
            descriptionInput.prop("disabled", true);
            submitButton.prop("disabled", true);
            if (unitId) {
                $.ajax({
                    url: "<?= base_url('/api/get-structures-by-unit') ?>",
                    type: "GET",
                    data: { unit_id: unitId },
                    dataType: "json",
                    success: function (response) {
                        structureSelect.html('<option value="">Bina Seçin</option>');
                        if (response.length > 0) {
                            response.forEach(function (structure) {
                                structureSelect.append(
                                    `<option value="${structure.id}">${structure.name}</option>`
                                );
                            });
                            structureSelect.prop("disabled", false);
                        } else {
                            structureSelect.html('<option value="">Bina Bulunamadı</option>');
                        }
                    },
                    error: function () {
                        structureSelect.html('<option value="">Hata Oluştu</option>');
                    },
                });
            } else {
                structureSelect.html('<option value="">Önce Birim Seçin</option>');
            }
        });
        // Bina seçildiğinde formdaki bölge ismi ve açıklama alanları aktif hale gelir
        structureSelect.change(function () {
            let structureId = $(this).val();
            if (structureId) {
                regionNameInput.prop("disabled", false);
                descriptionInput.prop("disabled", false);
                submitButton.prop("disabled", false);
            } else {
                regionNameInput.prop("disabled", true);
                descriptionInput.prop("disabled", true);
                submitButton.prop("disabled", true);
            }
        });
    });
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>