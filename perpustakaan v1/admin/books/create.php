<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

$judul_halaman = 'Tambah Buku';
$halaman_aktif = 'books';
require $base . 'includes/admin_header.php';
?>

<div class="page-head"><h1 style="font-size:1.3rem;">Tambah Buku</h1></div>

<div class="card" style="max-width:560px;">
    <form action="store.php" method="post">
        <div class="form-group">
            <label for="kode_buku">Kode Buku</label>
            <input type="text" id="kode_buku" name="kode_buku" required placeholder="Contoh: BK-006">
        </div>
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" required>
        </div>
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" required>
        </div>
        <div class="form-group">
            <label for="penerbit">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit">
        </div>
        <div class="form-group">
            <label for="tahun">Tahun Terbit</label>
            <input type="number" id="tahun" name="tahun" min="1900" max="2100">
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" placeholder="Contoh: Novel">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Buku</button>
        <a href="index.php" class="btn btn-outline">Batal</a>
    </form>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
