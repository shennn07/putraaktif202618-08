<?php
// =============================================================
// Fungsi-fungsi bantu umum
// =============================================================

// Format Rupiah, contoh: 6000 -> "Rp6.000"
function formatRupiah($angka) {
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

// Format tanggal Indonesia, contoh: 2026-08-11 -> "11 Agustus 2026"
function formatTanggal($tanggal) {
    if (empty($tanggal)) return '-';
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $ts = strtotime($tanggal);
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

// Label & warna badge status buku
function labelStatusBuku($status) {
    switch ($status) {
        case 'available': return ['Tersedia', 'badge-hijau'];
        case 'booked':    return ['Sudah Dibooking', 'badge-kuning'];
        case 'borrowed':  return ['Sedang Dipinjam', 'badge-merah'];
        default:          return [ucfirst($status), 'badge-abu'];
    }
}

// Label & warna badge status peminjaman
function labelStatusPinjam($status) {
    switch ($status) {
        case 'booking':  return ['Menunggu Konfirmasi', 'badge-kuning'];
        case 'borrowed': return ['Sedang Dipinjam', 'badge-biru'];
        case 'returned': return ['Sudah Dikembalikan', 'badge-hijau'];
        case 'rejected': return ['Ditolak', 'badge-merah'];
        default:          return [ucfirst($status), 'badge-abu'];
    }
}

// Hitung berapa hari sudah lewat dari batas kembali (untuk yang masih dipinjam)
function hitungKeterlambatanBerjalan($due_date) {
    if (empty($due_date)) return 0;
    $hari = (int)floor((time() - strtotime($due_date)) / 86400);
    return $hari > 0 ? $hari : 0;
}

// Redirect helper
function redirect($lokasi) {
    header('Location: ' . $lokasi);
    exit;
}

// Simpan pesan alert ke session, ditampilkan sekali lalu dihapus
function setAlert($tipe, $pesan) {
    $_SESSION['alert'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilkanAlert() {
    if (!empty($_SESSION['alert'])) {
        $tipe  = htmlspecialchars($_SESSION['alert']['tipe']);
        $pesan = htmlspecialchars($_SESSION['alert']['pesan']);
        echo "<div class=\"alert alert-{$tipe}\">{$pesan}</div>";
        unset($_SESSION['alert']);
    }
}

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
