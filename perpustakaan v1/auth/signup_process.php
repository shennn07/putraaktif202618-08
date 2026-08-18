<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'auth/signup.php');
}

$nama          = trim($_POST['nama'] ?? '');
$nis           = trim($_POST['nis'] ?? '');
$kartu_pelajar = trim($_POST['kartu_pelajar'] ?? '');
$username      = trim($_POST['username'] ?? '');
$password      = $_POST['password'] ?? '';

if ($nama === '' || $nis === '' || $kartu_pelajar === '' || $username === '' || $password === '') {
    setAlert('danger', 'Semua data wajib diisi.');
    redirect($base . 'auth/signup.php');
}

if (strlen($password) < 6) {
    setAlert('danger', 'Password minimal 6 karakter.');
    redirect($base . 'auth/signup.php');
}

// Cek username sudah dipakai atau belum
$cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($cek, 's', $username);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
    setAlert('danger', 'Username sudah digunakan, silakan pilih username lain.');
    redirect($base . 'auth/signup.php');
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO users (nama, nis, kartu_pelajar, username, password, role) VALUES (?, ?, ?, ?, ?, 'siswa')");
mysqli_stmt_bind_param($stmt, 'sssss', $nama, $nis, $kartu_pelajar, $username, $passwordHash);

if (mysqli_stmt_execute($stmt)) {
    setAlert('success', 'Pendaftaran berhasil! Silakan login.');
    redirect($base . 'auth/login.php');
} else {
    setAlert('danger', 'Pendaftaran gagal, silakan coba lagi.');
    redirect($base . 'auth/signup.php');
}
