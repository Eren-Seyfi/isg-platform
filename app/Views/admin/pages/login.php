<!-- Hangi Layout olduğunu seçiyoruz -->
<?= $this->extend('admin_layout') ?>

<!-- Layout içindeki hangi kısımda yer alacağını belirliyoruz -->
<?= $this->section('admin-content') ?>

<body class="hold-transition login-page ">
    <div class="login-box">

        <div class="card card-outline card-primary bg-secondary">

            <div class="card-header text-center">
                <div class="d-flex justify-content-center">
                    <img class="login-logo" src="<?= base_url('uploads/default/logo.png') ?>" alt="Site Logosu">
                </div>

                <div>
                    <a href="<?= base_url('/') ?>" class="h1"><b>İSG Platformu</b></a>
                </div>
            </div>


            <div class="card-body">

                <form action="<?= base_url('/login') ?>" method="post">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="email" value="<?= set_value('email') ?>" name="email" class="form-control"
                                placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($errors_login['email'])): ?>
                            <div class="text-danger">
                                <?= esc($errors_login['email']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" value="<?= set_value('password') ?>" name="password"
                                class="form-control" placeholder="Şifre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($errors_login['password'])): ?>
                            <div class="text-danger">
                                <?= esc($errors_login['password']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($checklogin)): ?>
                        <div class="alert alert-danger" role="alert">
                            <h4><?= esc($checklogin) ?></h4>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</body>

<?= $this->endSection() ?>