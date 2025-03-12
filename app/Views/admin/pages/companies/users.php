<?= $this->extend('admin/default') ?>

<?= $this->section('admin-default') ?>

<div class="card card-outline card-cyan pt-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Kullanıcı Yönetimi</h3>
        <button class="btn btn-outline-info" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-user-plus"></i> Yeni Kullanıcı Ekle
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
                <form method="get" action="<?= base_url('admin/companies/users') ?>">
                    <div class="input-group">
                        <!-- Şirket Filtreleme -->
                        <select class="form-control" name="company_id">
                            <option value="">Tüm Şirketler</option>
                            <?php foreach ($companies as $company): ?>
                                <option value="<?= $company['id'] ?>" <?= (isset($_GET['company_id']) && $_GET['company_id'] == $company['id']) ? 'selected' : '' ?>>
                                    <?= esc($company['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Arama: Kullanıcı Adı, Soyadı veya E-Posta -->
                        <input type="text" class="form-control" name="search" placeholder="Ad, Soyad veya E-Posta"
                            value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info" type="submit">Filtrele</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Kullanıcı Listesi -->
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Soyadı</th>
                    <th>E-Posta</th>
                    <th>Şirket</th>
                    <th>Oluşturulma Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['surname']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['company_name'] ?? 'Şirket Yok') ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editUserModal<?= $user['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="post" action="<?= base_url('admin/companies/users/delete/' . $user['id']) ?>"
                                class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Kullanıcı Düzenleme Modalı -->
                    <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1"
                        aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="editUserModalLabel<?= $user['id'] ?>">Kullanıcıyı Düzenle
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post"
                                        action="<?= base_url('admin/companies/users/update/' . $user['id']) ?>">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

                                        <div class="form-group">
                                            <label>Kullanıcı Adı</label>
                                            <input type="text" class="form-control" name="username" required
                                                value="<?= esc($user['username']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Soyadı</label>
                                            <input type="text" class="form-control" name="surname" required
                                                value="<?= esc($user['surname']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>E-Posta</label>
                                            <input type="email" class="form-control" name="email" required
                                                value="<?= esc($user['email']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Yeni Şifre</label>
                                            <input type="password" class="form-control" name="password">
                                            <small class="form-text text-muted">Şifreyi değiştirmek istemiyorsanız boş
                                                bırakın.</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Şirket</label>
                                            <select class="form-control" name="company_id">
                                                <option value="">Şirket Seç</option>
                                                <?php foreach ($companies as $company): ?>
                                                    <option value="<?= $company['id'] ?>"
                                                        <?= ($user['company_id'] == $company['id']) ? 'selected' : '' ?>>
                                                        <?= esc($company['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Güncelle</button>
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

<!-- Yeni Kullanıcı Ekleme Modalı -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-cyan text-white">
                <h5 class="modal-title" id="addUserModalLabel">Yeni Kullanıcı Ekle</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('admin/companies/users/create') ?>">
                    <div class="form-group">
                        <label>Şirket Seç</label>
                        <select class="form-control" name="company_id" required>
                            <option value="">Şirket Seç</option>
                            <?php foreach ($companies as $company): ?>
                                <option value="<?= $company['id'] ?>"><?= esc($company['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kullanıcı Adı</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Soyadı</label>
                        <input type="text" class="form-control" name="surname" required>
                    </div>

                    <div class="form-group">
                        <label>E-Posta</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Şifre</label>
                        <input type="password" class="form-control" name="password" required>
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