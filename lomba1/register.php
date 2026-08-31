<?php
require_once 'config/koneksi.php';

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', 'siswa')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
    } else {
        $error = "Gagal mendaftar: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PinjamAlat Sekolah</title>
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
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            border-color: #2563eb;
        }
        .btn-custom-primary {
            background-color: #2563eb;
            color: #fff;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            border: none;
        }
        .btn-custom-primary:hover {
            background-color: #1d4ed8;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="container" style="max-width: 440px;">
        <div class="card main-card p-4 p-sm-5 bg-white">
            
            <div class="text-center mb-3">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mx-auto" style="width: 64px; height: 64px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                      <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                      <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mt-2 mb-1">Buat Akun Baru</h3>
                <p class="text-muted small">Lengkapi data di bawah untuk mendaftar</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2 small rounded-3" role="alert">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3 text-start">
                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Kamu" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label small fw-semibold text-secondary">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@sekolah.sch.id" required>
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label small fw-semibold text-secondary">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Buat Password" required>
                </div>

                <button type="submit" name="register" class="btn btn-custom-primary w-100">
                    Daftar Sekarang
                </button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted">
                    Sudah punya akun? <a href="login.php" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
                </small>
            </div>

        </div>
    </div>

</body>
</html>