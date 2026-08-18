<?php
$base = '';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$buku = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$buku) {
    setAlert('danger', 'Buku tidak ditemukan.');
    redirect($base . 'index.php');
}

[$labelStatus, $kelasBadge] = labelStatusBuku($buku['status']);

$judul_halaman = $buku['judul'];
require $base . 'includes/header.php';
?>

<div class="card detail-buku">
    <div class="cover-placeholder">📖</div>
    <div>
        <span class="badge <?= $kelasBadge ?>"><?= e($labelStatus) ?></span>
        <h1><?= e($buku['judul']) ?></h1>
        <table class="info">
            <tr><td class="k">Kode Buku</td><td>: <?= e($buku['kode_buku']) ?></td></tr>
            <tr><td class="k">Penulis</td><td>: <?= e($buku['penulis']) ?></td></tr>
            <tr><td class="k">Penerbit</td><td>: <?= e($buku['penerbit'] ?: '-') ?></td></tr>
            <tr><td class="k">Tahun</td><td>: <?= e($buku['tahun'] ?: '-') ?></td></tr>
            <tr><td class="k">Kategori</td><td>: <?= e($buku['kategori'] ?: '-') ?></td></tr>
        </table>

        <div style="margin-top:18px;">
        <?php if (empty($_SESSION['user_id'])): ?>
            <p class="form-hint">🔒 Silakan <a href="auth/login.php">login</a> terlebih dahulu untuk melakukan peminjaman.</p>

        <?php elseif ($_SESSION['role'] !== 'siswa'): ?>
            <p class="form-hint">Login sebagai admin tidak dapat melakukan booking buku.</p>

        <?php elseif ($buku['status'] !== 'available'): ?>
            <button class="btn btn-nonaktif" disabled>⚠️ Buku sedang tidak tersedia</button>

        <?php else: ?>
            <form action="user/booking.php" method="post">
                <input type="hidden" name="book_id" value="<?= (int)$buku['id'] ?>">
                <button type="submit" class="btn btn-amber">Booking Buku</button>
            </form>
        <?php endif; ?>
        </div>
    </div>
</div>

<p><a href="index.php">&larr; Kembali ke katalog</a></p>

<?php require $base . 'includes/footer.php'; ?>
