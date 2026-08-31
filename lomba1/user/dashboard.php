<?php
require_once '../config/koneksi.php';
require_once '../config/auth.php';
check_login();

$user_id = $_SESSION['user_id'];
$query   = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE user_id = '$user_id'");
$data    = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SMK SANGKURIANG 1 CIMAHI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
        }

        .hero-section {
            position: relative;
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1000') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: rgba(0, 0, 0, 0.2);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .hero-content {
            text-align: center;
            margin-bottom: 180px;
            width: 100%;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .search-box {
            display: flex;
            background: white;
            border-radius: 30px;
            padding: 5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 12px 25px;
            width: 100%;
            border-radius: 30px;
            font-size: 14px;
        }

        .search-box button {
            background-color: #fca311;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }

        .content-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .news-card {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <div class="hero-section">
        <nav class="navbar">
            <div class="logo">PPDB SAKUCI</div>
            <ul class="nav-links">
                <li><a href="../logout.php">LOGOUT</a></li>
                
        
               
            </ul>
        </nav>

        <div class="hero-content">
            <h1 class="hero-title">SMK SANGKURIANG 1 CIMAHI</h1>
            <?php if (!$data): ?>
        <p>Anda belum mengisi formulir pendaftaran.</p>
        <button type="button" class="btn btn-warning" style="background-color: #fca311; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            <a href="daftar.php" style="color: white; text-decoration: none;">Isi Formulir Pendaftaran Sekarang</a>
        </button>
    <?php else: ?>
        <h3>Status Pendaftaran Anda: <strong><?= $data['status']; ?></strong></h3>
        <ul>
            <ol>NISN: <?= htmlspecialchars($data['nisn']); ?></ol>
            <ol>Asal Sekolah: <?= htmlspecialchars($data['asal_sekolah']); ?></ol>
            <ol>Nilai Rapor: <?= htmlspecialchars($data['nilai_rapor']); ?></ol>
            <ol>Alamat: <?= htmlspecialchars($data['alamat']); ?></ol>
        </ul>
    <?php endif; ?>
        </div>
        
    </div>

</body>
</html>