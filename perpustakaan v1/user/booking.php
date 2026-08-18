<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'siswa';
require $base . 'includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'index.php');
}

$userId = (int)$_SESSION['user_id'];
$bookId = (int)($_POST['book_id'] ?? 0);

// 1. Cek jumlah buku aktif siswa (booking + borrowed) harus < 2
$stmt = mysqli_prepare($koneksi,
    "SELECT COUNT(*) AS jumlah FROM borrowings WHERE user_id = ? AND status IN ('booking', 'borrowed')");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$jumlahAktif = mysqli_stmt_get_result($stmt)->fetch_assoc()['jumlah'];

if ($jumlahAktif >= 2) {
    setAlert('warning', 'Anda sudah mencapai batas maksimal 2 buku.');
    redirect($base . 'detail.php?id=' . $bookId);
}

// 2. Cek buku masih tersedia
$stmt = mysqli_prepare($koneksi, "SELECT status FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$buku = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$buku) {
    setAlert('danger', 'Buku tidak ditemukan.');
    redirect($base . 'index.php');
}

if ($buku['status'] !== 'available') {
    setAlert('warning', 'Buku sedang tidak tersedia.');
    redirect($base . 'detail.php?id=' . $bookId);
}

// 3. Simpan booking & ubah status buku jadi 'booked'
mysqli_begin_transaction($koneksi);
try {
    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO borrowings (user_id, book_id, booking_date, status) VALUES (?, ?, NOW(), 'booking')");
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $bookId);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi, "UPDATE books SET status = 'booked' WHERE id = ? AND status = 'available'");
    mysqli_stmt_bind_param($stmt, 'i', $bookId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 0) {
        throw new Exception('Buku sudah dibooking orang lain.');
    }

    mysqli_commit($koneksi);
    setAlert('success', '✅ Buku berhasil dibooking. Silakan ambil di perpustakaan.');
    redirect($base . 'user/dashboard.php');
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    setAlert('danger', 'Booking gagal, buku mungkin baru saja dibooking siswa lain.');
    redirect($base . 'detail.php?id=' . $bookId);
}
