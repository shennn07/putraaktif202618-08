<?php
require_once '../config/koneksi.php';
require_once '../config/auth.php';
check_login();

$user_id = $_SESSION['user_id'];

$check = mysqli_query($conn, "SELECT id FROM pendaftaran WHERE user_id = '$user_id'");
if (mysqli_num_rows($check) > 0) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['submit'])) {
    $nisn         = mysqli_real_escape_string($conn, $_POST['nisn']);
    $asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $nilai_rapor  = mysqli_real_escape_string($conn, $_POST['nilai_rapor']);
    $alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);

    $sql = "INSERT INTO pendaftaran (user_id, nisn, asal_sekolah, nilai_rapor, alamat) 
            VALUES ('$user_id', '$nisn', '$asal_sekolah', '$nilai_rapor', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Gagal mengirim data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        .btn-custom-primary {
            background-color: #2563eb;
            color: #fff;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom-primary:hover {
            background-color: #1d4ed8;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="container" style="max-width: 540px;">
        <div class="card main-card p-4 p-sm-5 bg-white">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1">Pendaftaran PPDB</h3>
                <p class="text-muted small">Lengkapi data diri Anda untuk menyelesaikan proses pendaftaran siswa baru.</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4" role="alert">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">NISN</label>
                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama sekolah asal" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Nilai Rapor (Rata-rata)</label>
                    <input type="number" step="0.01" name="nilai_rapor" class="form-control" placeholder="Contoh: 85.50" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat domisili lengkap" required></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-custom-primary">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>

            <div class="mt-4 pt-3 border-top text-center">
                <small class="text-muted" style="font-size: 0.75rem;">
                    © <?= date('Y') ?> Sistem Informasi PPDB Sekolah
                </small>
            </div>

        </div>
    </div>

</body>
</html>