<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$buku = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$buku) {
    setAlert('danger', 'Buku tidak ditemukan.');
    redirect($base . 'admin/books/index.php');
}

$judul_halaman = 'Edit Buku';
$halaman_aktif = 'books';
require $base . 'includes/admin_header.php';
?>

<div class="page-head"><h1 style="font-size:1.3rem;">Edit Buku</h1></div>

<div class="card" style="max-width:560px;">
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= (int)$buku['id'] ?>">
        <div class="form-group">
            <label for="kode_buku">Kode Buku</label>
            <input type="text" id="kode_buku" name="kode_buku" required value="<?= e($buku['kode_buku']) ?>">
        </div>
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" required value="<?= e($buku['judul']) ?>">
        </div>
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" required value="<?= e($buku['penulis']) ?>">
        </div>
        <div class="form-group">
            <label for="penerbit">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" value="<?= e($buku['penerbit']) ?>">
        </div>
        <div class="form-group">
            <label for="tahun">Tahun Terbit</label>
            <input type="number" id="tahun" name="tahun" min="1900" max="2100" value="<?= e($buku['tahun']) ?>">
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" value="<?= e($buku['kategori']) ?>">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="available" <?= $buku['status'] === 'available' ? 'selected' : '' ?>>Tersedia</option>
                <option value="booked" <?= $buku['status'] === 'booked' ? 'selected' : '' ?>>Sudah Dibooking</option>
                <option value="borrowed" <?= $buku['status'] === 'borrowed' ? 'selected' : '' ?>>Sedang Dipinjam</option>
            </select>
            <p class="form-hint">Ubah manual hanya jika diperlukan. Biasanya status berubah otomatis lewat proses peminjaman.</p>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-outline">Batal</a>
    </form>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
