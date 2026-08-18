<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['user_id'])) {
    redirect($base . ($_SESSION['role'] === 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
}

$judul_halaman = 'Daftar Akun';
require $base . 'includes/header.php';
?>

<div class="form-box">
    <h2>Daftar Akun Siswa</h2>
    <form action="signup_process.php" method="post">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required autofocus>
        </div>
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" id="nis" name="nis" required>
        </div>
        <div class="form-group">
            <label for="kartu_pelajar">Nomor Kartu Pelajar</label>
            <input type="text" id="kartu_pelajar" name="kartu_pelajar" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required minlength="6">
            <p class="form-hint">Minimal 6 karakter.</p>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
    </form>
    <p class="form-foot">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

<?php require $base . 'includes/footer.php'; ?>
