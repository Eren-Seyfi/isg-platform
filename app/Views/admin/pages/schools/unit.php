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
        <h3 class="card-title">Birim Bilgileri</h3>
    </div>

    <!-- form start -->
    <form action="<?= base_url('/admin/schools/units/create') ?>" method="post">

        <div class="card-body">
            <!-- Kullanıcının Şirket Bilgisi (Gizli Input) -->
            <input type="hidden" name="company_id" value="<?= $user['company_id'] ?>">

            <!-- Birim İsmi -->
            <div class="form-group">
                <label for="unit_name">Birim İsmi</label>
                <input type="text" name="name" class="form-control" id="unit_name" placeholder="Birim ismi girin"
                    required>
            </div>

            <!-- Birim İletişim Telefon Numarası -->
            <div class="form-group">
                <label for="phone">Telefon Numarası</label>
                <input type="tel" name="phone" class="form-control" id="phone" placeholder="Telefon numarası girin"
                    required>
            </div>

            <!-- Birim Açıklaması -->
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

<!-- Birimler Listesi -->
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Birimler</h3>

                <div class="card-tools">
                    <form action="<?= base_url('/admin/schools/units') ?>" method="get">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="Birim Ara"
                                value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Birim İsmi</th>
                            <th>İletişim</th>
                            <th>Açıklama</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($units as $unit): ?>
                            <tr>
                                <td><?= $unit['id'] ?></td>
                                <td><?= $unit['name'] ?></td>
                                <td><?= $unit['phone'] ?></td>
                                <td><?= $unit['description'] ?></td>
                                <td><?= $unit['created_at'] ?></td>
                                <td>
                                    <!-- Düzenle Butonu (Modal açacak) -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editUnitModal-<?= $unit['id'] ?>">
                                        <i class="fas fa-edit"></i> Düzenle
                                    </button>



                                    <!-- Silme Butonu -->
                                    <form action="<?= base_url('/admin/schools/units/delete/' . $unit['id']) ?>"
                                        method="post"
                                        onsubmit="return confirm('Bu birimi silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Sil</button>
                                    </form>

                                </td>
                            </tr>

                            <!-- Modal için Component'i çağırıyoruz -->
                            <!-- Birim Düzenleme Modalı -->
                            <div class="modal fade" id="editUnitModal-<?= $unit['id'] ?>" tabindex="-1"
                                aria-labelledby="editUnitModalLabel-<?= $unit['id'] ?>" aria-hidden="true">

                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUnitModalLabel-<?= $unit['id'] ?>">Birim Düzenle
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- Birim Düzenleme Formu -->
                                        <form action="<?= base_url('/admin/schools/units/update/' . $unit['id']) ?>"
                                            method="post">
                                            <input type="hidden" name="_method" value="POST">
                                            <!-- Güncelleme işlemi için POST kullanılıyor -->
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="unit_name_<?= $unit['id'] ?>">Birim İsmi</label>
                                                    <input type="text" name="name" class="form-control"
                                                        id="unit_name_<?= $unit['id'] ?>" value="<?= esc($unit['name']) ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_<?= $unit['id'] ?>">Telefon Numarası</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        id="phone_<?= $unit['id'] ?>" value="<?= esc($unit['phone']) ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description_<?= $unit['id'] ?>">Açıklama</label>
                                                    <textarea name="description" class="form-control"
                                                        id="description_<?= $unit['id'] ?>"
                                                        required><?= esc($unit['description']) ?></textarea>
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