<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($base . 'auth/login.php');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    setAlert('danger', 'Username dan password wajib diisi.');
    redirect($base . 'auth/login.php');
}

$stmt = mysqli_prepare($koneksi, "SELECT id, nama, password, role FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$user  = mysqli_fetch_assoc($hasil);

if (!$user || !password_verify($password, $user['password'])) {
    setAlert('danger', 'Username atau password salah.');
    redirect($base . 'auth/login.php');
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['nama']    = $user['nama'];
$_SESSION['role']    = $user['role'];

setAlert('success', 'Selamat datang, ' . $user['nama'] . '!');
redirect($base . ($user['role'] === 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
