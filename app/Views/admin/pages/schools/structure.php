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

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Bina Bilgileri</h3>
    </div>


    <!-- form start -->
    <form action="<?= base_url('/admin/schools/structures') ?>" method="post">

        <div class="card-body">

            <!-- Birim Seçimi -->
            <div class="form-group">
                <label for="unit">Birim Seçimi</label>
                <select class="form-control" id="unit" name="unit_id" required>
                    <option value="">Birim Seçin</option>
                    <?php if (!empty($units)): ?>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit['id'] ?>"><?= $unit['name'] ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Birim bulunamadı</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Bina İsmi -->
            <div class="form-group">
                <label for="structure_name">Bina İsmi</label>
                <input type="text" name="name" class="form-control" id="structure_name" placeholder="Bina ismi girin"
                    required>
            </div>

            <!-- Bina Açıklaması -->
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea name="description" class="form-control" id="description"
                    placeholder="Açıklama girin"></textarea>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>
</div>

<!-- Binalar Listesi -->
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Binalar</h3>

                <div class="card-tools">
                    <form action="<?= base_url('/admin/schools/structures') ?>" method="get">
                        <div class="input-group input-group-sm" style="width: 300px;">
                            <!-- Metin Araması -->
                            <input type="text" name="search" class="form-control float-right" placeholder="Bina Ara"
                                value="<?= esc(request()->getGet('search')) ?>">

                            <!-- Birim Seçimi -->
                            <select name="unit_filter" class="form-control">
                                <option value="">Tüm Birimler</option>
                                <?php if (!empty($units)): ?>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?= $unit['id'] ?>" <?= (request()->getGet('unit_filter') == $unit['id']) ? 'selected' : '' ?>>
                                            <?= $unit['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Birim</th>
                            <th>Bina İsmi</th>
                            <th>Açıklama</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($structures as $structure): ?>
                            <tr>
                                <td><?= $structure['id'] ?></td>
                                <td><?= $structure['unit_name'] ?></td> <!-- Birim adı artık mevcut -->
                                <td><?= $structure['name'] ?></td>
                                <td><?= $structure['description'] ?></td>
                                <td><?= $structure['created_at'] ?></td>
                                <td>
                                    <!-- Düzenle Butonu (Modal açacak) -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editBuildingModal-<?= $structure['id'] ?>">
                                        <i class="fas fa-edit"></i> Düzenle
                                    </button>


                                    <!-- Silme Butonu -->
                                    <form action="<?= base_url('/admin/schools/structures/delete/' . $structure['id']) ?>"
                                        method="post"
                                        onsubmit="return confirm('Bu binayı silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <?= csrf_field(); ?> <!-- CSRF korumasını ekliyoruz -->
                                        <button type="submit" class="btn btn-danger">Sil</button>
                                    </form>


                                </td>
                            </tr>

                            <!-- Modal için Component'i çağırıyoruz -->
                            <!-- Bina Düzenleme Modalı -->
                            <div class="modal fade" id="editBuildingModal-<?= $structure['id'] ?>" tabindex="-1"
                                aria-labelledby="editBuildingModalLabel-<?= $structure['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editBuildingModalLabel-<?= $structure['id'] ?>">Bina
                                                Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- Bina Düzenleme Formu -->
                                        <form action="<?= base_url('/admin/schools/structures/' . $structure['id']) ?>"
                                            method="post">
                                            <input type="hidden" name="_method" value="PUT">
                                            <!-- Güncelleme isteği olduğunu belirtir -->
                                            <div class="modal-body">

                                                <!-- Birim Seçimi -->
                                                <div class="form-group">
                                                    <label for="unit">Birim Seçimi</label>
                                                    <select class="form-control" id="unit" name="unit_id" required>
                                                        <option value="">Birim Seçin</option>
                                                        <?php if (!empty($units)): ?>
                                                            <?php foreach ($units as $unit): ?>
                                                                <option value="<?= $unit['id'] ?>" <?= isset($structure['unit_id']) && $structure['unit_id'] == $unit['id'] ? 'selected' : '' ?>>
                                                                    <?= $unit['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="">Birim bulunamadı</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>



                                                <div class="form-group">
                                                    <label for="name">Bina İsmi</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        value="<?= $structure['name'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Açıklama</label>
                                                    <textarea name="description" class="form-control" id="description"
                                                        required><?= $structure['description'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-primary">Güncelle</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<?= $this->endSection() ?>