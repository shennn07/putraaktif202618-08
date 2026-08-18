<?php
$base = '../../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

$tab = $_GET['tab'] ?? 'booking';
if (!in_array($tab, ['booking', 'borrowed', 'returned', 'rejected'], true)) {
    $tab = 'booking';
}

$stmt = mysqli_prepare($koneksi, "
    SELECT br.*, bk.judul, bk.kode_buku, u.nama, u.nis
    FROM borrowings br
    JOIN books bk ON bk.id = br.book_id
    JOIN users u ON u.id = br.user_id
    WHERE br.status = ?
    ORDER BY br.created_at DESC
");
mysqli_stmt_bind_param($stmt, 's', $tab);
mysqli_stmt_execute($stmt);
$daftar = mysqli_stmt_get_result($stmt);

$tabLabel = [
    'booking'  => 'Menunggu Konfirmasi',
    'borrowed' => 'Sedang Dipinjam',
    'returned' => 'Sudah Dikembalikan',
    'rejected' => 'Ditolak',
];

$judul_halaman = 'Data Peminjaman';
$halaman_aktif = 'borrowings';
require $base . 'includes/admin_header.php';
?>

<p class="muted" style="margin-bottom:16px;">Validasi booking, konfirmasi peminjaman, dan pengembalian buku.</p>

<div class="filter-tabs">
    <?php foreach ($tabLabel as $key => $label): ?>
        <a href="index.php?tab=<?= $key ?>" class="<?= $tab === $key ? 'active' : '' ?>">
            <?= e($label) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card">
<?php if (mysqli_num_rows($daftar) === 0): ?>
    <p class="kosong">Tidak ada data pada kategori ini.</p>
<?php else: ?>
    <div class="table-wrap">
    <table>
        <tr>
            <th>Siswa</th><th>Buku</th><th>Tgl Booking</th>
            <?php if ($tab === 'borrowed' || $tab === 'returned'): ?>
                <th>Tgl Pinjam</th><th>Batas Kembali</th>
            <?php endif; ?>
            <?php if ($tab === 'returned'): ?>
                <th>Tgl Kembali</th><th>Denda</th>
            <?php endif; ?>
            <?php if ($tab === 'borrowed'): ?>
                <th>Status Waktu</th>
            <?php endif; ?>
            <?php if ($tab === 'booking' || $tab === 'borrowed'): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($daftar)): ?>
            <tr>
                <td><?= e($row['nama']) ?><br><span class="form-hint">NIS: <?= e($row['nis']) ?></span></td>
                <td><?= e($row['judul']) ?><br><span class="form-hint"><?= e($row['kode_buku']) ?></span></td>
                <td><?= formatTanggal($row['booking_date']) ?></td>

                <?php if ($tab === 'borrowed' || $tab === 'returned'): ?>
                    <td><?= formatTanggal($row['borrow_date']) ?></td>
                    <td><?= formatTanggal($row['due_date']) ?></td>
                <?php endif; ?>

                <?php if ($tab === 'returned'): ?>
                    <td><?= formatTanggal($row['return_date']) ?></td>
                    <td><?= $row['fine'] > 0 ? formatRupiah($row['fine']) : '-' ?></td>
                <?php endif; ?>

                <?php if ($tab === 'borrowed'): ?>
                    <?php $telat = hitungKeterlambatanBerjalan($row['due_date']); ?>
                    <td>
                        <?php if ($telat > 0): ?>
                            <span class="badge badge-merah">Terlambat <?= $telat ?> hari</span>
                        <?php else: ?>
                            <span class="badge badge-hijau">Tepat waktu</span>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>

                <?php if ($tab === 'booking'): ?>
                    <td>
                        <form action="accept.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="btn btn-hijau btn-kecil">Konfirmasi Dipinjam</button>
                        </form>
                        <form action="reject.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="btn btn-merah btn-kecil">Tolak</button>
                        </form>
                    </td>
                <?php elseif ($tab === 'borrowed'): ?>
                    <td>
                        <form action="return.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="btn btn-amber btn-kecil">Konfirmasi Pengembalian</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
<?php endif; ?>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
