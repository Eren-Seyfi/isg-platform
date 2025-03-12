<!-- jQuery (Required for Bootstrap and various plugins) -->
<script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js') ?>"></script>


<!-- Bootstrap 4 JS (DataTables Bootstrap4 uyumu için) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>


<!-- Bootstrap 4 JavaScript Bundle -->
<script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- AdminLTE App (Main Application JS) -->
<script src="<?= base_url('assets/admin/dist/js/adminlte.min.js') ?>"></script>

<!-- jsPDF ve QRCode kütüphanelerini dahil et -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


<!-- bs-custom-file-input (For custom file input fields) -->
<script src="<?= base_url('assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<!-- Dropzone.js (File Uploading Plugin) -->
<script src="<?= base_url('assets/admin/plugins/dropzone/min/dropzone.min.js') ?>"></script>

<!-- Select2 (Enhanced Dropdown Selects) -->
<script src="<?= base_url('assets/admin/plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Bootstrap4 Duallistbox (Multi-select with Dual List) -->
<script
    src="<?= base_url('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') ?>"></script>

<!-- InputMask (Form Input Masks) -->
<script src="<?= base_url('assets/admin/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/plugins/inputmask/jquery.inputmask.min.js') ?>"></script>

<!-- Date Range Picker (Date Range Selection) -->
<script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js') ?>"></script>

<!-- Bootstrap Color Picker (Color Selection) -->
<script src="<?= base_url('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>

<!-- Tempusdominus Bootstrap 4 (Date and Time Picker) -->
<script
    src="<?= base_url('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>

<!-- Bootstrap Switch (Toggle Switches) -->
<script src="<?= base_url('assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>

<!-- BS-Stepper (Stepper for Multi-step Forms) -->
<script src="<?= base_url('assets/admin/plugins/bs-stepper/js/bs-stepper.min.js') ?>"></script>

<!-- GLightbox (Lightbox for Images/Videos) -->
<script src="<?= base_url('assets/admin/plugins/glightbox/js/glightbox.min.js') ?>"></script>


<!-- Initialize bs-custom-file-input (Custom file input styling) -->
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<!-- Initialize Bootstrap Tooltips -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- Initialize GLightbox (Lightbox for displaying images and videos) -->
<script>
    const lightbox = GLightbox({
        selector: 'a[data-glightbox]',
        touchNavigation: true, // Mobilde dokunmatik navigasyonu aktif et
        loop: true,            // Resimler arasında geçiş döngüsü sağla
        zoomable: true,        // Mobilde resimleri büyütüp küçültme desteği
        autoplayVideos: true   // Videolar otomatik oynatılır
    });
</script>




<?= $this->renderSection('javascript') ?>