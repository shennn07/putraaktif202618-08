<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'admin/books/index.php');
}

$id        = (int)($_POST['id'] ?? 0);
$kode_buku = trim($_POST['kode_buku'] ?? '');
$judul     = trim($_POST['judul'] ?? '');
$penulis   = trim($_POST['penulis'] ?? '');
$penerbit  = trim($_POST['penerbit'] ?? '');
$tahun     = $_POST['tahun'] !== '' ? (int)$_POST['tahun'] : null;
$kategori  = trim($_POST['kategori'] ?? '');
$status    = $_POST['status'] ?? 'available';

if (!in_array($status, ['available', 'booked', 'borrowed'], true)) {
    $status = 'available';
}

if ($kode_buku === '' || $judul === '' || $penulis === '') {
    setAlert('danger', 'Kode buku, judul, dan penulis wajib diisi.');
    redirect($base . 'admin/books/edit.php?id=' . $id);
}

$stmt = mysqli_prepare($koneksi,
    "UPDATE books SET kode_buku=?, judul=?, penulis=?, penerbit=?, tahun=?, kategori=?, status=? WHERE id=?");
mysqli_stmt_bind_param($stmt, 'ssssissi', $kode_buku, $judul, $penulis, $penerbit, $tahun, $kategori, $status, $id);

if (mysqli_stmt_execute($stmt)) {
    setAlert('success', 'Data buku berhasil diperbarui.');
} else {
    setAlert('danger', 'Gagal memperbarui data buku.');
}
redirect($base . 'admin/books/index.php');
