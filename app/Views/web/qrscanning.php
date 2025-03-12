<!-- qrscanning.php (View Dosyası) -->
<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Kodu Tarama Formu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>QR Kodu Tarama - Bildirim Formu</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('qrcode/create') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="company_id" value="<?= isset($company) ? esc($company['id']) : '' ?>">
                    <input type="hidden" name="unit_id" value="<?= isset($unit) ? esc($unit['id']) : '' ?>">
                    <input type="hidden" name="structure_id"
                        value="<?= isset($building) ? esc($building['id']) : '' ?>">
                    <input type="hidden" name="regions_id"
                        value="<?= isset($department) ? esc($department['id']) : '' ?>">

                    <div class="mb-3">
                        <label class="form-label">Şirket İsmi</label>
                        <input type="text" class="form-control"
                            value="<?= isset($company) ? esc($company['name']) : 'Şirket Bilgisi Yok' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Birim İsmi</label>
                        <input type="text" class="form-control" value="<?= isset($unit) ? esc($unit['name']) : '' ?>"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bina İsmi</label>
                        <input type="text" class="form-control"
                            value="<?= isset($building) ? esc($building['name']) : '' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bölge İsmi</label>
                        <input type="text" class="form-control"
                            value="<?= isset($department) ? esc($department['name']) : '' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fotoğraf Ekle</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Gönder</button>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>