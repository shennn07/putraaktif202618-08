<?php
// Variabel yang perlu didefinisikan sebelum include file ini:
// $base       -> path relatif ke root, contoh: '', '../', '../../'
// $judul_halaman -> judul tab browser (opsional)
$base = $base ?? '';
$judul_halaman = $judul_halaman ?? 'Perpustakaan Sekolah';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($judul_halaman) ?> - Perpustakaan Sekolah</title>
<link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/navbar.php'; ?>
<main class="container">
<?php tampilkanAlert(); ?>
