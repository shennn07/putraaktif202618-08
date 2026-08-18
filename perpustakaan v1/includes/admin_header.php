<?php
// Variabel yang perlu didefinisikan sebelum include file ini:
// $base           -> path relatif ke root, contoh: '../', '../../'
// $judul_halaman  -> judul tab browser & topbar
// $halaman_aktif  -> 'dashboard' | 'books' | 'borrowings' (untuk highlight menu)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base          = $base ?? '';
$judul_halaman = $judul_halaman ?? 'Admin';
$halaman_aktif = $halaman_aktif ?? '';

function kelasAktif($halaman_aktif, $target) {
    return $halaman_aktif === $target ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($judul_halaman) ?> - Admin Perpustakaan</title>
<link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="<?= $base ?>admin/dashboard.php" class="brand">📚 Panel Admin</a>
        <ul class="admin-nav">
            <li><a href="<?= $base ?>admin/dashboard.php" class="<?= kelasAktif($halaman_aktif, 'dashboard') ?>">Dashboard</a></li>
            <li><a href="<?= $base ?>admin/books/index.php" class="<?= kelasAktif($halaman_aktif, 'books') ?>">Data Buku</a></li>
            <li><a href="<?= $base ?>admin/borrowings/index.php" class="<?= kelasAktif($halaman_aktif, 'borrowings') ?>">Peminjaman</a></li>
            <li class="section-label">Lainnya</li>
            <li><a href="<?= $base ?>index.php">Lihat Situs Utama</a></li>
        </ul>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <h1><?= e($judul_halaman) ?></h1>
            <div style="display:flex; align-items:center; gap:14px;">
                <span class="muted" style="font-size:0.88rem;">👤 <?= e($_SESSION['nama'] ?? '') ?></span>
                <a href="<?= $base ?>auth/logout.php" class="btn btn-outline btn-sm">Logout</a>
            </div>
        </div>
        <div class="admin-content">
        <?php tampilkanAlert(); ?>
