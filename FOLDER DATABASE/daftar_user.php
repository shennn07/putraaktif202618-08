<?php
require_once 'koneksi.php';

$sql = "SELECT users.*,
COALESCE(siswa.nama, guru.nama) AS nama_pengguna
FROM users
LEFT JOIN siswa ON users.id = siswa.user_id
LEFT JOIN guru ON users.id = guru.user_id
";

$result = mysqli_query($putra, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        // echo "ID: " . $row["id"] . " - Nama: " . $row["nama_pengguna"] . "<br>";
    }
} else {
    echo "0 results";
}

?>
<!-- 2. Tampilkan data menggunakan HTML dan foreach -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengguna</title>
    <style>
        /* CSS simpel untuk tabel */
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>username</th>
                <th>role</th>
                <th>password</th>
                <th>Nama Pengguna</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Cek apakah array $data ada isinya
            if (!empty($data)) {
                // Gunakan foreach untuk me-looping isi array $data
                foreach ($data as $item) {
            ?>
                    <tr>
                        <td><?php echo $item["id"]; ?></td>
                        <td><?php echo $item["username"]; ?></td>
                        <td><?php echo $item["role"]; ?></td>
                        <td><?php echo $item["password"]; ?></td>
                        <td><?php echo $item["nama_pengguna"] ? $item["nama_pengguna"] : '<em>Belum ada profil</em>'; ?></td>
                    </tr>
            <?php 
                } 
            } else {
            ?>
                <!-- Jika data kosong, tampilkan ini -->
                <tr>
                    <td colspan="2" style="text-align: center;">0 results</td>
                </tr>
            <?php 
            } 
            ?>
        </tbody>
    </table>

</body>
</html>