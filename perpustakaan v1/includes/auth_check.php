<?php
// =============================================================
// Cek sesi login. Include file ini di baris paling atas halaman
// yang butuh proteksi, SEBELUM ada output HTML apapun.
//
// Sebelum include file ini, halaman WAJIB mendefinisikan:
//   $base            = path relatif ke folder root (contoh: '', '../', '../../')
//   $halaman_untuk   = 'admin' atau 'siswa'
// =============================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base          = $base ?? '';
$halaman_untuk = $halaman_untuk ?? null;

if (empty($_SESSION['user_id'])) {
    setAlert('warning', 'Silakan login terlebih dahulu.');
    redirect($base . 'auth/login.php');
}

if ($halaman_untuk && $_SESSION['role'] !== $halaman_untuk) {
    setAlert('warning', 'Anda tidak memiliki akses ke halaman tersebut.');
    redirect($base . 'index.php');
}
