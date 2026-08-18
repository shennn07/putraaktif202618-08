<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TUGAS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'tugasnavbar.php' ?>

    <!-- Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h3 class="text-center mb-4">Data Siswa</h3>
                <form method="post">
                    <label class="form-label">Data Profil Siswa</label>
                    <div class="mb-3">
                        <input type="text" name="nis" class="form-control" placeholder="nis">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nama" class="form-control" placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="kelas" class="form-control" placeholder="Kelas">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                    </div>
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" id="laki" value="Laki-laki">
                        <label class="form-check-label" for="laki">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="jk" id="perempuan" value="Perempuan">
                        <label class="form-check-label" for="perempuan">
                            Perempuan
                        </label>
                    </div>
                    <label class="form-label">Data Akun</label>
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" >
                        Submit
                    </button>
                </form><br><br>


                    <!-- OUTPUT PHP -->

    <?php if (isset($_POST['submit'])) {
    echo "<h1> OUTPUT DATA SISWA</h1>";
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $jenisklmn = $_POST['jk'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "id = ".$nis. "<br>";
    echo "nama = ".$nama. "<br>";
    echo "kelas = ".$kelas. "<br>";
    echo "alamat = ".$alamat. "<br>";
    echo "kelamin = ".$jenisklmn. "<br>";
    echo "username = ".$username. "<br>";
    echo "password = ".$password. "<br>";
    }
?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>