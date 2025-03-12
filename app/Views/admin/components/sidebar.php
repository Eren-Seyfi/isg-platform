<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('/') ?>" class="brand-link">
    <img src="<?= base_url('/assets/admin/dist/img/sidebar-logo.png') ?>" alt="ISG Logo" class="brand-image"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Platform</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('uploads/default/profile.png') ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url(session()->get('role') == 'user' ? 'admin/notifications' : 'admin/companies'); ?>"
          class="d-block"><?= user('username') ?? 'isim yok' ?>
          <?= user('surname') ?? 'soyisim yok' ?></a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <?php if (user('role') === 'user'): ?>
          <!-- Bildirimler -->
          <li class="nav-item">
            <a href="<?= base_url('admin/notifications') ?>" class="nav-link">
              <i class="nav-icon fas fa-bell"></i>
              <p>
                Bildirimler
              </p>
            </a>
          </li>

          <!-- Organizasyon Ayarları -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Organizasyon Ayarları
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/schools/units') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Birimler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/schools/structures') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Binalar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/schools/regions') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bölgeler</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Risk Ayarları -->
          <li class="nav-item">
            <a href="<?= base_url('admin/risk') ?>" class="nav-link">
              <i class="nav-icon fas fa-exclamation-triangle"></i>
              <p>
                Risk Ayarları
              </p>
            </a>
          </li>

          <!-- Risk Ayarları -->
          <li class="nav-item">
            <a href="<?= base_url('admin/excel') ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Excel Ayarları
              </p>
            </a>
          </li>

        <?php else: ?>
          <!-- Şirket Yönetimi -->
          <li class="nav-item">
            <a href="<?= base_url('admin/companies') ?>" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Şirketler
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/companies/users') ?>" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Şirket Kullanıcıları
              </p>
            </a>
          </li>
        <?php endif; ?>

        <!-- Profil Ayarları (Tüm Roller İçin) -->
        <li class="nav-item">
          <a href="<?= base_url('admin/settings') ?>" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>
              Profil Ayarları
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>