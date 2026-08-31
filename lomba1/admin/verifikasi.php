<?php
require_once '../config/koneksi.php';
require_once '../config/auth.php';
check_admin();

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id     = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    if (in_array($status, ['Diterima', 'Ditolak'])) {
        mysqli_query($conn, "UPDATE pendaftaran SET status='$status' WHERE id=$id");
    }
}

header("Location: dashboard.php");
exit();
?>