<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Excel İşlemleri</h3>
    </div>

    <div class="card-body">
        <!-- Örnek Excel İndir -->
        <button class="btn btn-primary mb-3" onclick="downloadSampleExcel()">Örnek Excel İndir</button>

        <!-- Excel Yükleme Formu -->
        <form id="excelUploadForm" enctype="multipart/form-data">
            <input type="file" id="excelFile" class="form-control mb-3" accept=".xls,.xlsx">
            <div class="d-flex">
                <button type="button" class="btn btn-outline-success me-2" onclick="loadExcel()">Kontırol Et</button>
                <button type="button" class="btn btn-danger" id="saveExcelBtn" onclick="saveExcel()"
                    disabled>Kaydet</button>
            </div>
        </form>

        <div id="errorMessage" class="alert alert-danger mt-3 d-none"></div>

        <h5 class="mt-3">Yüklenen Excel İçeriği:</h5>
        <table class="table table-bordered" id="excelTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Birimler</th>
                    <th>Binalar</th>
                    <th>Bölgeler</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

</div>

<?= $this->section('javascript') ?>

<!-- SheetJS (Excel Okuma) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Doğru sütun yapısı
    const expectedColumns = ['Birimler', 'Binalar', 'Bölgeler'];

    function downloadSampleExcel() {
        const data = [
            expectedColumns,
            ["Birim 1", 'Birim 1 in Binası 1', '1.Birimin 1.Binasının 1.Bölgesi'],
            ["Birim 2", 'Birim 2 in Binası 2', '2.Birimin 2.Binasının 2.Bölgesi']
        ];

        const ws = XLSX.utils.aoa_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Veriler");

        XLSX.writeFile(wb, "ornek.xlsx");
    }

    function loadExcel() {
        const fileInput = document.getElementById('excelFile');
        const errorMessage = document.getElementById("errorMessage");
        errorMessage.classList.add("d-none"); // Hata mesajını gizle

        if (fileInput.files.length === 0) {
            alert("Lütfen bir Excel dosyası seçin.");
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function (event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            if (!validateExcelStructure(jsonData)) {
                errorMessage.textContent = "⚠️ Hatalı Excel formatı! Lütfen örnek dosyadaki sütun yapısını kullanın.";
                errorMessage.classList.remove("d-none");
                document.getElementById("saveExcelBtn").disabled = true;
                return;
            }

            displayExcelData(jsonData);
        };

        reader.readAsArrayBuffer(file);
    }

    function validateExcelStructure(data) {
        if (data.length === 0) return false;

        // İlk satır (header) kontrolü
        const uploadedColumns = data[0].map(col => col.trim());
        return JSON.stringify(uploadedColumns) === JSON.stringify(expectedColumns);
    }

    function displayExcelData(data) {
        const tableBody = document.querySelector("#excelTable tbody");
        tableBody.innerHTML = "";

        data.slice(1).forEach((row, index) => {
            if (row.length >= 3) {
                const tr = document.createElement("tr");
                tr.innerHTML = `<td>${index + 1}</td><td>${row[0]}</td><td>${row[1]}</td><td>${row[2]}</td>`;
                tableBody.appendChild(tr);
            }
        });

        // Excel formatı uygunsa Kaydet butonunu aktif et
        document.getElementById("saveExcelBtn").disabled = false;
    }

    function saveExcel() {
        const fileInput = document.getElementById('excelFile');
        if (fileInput.files.length === 0) {
            alert("⚠️ Kaydedilecek Excel dosyası bulunamadı!");
            return;
        }

        const formData = new FormData();
        formData.append("excelFile", fileInput.files[0]);

        fetch("excel/save", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(`✅ Başarı: ${data.message}`);
                } else {
                    alert("⚠️ Beklenmeyen bir hata oluştu!");
                }
                console.log(data);
            })
            .catch(error => {
                alert(`❌ Hata: ${error.message}`);
                console.error('Hata:', error);
            });
    }

</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>