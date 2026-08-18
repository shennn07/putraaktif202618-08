# 📚 Sistem Perpustakaan Sekolah

PHP Native (tanpa framework) + MySQL. Siswa booking buku online, ambil & kembalikan buku dilakukan langsung di perpustakaan dan divalidasi admin.

## Cara Install (XAMPP)

1. Ekstrak folder `perpustakaan` ini ke dalam `htdocs` (misalnya `C:\xampp\htdocs\perpustakaan`).
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin`.
4. Buat database baru bernama **`perpustakaan`** (atau langsung import saja, karena file SQL sudah mengandung `CREATE DATABASE IF NOT EXISTS`).
5. Buka tab **Import**, pilih file `database/perpustakaan.sql`, lalu klik **Go**.
6. Buka `http://localhost/perpustakaan/` di browser.

## Akun Default

**Admin**
- Username: `admin`
- Password: `admin123`

**Siswa**
- Daftar akun baru lewat halaman **Daftar** (signup).

## Konfigurasi Database

Jika pengaturan MySQL kamu berbeda dari default XAMPP (misal ada password root), edit file:

```
config/database.php
```

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'perpustakaan');
```

## Struktur Folder

```
perpustakaan/
├── index.php              → Katalog buku (publik)
├── detail.php              → Detail buku + tombol booking
├── config/database.php     → Koneksi database
├── auth/                   → Login, signup, logout
├── user/                   → Dashboard siswa, booking, riwayat, profil
├── admin/                  → Dashboard admin, CRUD buku, validasi peminjaman
├── includes/                → Header, navbar, footer, fungsi bantu, auth check
├── assets/css/style.css    → Styling
└── database/perpustakaan.sql → Struktur & data awal database
```

## Alur Sistem

1. **Siswa** cari buku di katalog → lihat detail → **Booking Buku** (harus login, maksimal 2 buku aktif).
2. **Admin** buka menu **Peminjaman** tab "Menunggu Konfirmasi" → saat siswa datang ke perpustakaan, admin klik **Konfirmasi Dipinjam** (batas kembali otomatis +3 hari) atau **Tolak**.
3. Saat siswa mengembalikan buku secara langsung, admin buka tab "Sedang Dipinjam" → klik **Konfirmasi Pengembalian**. Sistem otomatis menghitung denda **Rp2.000 × jumlah hari terlambat**.
4. Buku otomatis kembali berstatus **Tersedia** setelah dikembalikan/ditolak.

## Aturan Bisnis

- Maksimal **2 buku aktif** (booking + dipinjam) per siswa.
- Masa pinjam **3 hari** sejak admin konfirmasi.
- Denda keterlambatan: **Rp2.000/hari**.
- Setiap baris di tabel `books` = 1 eksemplar fisik (bukan jumlah stok).
