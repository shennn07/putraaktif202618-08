<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = !empty($_SESSION['user_id']);
$role       = $_SESSION['role'] ?? null;
?>
<header class="navbar">
    <div class="navbar-inner container">
        <a href="<?= $base ?>index.php" class="brand">📚 Perpustakaan Sekolah</a>
        <nav class="nav-links">
            <a href="<?= $base ?>index.php">Katalog</a>

            <?php if (!$sudahLogin): ?>
                <a href="<?= $base ?>auth/login.php">Login</a>
                <a href="<?= $base ?>auth/signup.php" class="btn-nav">Daftar</a>

            <?php elseif ($role === 'siswa'): ?>
                <a href="<?= $base ?>user/dashboard.php">Dashboard</a>
                <a href="<?= $base ?>user/history.php">Riwayat</a>
                <a href="<?= $base ?>user/profile.php">Profil</a>
                <a href="<?= $base ?>auth/logout.php" class="btn-nav btn-nav-keluar">Logout</a>

            <?php elseif ($role === 'admin'): ?>
                <a href="<?= $base ?>admin/dashboard.php">Dashboard</a>
                <a href="<?= $base ?>admin/books/index.php">Data Buku</a>
                <a href="<?= $base ?>admin/borrowings/index.php">Peminjaman</a>
                <a href="<?= $base ?>auth/logout.php" class="btn-nav btn-nav-keluar">Logout</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
