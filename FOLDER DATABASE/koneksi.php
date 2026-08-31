<?php
$host     = "localhost";
$username = "root";
$pass = ""; 
$db = "db_siacad_smk";

$putra = mysqli_connect($host, $username, $pass, $db);

// if (!$putra) {
//     die("Koneksi ke database gagal: " . mysqli_connect_error());
// }elseif ($putra) {
//     echo "Koneksi ke database berhasil!"  . "<br>". "<br>";
// }

?>