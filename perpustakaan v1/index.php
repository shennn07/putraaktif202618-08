<?php
$base = '';
require $base . 'config/database.php';
require $base . 'includes/functions.php';

$kataKunci = trim($_GET['q'] ?? '');

if ($kataKunci !== '') {
    $like = '%' . $kataKunci . '%';
    $stmt = mysqli_prepare($koneksi,
        "SELECT * FROM books WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY judul ASC");
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
} else {
    $hasil = mysqli_query($koneksi, "SELECT * FROM books ORDER BY judul ASC");
}

$judul_halaman = 'Katalog Buku';
require $base . 'includes/header.php';
?>

<div class="page-head">
    <h1>Katalog Buku</h1>
</div>

<form action="index.php" method="get" class="search-bar">
    <input type="search" name="q" placeholder="Cari judul, penulis, atau kategori..." value="<?= e($kataKunci) ?>">
    <button type="submit" class="btn btn-primary">Cari</button>
    <?php if ($kataKunci !== ''): ?>
        <a href="index.php" class="btn btn-outline">Reset</a>
    <?php endif; ?>
</form>

<?php if (mysqli_num_rows($hasil) === 0): ?>
    <div class="card kosong">Tidak ada buku yang ditemukan.</div>
<?php else: ?>
    <div class="grid-buku">
        <?php while ($buku = mysqli_fetch_assoc($hasil)): ?>
            <?php [$labelStatus, $kelasBadge] = labelStatusBuku($buku['status']); ?>
            <div class="kartu-buku">
                <div class="cover-thumb">
                    📖
                    <span class="badge <?= $kelasBadge ?>"><?= e($labelStatus) ?></span>
                </div>
                <div class="isi">
                    <span class="kode"><?= e($buku['kode_buku']) ?></span>
                    <h3><?= e($buku['judul']) ?></h3>
                    <span class="penulis">oleh <?= e($buku['penulis']) ?></span>
                    <?php if ($buku['kategori']): ?>
                        <span class="kategori"><?= e($buku['kategori']) ?></span>
                    <?php endif; ?>
                    <div class="aksi">
                        <a href="detail.php?id=<?= (int)$buku['id'] ?>" class="btn btn-outline btn-kecil">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php require $base . 'includes/footer.php'; ?>
