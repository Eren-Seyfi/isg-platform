<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<div class="card card-outline card-warning pt-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Şirket Yönetimi</h3>
        <button class="btn btn-outline-warning" data-toggle="modal" data-target="#addCompanyModal">
            <i class="fas fa-plus"></i> Yeni Şirket Ekle
        </button>
    </div>

    <div class="card-body">
        <!-- Flashdata Mesajları -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('message')); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Filtreleme Alanı -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="get" action="<?= base_url('admin/companies') ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search"
                            placeholder="Şirket Adı, Birim veya Alt Başlık"
                            value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-warning" type="submit">Filtrele</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Şirket Listesi -->
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Logo</th>
                    <th>ID</th>
                    <th>Şirket Adı</th>
                    <th>Birim</th>
                    <th>Alt Başlık</th>
                    <th>Açıklama</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody id="companyTable">
                <?php foreach ($companies as $company): ?>
                    <tr>
                        <td>
                            <img src="<?= base_url($company['image'] ?? 'uploads/default/1logo.png') ?>" width="50"
                                alt="Logo">
                        </td>
                        <td><?= $company['id'] ?></td>
                        <td><?= esc($company['name']) ?></td>
                        <td><?= esc($company['unit']) ?></td>
                        <td><?= esc($company['subheading']) ?></td>
                        <td><?= esc($company['description']) ?></td>
                        <td>
                            <!-- Detay Butonu: Tıklanınca ayrı sayfaya yönlendirir -->
                            <a href="<?= base_url('admin/companies/detail/' . $company['id']) ?>"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-info-circle"></i> Detay
                            </a>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editCompanyModal<?= $company['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="post" action="<?= base_url('admin/companies/delete/' . $company['id']) ?>"
                                class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bu şirketi silmek istediğinizden emin misiniz?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Şirket Düzenleme Modalı -->
                    <div class="modal fade" id="editCompanyModal<?= $company['id'] ?>" tabindex="-1"
                        aria-labelledby="editCompanyModalLabel<?= $company['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="editCompanyModalLabel<?= $company['id'] ?>">Şirketi Düzenle
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?= base_url('admin/companies/update/' . $company['id']) ?>"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="company_id" value="<?= $company['id'] ?>">

                                        <div class="form-group">
                                            <label>Şirket Adı</label>
                                            <input type="text" class="form-control" name="name" required
                                                value="<?= esc($company['name']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Birim</label>
                                            <input type="text" class="form-control" name="unit"
                                                value="<?= esc($company['unit']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Alt Başlık</label>
                                            <input type="text" class="form-control" name="subheading"
                                                value="<?= esc($company['subheading']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Açıklama</label>
                                            <textarea class="form-control"
                                                name="description"><?= esc($company['description']) ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Not</label>
                                            <textarea class="form-control"
                                                name="note"><?= esc($company['note']) ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Şirket Logosu</label>
                                            <input type="file" class="form-control" name="image">
                                            <img src="<?= base_url($company['image'] ?? 'uploads/default/1logo.png') ?>"
                                                width="100" class="mt-2" alt="Mevcut Logo">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Yeni Şirket Ekleme Modalı -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-bold" id="addCompanyModalLabel">Yeni Şirket Ekle</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('admin/companies/create') ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Şirket Adı</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Birim</label>
                        <input type="text" class="form-control" name="unit">
                    </div>

                    <div class="form-group">
                        <label>Alt Başlık</label>
                        <input type="text" class="form-control" name="subheading">
                    </div>

                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Şirket Logosu</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-outline-success">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>