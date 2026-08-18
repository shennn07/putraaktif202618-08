<?php
// =============================================================
// Konfigurasi koneksi database
// Sesuaikan DB_HOST, DB_USER, DB_PASS jika perlu (default XAMPP)
// =============================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'perpustakaan');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error() .
        '<br>Pastikan MySQL sudah dijalankan di XAMPP dan database "perpustakaan" sudah diimport.');
}

mysqli_set_charset($koneksi, 'utf8mb4');
