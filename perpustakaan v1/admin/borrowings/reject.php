<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'admin/borrowings/index.php');
}

$id = (int)($_POST['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM borrowings WHERE id = ? AND status = 'booking'");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$transaksi = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$transaksi) {
    setAlert('danger', 'Data booking tidak ditemukan atau sudah diproses.');
    redirect($base . 'admin/borrowings/index.php?tab=booking');
}

mysqli_begin_transaction($koneksi);
try {
    $stmt = mysqli_prepare($koneksi, "UPDATE borrowings SET status='rejected' WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi, "UPDATE books SET status='available' WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $transaksi['book_id']);
    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);
    setAlert('success', 'Booking berhasil ditolak. Buku kembali tersedia.');
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    setAlert('danger', 'Gagal menolak booking.');
}

redirect($base . 'admin/borrowings/index.php?tab=booking');
