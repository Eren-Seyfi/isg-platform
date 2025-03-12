<?= $this->extend('admin_layout') ?>

<?= $this->section('admin-content') ?>

<body class="hold-transition sidebar-mini dark-mode">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?= view('admin/components/navbar') ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= view('admin/components/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content p-3">
                <?= $this->renderSection('admin-default') ?>
            </section>
            <!-- /.content -->
        </div>


        <!-- /.content-wrapper -->

        <?= view('admin/components/footer') ?>

    </div>




</body>

<?= $this->endSection() ?>