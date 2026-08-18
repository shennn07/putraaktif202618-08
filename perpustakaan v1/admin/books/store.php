<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'admin/books/index.php');
}

$kode_buku = trim($_POST['kode_buku'] ?? '');
$judul     = trim($_POST['judul'] ?? '');
$penulis   = trim($_POST['penulis'] ?? '');
$penerbit  = trim($_POST['penerbit'] ?? '');
$tahun     = $_POST['tahun'] !== '' ? (int)$_POST['tahun'] : null;
$kategori  = trim($_POST['kategori'] ?? '');

if ($kode_buku === '' || $judul === '' || $penulis === '') {
    setAlert('danger', 'Kode buku, judul, dan penulis wajib diisi.');
    redirect($base . 'admin/books/create.php');
}

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO books (kode_buku, judul, penulis, penerbit, tahun, kategori, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
mysqli_stmt_bind_param($stmt, 'ssssis', $kode_buku, $judul, $penulis, $penerbit, $tahun, $kategori);

if (mysqli_stmt_execute($stmt)) {
    setAlert('success', 'Buku berhasil ditambahkan.');
} else {
    setAlert('danger', 'Gagal menambahkan buku. Pastikan kode buku belum digunakan.');
}
redirect($base . 'admin/books/index.php');
