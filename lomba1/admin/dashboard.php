<?php
require_once '../config/koneksi.php';
require_once '../config/auth.php';
check_admin();

$sql = "SELECT pendaftaran.*, users.nama, users.email 
        FROM pendaftaran 
        JOIN users ON pendaftaran.user_id = users.id 
        ORDER BY pendaftaran.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard Admin - PPDB</title></head>
<body>
    <h1>Dashboard Kelola PPDB (Admin)</h1>
    <button type="button" class="btn btn-danger">
        <a href="../logout.php" style="color: black; text-decoration: none;">Logout</a>
    </button>
    <hr>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
                <th>Nilai Rapor</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['nisn']); ?></td>
                <td><?= htmlspecialchars($row['asal_sekolah']); ?></td>
                <td><?= htmlspecialchars($row['nilai_rapor']); ?></td>
                <td><strong><?= htmlspecialchars($row['status']); ?></strong></td>
                <td>
                    <a href="verifikasi.php?id=<?= $row['id']; ?>&status=Diterima" onclick="return confirm('Terima pendaftar ini?')">Terima</a> | 
                    <a href="verifikasi.php?id=<?= $row['id']; ?>&status=Ditolak" onclick="return confirm('Tolak pendaftar ini?')">Tolak</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>