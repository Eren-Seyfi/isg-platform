<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>


<!-- Flash Mesajlar -->
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
<!-- Risk Ayarları Sayfası Başlangıcı -->
<div class="row">
    <!-- Risk Olasılığı Kartı -->
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Risk Olasılığı</h3>
            </div>
            <!-- form start -->
            <form action="<?= base_url('admin/risk/frequencies') ?>" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label for="frequency_name">Risk Olasılığı Adı</label>
                        <input type="text" name="name" class="form-control" id="frequency_name"
                            placeholder="Risk Olasılığı Adı" required>
                    </div>
                    <div class="form-group">
                        <label for="frequency_level">Risk Olasılığı Seviyesi</label>
                        <input type="number" name="level" class="form-control" id="frequency_level"
                            placeholder="Risk Olasılığı Seviyesi" required>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </div>
            </form>
        </div>
        <!-- /.card -->

        <!-- Risk Olasılığı Listesi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Risk Olasılığı Listesi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Seviyesi</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($frequencies as $frequency): ?>
                            <tr>
                                <td><?= $frequency['name'] ?></td>
                                <td><?= $frequency['level'] ?></td>
                                <td><?= $frequency['created_at'] ?></td>

                                <td>
                                    <!-- Güncelleme için modal tetikleyici -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#updateFrequencyModal<?= $frequency['id'] ?>"
                                        onclick="editFrequency(<?= $frequency['id'] ?>, '<?= $frequency['name'] ?>', <?= $frequency['level'] ?>)">Güncelle</button>

                                    <!-- Silme işlemi için form -->
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('delete-frequency-<?= $frequency['id'] ?>').submit();"
                                        class="btn btn-danger btn-sm">Sil</a>
                                    <form id="delete-frequency-<?= $frequency['id'] ?>"
                                        action="<?= base_url('admin/risk/frequencies/' . $frequency['id']) ?>" method="post"
                                        style="display: none;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <?= csrf_field() ?>
                                    </form>
                                </td>
                            </tr>

                            <!-- Risk Olasılığı Güncelleme Modali -->
                            <?= view('admin/components/risk_frequencies_modal', ['frequency' => $frequency]) ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Risk Şiddeti Kartı -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Risk Şiddeti</h3>
            </div>
            <!-- form start -->
            <form action="<?= base_url('admin/risk/sizes') ?>" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label for="size_name">Risk Şiddeti Adı</label>
                        <input type="text" name="name" class="form-control" id="size_name"
                            placeholder="Risk Şiddeti Adı" required>
                    </div>
                    <div class="form-group">
                        <label for="size_level">Risk Şiddeti Seviyesi</label>
                        <input type="number" name="level" class="form-control" id="size_level"
                            placeholder="Risk Şiddeti Seviyesi" required>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Ekle</button>
                </div>
            </form>
        </div>
        <!-- /.card -->

        <!-- Risk Şiddeti Listesi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Risk Şiddeti Listesi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Seviyesi</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sizes as $size): ?>
                            <tr>
                                <td><?= $size['name'] ?? 'Bilinmiyor'; ?></td>
                                <td><?= $size['level'] ?? 'Bilinmiyor'; ?></td>
                                <td><?= $size['created_at'] ?? 'Bilinmiyor'; ?></td>
                                <td>
                                    <!-- Güncelleme için modal tetikleyici -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#updateSizeModal<?= $size['id'] ?>"
                                        onclick="editSize(<?= $size['id'] ?>, '<?= $size['name'] ?>', <?= $size['level'] ?>)">Güncelle</button>

                                    <!-- Silme işlemi için form -->
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('delete-size-<?= $size['id'] ?>').submit();"
                                        class="btn btn-danger btn-sm">Sil</a>
                                    <form id="delete-size-<?= $size['id'] ?>"
                                        action="<?= base_url('admin/risk/sizes/' . $size['id']) ?>" method="post"
                                        style="display: none;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <?= csrf_field() ?>
                                    </form>
                                </td>
                            </tr>

                            <!-- Risk Şiddeti Güncelleme Modali -->
                            <?= view('admin/components/risk_size_modal', ['size' => $size]) ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->
<?= $this->endSection() ?>