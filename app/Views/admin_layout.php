<!DOCTYPE html>
<html lang="tr">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <?= view('components/admin/header.php') ?>


    <link rel="shortcut icon" href="<?= base_url('uploads/default/1logo.png') ?>" type="image/x-icon">
    <title>İsg Plartformu</title>
</head>

<body>
    <?= $this->renderSection('admin-content') ?>
    <?= view('components/admin/script.php') ?>
</body>

</html>