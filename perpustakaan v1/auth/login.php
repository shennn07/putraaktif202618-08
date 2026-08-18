<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['user_id'])) {
    redirect($base . ($_SESSION['role'] === 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
}

$judul_halaman = 'Login';
require $base . 'includes/header.php';
?>

<div class="form-box">
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    <p class="form-foot">Belum punya akun? <a href="signup.php">Daftar di sini</a></p>
</div>

<?php require $base . 'includes/footer.php'; ?>
