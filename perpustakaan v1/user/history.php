<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'siswa';
require $base . 'includes/auth_check.php';

$userId = (int)$_SESSION['user_id'];

$stmt = mysqli_prepare($koneksi, "
    SELECT br.*, bk.judul, bk.kode_buku
    FROM borrowings br
    JOIN books bk ON bk.id = br.book_id
    WHERE br.user_id = ?
    ORDER BY br.created_at DESC
");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$riwayat = mysqli_stmt_get_result($stmt);

$judul_halaman = 'Riwayat Peminjaman';
require $base . 'includes/header.php';
?>

<div class="page-head"><h1>Riwayat Peminjaman</h1></div>

<div class="card">
<?php if (mysqli_num_rows($riwayat) === 0): ?>
    <p class="kosong">Belum ada riwayat peminjaman.</p>
<?php else: ?>
    <div class="table-wrap">
    <table>
        <tr>
            <th>Buku</th><th>Tgl Booking</th><th>Tgl Pinjam</th><th>Batas Kembali</th>
            <th>Tgl Kembali</th><th>Denda</th><th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
            <?php [$labelStatus, $kelasBadge] = labelStatusPinjam($row['status']); ?>
            <tr>
                <td><strong><?= e($row['judul']) ?></strong><br><span class="form-hint"><?= e($row['kode_buku']) ?></span></td>
                <td><?= formatTanggal($row['booking_date']) ?></td>
                <td><?= formatTanggal($row['borrow_date']) ?></td>
                <td><?= formatTanggal($row['due_date']) ?></td>
                <td><?= formatTanggal($row['return_date']) ?></td>
                <td><?= $row['fine'] > 0 ? formatRupiah($row['fine']) : '-' ?></td>
                <td><span class="badge <?= $kelasBadge ?>"><?= e($labelStatus) ?></span></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
<?php endif; ?>
</div>

<?php require $base . 'includes/footer.php'; ?>
