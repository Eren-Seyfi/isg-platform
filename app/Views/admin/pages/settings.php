<?= $this->extend('admin/default') ?>

<!-- Kodlar bunun içine yazılacak -->
<?= $this->section('admin-default') ?>


<section class="content">
    <div class="container-fluid">
        <!-- Flashdata mesajları -->
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

        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-warning" role="alert">
                <?= session()->getFlashdata('info'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Kullanıcı Bilgileri ve E-posta Ayarları Formu -->
            <div class="col">
                <!-- Profil Bilgisi Formu -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Profil Bilgisi</h3>
                    </div>
                    <form method="post" action="<?= base_url('/admin/update/profile') ?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <!-- Kullanıcı Adı -->
                            <div class="form-group">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Kullanıcı adını girin" value="<?= esc($user['username']) ?>">
                            </div>

                            <!-- Kullanıcı Soyadı -->
                            <div class="form-group">
                                <label for="surname">Kullanıcı Soyadı</label>
                                <input type="text" class="form-control" id="surname" name="surname"
                                    placeholder="Kullanıcı soyadını girin" value="<?= esc($user['surname']) ?>">
                            </div>

                            <!-- E-posta -->
                            <div class="form-group">
                                <label for="email">E-posta Adresi</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="E-posta adresini girin" value="<?= esc($user['email']) ?>">
                            </div>

                            <!-- Şifre -->
                            <div class="form-group">
                                <label for="password">Yeni Şifre</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Yeni şifreyi girin (değiştirmek istemiyorsanız boş bırakın)">
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<?= $this->endSection() ?>