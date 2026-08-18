<?php
$base = '../';
require $base . 'config/database.php';
require $base . 'includes/functions.php';
$halaman_untuk = 'siswa';
require $base . 'includes/auth_check.php';

$userId = (int)$_SESSION['user_id'];

// Proses ganti password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordLama = $_POST['password_lama'] ?? '';
    $passwordBaru = $_POST['password_baru'] ?? '';

    $stmt = mysqli_prepare($koneksi, "SELECT password FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $user = mysqli_stmt_get_result($stmt)->fetch_assoc();

    if (!password_verify($passwordLama, $user['password'])) {
        setAlert('danger', 'Password lama salah.');
    } elseif (strlen($passwordBaru) < 6) {
        setAlert('danger', 'Password baru minimal 6 karakter.');
    } else {
        $hashBaru = password_hash($passwordBaru, PASSWORD_BCRYPT);
        $stmt = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'si', $hashBaru, $userId);
        mysqli_stmt_execute($stmt);
        setAlert('success', 'Password berhasil diubah.');
    }
    redirect($base . 'user/profile.php');
}

$stmt = mysqli_prepare($koneksi, "SELECT nama, nis, kartu_pelajar, username, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$profil = mysqli_stmt_get_result($stmt)->fetch_assoc();

$judul_halaman = 'Profil Saya';
require $base . 'includes/header.php';
?>

<div class="page-head"><h1>Profil Saya</h1></div>

<div class="card">
    <h2>Data Diri</h2>
    <table class="info">
        <tr><td class="k" style="width:160px;color:#5c6357;">Nama Lengkap</td><td>: <?= e($profil['nama']) ?></td></tr>
        <tr><td class="k" style="color:#5c6357;">NIS</td><td>: <?= e($profil['nis']) ?></td></tr>
        <tr><td class="k" style="color:#5c6357;">No. Kartu Pelajar</td><td>: <?= e($profil['kartu_pelajar']) ?></td></tr>
        <tr><td class="k" style="color:#5c6357;">Username</td><td>: <?= e($profil['username']) ?></td></tr>
        <tr><td class="k" style="color:#5c6357;">Terdaftar Sejak</td><td>: <?= formatTanggal($profil['created_at']) ?></td></tr>
    </table>
</div>

<div class="card" style="max-width:440px;">
    <h2>Ganti Password</h2>
    <form method="post">
        <div class="form-group">
            <label for="password_lama">Password Lama</label>
            <input type="password" id="password_lama" name="password_lama" required>
        </div>
        <div class="form-group">
            <label for="password_baru">Password Baru</label>
            <input type="password" id="password_baru" name="password_baru" required minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Password</button>
    </form>
</div>

<?php require $base . 'includes/footer.php'; ?>
