<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'admin';
require $base . 'includes/auth_check.php';

$totalBuku     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS n FROM books"))['n'];
$bukuTersedia  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS n FROM books WHERE status = 'available'"))['n'];
$bukuDipinjam  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS n FROM books WHERE status = 'borrowed'"))['n'];
$totalBooking  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS n FROM borrowings WHERE status = 'booking'"))['n'];
$totalTerlambat = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS n FROM borrowings WHERE status = 'borrowed' AND due_date < CURDATE()"))['n'];

// Daftar peminjaman yang sedang terlambat
$terlambatList = mysqli_query($koneksi, "
    SELECT br.*, bk.judul, u.nama
    FROM borrowings br
    JOIN books bk ON bk.id = br.book_id
    JOIN users u ON u.id = br.user_id
    WHERE br.status = 'borrowed' AND br.due_date < CURDATE()
    ORDER BY br.due_date ASC
    LIMIT 10
");

$judul_halaman = 'Dashboard Admin';
$halaman_aktif = 'dashboard';
require $base . 'includes/admin_header.php';
?>

<p class="muted" style="margin-bottom:20px;">Ringkasan aktivitas perpustakaan hari ini.</p>

<div class="grid-stat">
    <div class="stat-box">
        <div class="angka"><?= $totalBuku ?></div>
        <div class="label">Total Buku</div>
    </div>
    <div class="stat-box aksen-hijau">
        <div class="angka"><?= $bukuTersedia ?></div>
        <div class="label">Buku Tersedia</div>
    </div>
    <div class="stat-box aksen-amber">
        <div class="angka"><?= $bukuDipinjam ?></div>
        <div class="label">Sedang Dipinjam</div>
    </div>
    <div class="stat-box aksen-amber">
        <div class="angka"><?= $totalBooking ?></div>
        <div class="label">Menunggu Konfirmasi</div>
    </div>
    <div class="stat-box aksen-merah">
        <div class="angka"><?= $totalTerlambat ?></div>
        <div class="label">Peminjaman Terlambat</div>
    </div>
</div>

<div class="card">
    <h2>⚠️ Peminjaman Terlambat</h2>
    <?php if (mysqli_num_rows($terlambatList) === 0): ?>
        <p class="kosong">Tidak ada peminjaman yang terlambat saat ini.</p>
    <?php else: ?>
        <div class="table-wrap">
        <table>
            <tr><th>Siswa</th><th>Buku</th><th>Batas Kembali</th><th>Terlambat</th></tr>
            <?php while ($row = mysqli_fetch_assoc($terlambatList)): ?>
                <tr>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['judul']) ?></td>
                    <td><?= formatTanggal($row['due_date']) ?></td>
                    <td><span class="badge badge-merah"><?= hitungKeterlambatanBerjalan($row['due_date']) ?> hari</span></td>
                </tr>
            <?php endwhile; ?>
        </table>
        </div>
    <?php endif; ?>
</div>

<?php require $base . 'includes/admin_footer.php'; ?>
