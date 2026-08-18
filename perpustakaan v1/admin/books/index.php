<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

$kataKunci = trim($_GET['q'] ?? '');
if ($kataKunci !== '') {
    $like = '%' . $kataKunci . '%';
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM books WHERE judul LIKE ? OR kode_buku LIKE ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    $daftarBuku = mysqli_stmt_get_result($stmt);
} else {
    $daftarBuku = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC");
}

$judul_halaman = 'Data Buku';
$halaman_aktif = 'books';
require $base . 'includes/admin_header.php';
?>

<div class="page-head">
    <p class="muted" style="margin:0;">Kelola semua eksemplar buku perpustakaan.</p>
    <a href="create.php" class="btn btn-amber">+ Tambah Buku</a>
</div>

<form action="index.php" method="get" class="search-bar">
    <input type="search" name="q" placeholder="Cari judul atau kode buku..." value="<?= e($kataKunci) ?>">
    <button type="submit" class="btn btn-primary">Cari</button>
    <?php if ($kataKunci !== ''): ?><a href="index.php" class="btn btn-outline">Reset</a><?php endif; ?>
</form>

<div class="card">
<?php if (mysqli_num_rows($daftarBuku) === 0): ?>
    <p class="kosong">Belum ada data buku.</p>
<?php else: ?>
    <div class="table-wrap">
    <table>
        <tr>
            <th>Kode</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Status</th><th>Aksi</th>
        </tr>
        <?php while ($buku = mysqli_fetch_assoc($daftarBuku)): ?>
            <?php [$labelStatus, $kelasBadge] = labelStatusBuku($buku['status']); ?>
            <tr>
                <td><?= e($buku['kode_buku']) ?></td>
                <td><?= e($buku['judul']) ?></td>
                <td><?= e($buku['penulis']) ?></td>
                <td><?= e($buku['kategori'] ?: '-') ?></td>
                <td><span class="badge <?= $kelasBadge ?>"><?= e($labelStatus) ?></span></td>
                <td>
                    <a href="edit.php?id=<?= (int)$buku['id'] ?>" class="btn btn-outline btn-kecil">Edit</a>
                    <a href="delete.php?id=<?= (int)$buku['id'] ?>" class="btn btn-merah btn-kecil">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
<?php endif; ?>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
