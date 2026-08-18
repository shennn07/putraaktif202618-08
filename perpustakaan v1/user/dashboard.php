<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'siswa';
require $base . 'includes/auth_check.php';

$userId = (int)$_SESSION['user_id'];

// Ambil buku yang sedang aktif (booking / borrowed)
$stmt = mysqli_prepare($koneksi, "
    SELECT br.*, bk.judul, bk.penulis, bk.kode_buku
    FROM borrowings br
    JOIN books bk ON bk.id = br.book_id
    WHERE br.user_id = ? AND br.status IN ('booking', 'borrowed')
    ORDER BY br.created_at DESC
");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$aktif = mysqli_stmt_get_result($stmt);
$totalAktif = mysqli_num_rows($aktif);

$judul_halaman = 'Dashboard Siswa';
require $base . 'includes/header.php';
?>

<div class="page-head">
    <h1>Halo, <?= e($_SESSION['nama']) ?> 👋</h1>
</div>

<div class="grid-stat">
    <div class="stat-box <?= $totalAktif >= 2 ? 'aksen-merah' : 'aksen-hijau' ?>">
        <div class="angka"><?= $totalAktif ?> / 2</div>
        <div class="label">Buku Aktif Dipinjam/Dibooking</div>
    </div>
</div>

<?php if ($totalAktif >= 2): ?>
    <div class="alert alert-warning">⚠️ Anda sudah mencapai batas maksimal 2 buku. Kembalikan salah satu buku untuk bisa booking lagi.</div>
<?php endif; ?>

<div class="card">
    <h2>Buku Sedang Aktif</h2>
    <?php if ($totalAktif === 0): ?>
        <p class="kosong">Belum ada buku yang sedang dibooking atau dipinjam. <a href="<?= $base ?>index.php">Cari buku di katalog</a>.</p>
    <?php else: ?>
        <div class="table-wrap">
        <table>
            <tr>
                <th>Buku</th><th>Status</th><th>Tanggal Pinjam</th><th>Batas Kembali</th><th>Keterangan</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($aktif)): ?>
                <?php
                [$labelStatus, $kelasBadge] = labelStatusPinjam($row['status']);
                $terlambat = $row['status'] === 'borrowed' ? hitungKeterlambatanBerjalan($row['due_date']) : 0;
                ?>
                <tr>
                    <td><strong><?= e($row['judul']) ?></strong><br><span class="form-hint"><?= e($row['kode_buku']) ?></span></td>
                    <td><span class="badge <?= $kelasBadge ?>"><?= e($labelStatus) ?></span></td>
                    <td><?= formatTanggal($row['borrow_date']) ?></td>
                    <td><?= formatTanggal($row['due_date']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'booking'): ?>
                            Menunggu diambil di perpustakaan
                        <?php elseif ($terlambat > 0): ?>
                            <span class="badge badge-merah">Terlambat <?= $terlambat ?> hari</span>
                        <?php else: ?>
                            Tepat waktu
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        </div>
    <?php endif; ?>
</div>

<?php require $base . 'includes/footer.php'; ?>
