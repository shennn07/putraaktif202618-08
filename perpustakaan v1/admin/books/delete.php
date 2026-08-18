<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

// --- Proses hapus (setelah tombol konfirmasi ditekan) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    // Buku yang masih punya transaksi aktif tidak boleh dihapus
    $stmt = mysqli_prepare($koneksi,
        "SELECT COUNT(*) AS n FROM borrowings WHERE book_id = ? AND status IN ('booking','borrowed')");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $adaTransaksiAktif = mysqli_stmt_get_result($stmt)->fetch_assoc()['n'] > 0;

    if ($adaTransaksiAktif) {
        setAlert('danger', 'Buku tidak dapat dihapus karena masih ada transaksi aktif (booking/dipinjam).');
    } else {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM books WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        setAlert('success', 'Buku berhasil dihapus.');
    }
    redirect($base . 'admin/books/index.php');
}

// --- Tampilkan halaman konfirmasi ---
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$buku = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$buku) {
    setAlert('danger', 'Buku tidak ditemukan.');
    redirect($base . 'admin/books/index.php');
}

$judul_halaman = 'Hapus Buku';
$halaman_aktif = 'books';
require $base . 'includes/admin_header.php';
?>

<div class="page-head"><h1 style="font-size:1.3rem;">Hapus Buku</h1></div>

<div class="card" style="max-width:520px;">
    <p>Apakah Anda yakin ingin menghapus buku berikut?</p>
    <p><strong><?= e($buku['judul']) ?></strong> (<?= e($buku['kode_buku']) ?>)</p>
    <form method="post">
        <input type="hidden" name="id" value="<?= (int)$buku['id'] ?>">
        <button type="submit" class="btn btn-merah">Ya, Hapus Buku</button>
        <a href="index.php" class="btn btn-outline">Batal</a>
    </form>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
