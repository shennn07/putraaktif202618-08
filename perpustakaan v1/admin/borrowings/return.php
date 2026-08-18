<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

const DENDA_PER_HARI = 2000;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'admin/borrowings/index.php');
}

$id = (int)($_POST['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM borrowings WHERE id = ? AND status = 'borrowed'");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$transaksi = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$transaksi) {
    setAlert('danger', 'Data peminjaman tidak ditemukan atau sudah dikembalikan.');
    redirect($base . 'admin/borrowings/index.php?tab=borrowed');
}

$tanggalKembali = date('Y-m-d');
$telat = (int)floor((strtotime($tanggalKembali) - strtotime($transaksi['due_date'])) / 86400);
$telat = max($telat, 0);
$denda = $telat * DENDA_PER_HARI;

mysqli_begin_transaction($koneksi);
try {
    $stmt = mysqli_prepare($koneksi,
        "UPDATE borrowings SET status='returned', return_date=?, late_days=?, fine=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'siii', $tanggalKembali, $telat, $denda, $id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi, "UPDATE books SET status='available' WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $transaksi['book_id']);
    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);

    if ($telat > 0) {
        setAlert('warning', "⚠️ Buku terlambat dikembalikan selama {$telat} hari. Denda: " . formatRupiah($denda) . '.');
    } else {
        setAlert('success', 'Pengembalian berhasil dikonfirmasi. Tidak ada denda.');
    }
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    setAlert('danger', 'Gagal mengkonfirmasi pengembalian.');
}

redirect($base . 'admin/borrowings/index.php?tab=borrowed');
