<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// Cek apakah pengguna adalah admin
function check_admin() {
    check_login();
    if ($_SESSION['role'] !== 'admin') {
        echo "Akses ditolak. Halaman ini khusus Admin!";
        exit();
    }
}
?>