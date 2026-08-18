# 📚 Sistem Informasi Perpustakaan Digital

Source code ini berisi **semua file custom** (Models, Controllers, Middleware, Migrations, Seeders, Routes, Views) sesuai struktur & workflow yang ada di dokumen project. File ini belum termasuk "kerangka" Laravel itu sendiri (folder `vendor/`, `config/`, `bootstrap/`, `artisan`, dll) karena kerangka tsb identik untuk semua project Laravel dan harus di-generate lewat Composer — environment saya tidak punya akses internet untuk menjalankan `composer install`. Jadi cara pakainya: generate Laravel kosong dulu, lalu timpa dengan file-file di sini.

---

## 1. Prasyarat

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js **tidak wajib** — project ini sengaja tidak pakai Tailwind/Vite. Styling pakai CSS custom polos (`public/css/app.css`) + Google Fonts via CDN, supaya tidak perlu proses build apa pun.

---

## 2. Instalasi

```bash
# 1. Buat project Laravel baru
composer create-project laravel/laravel library-system
cd library-system

# 2. Timpa/salin seluruh isi folder app/, resources/, routes/, database/, public/
#    dari paket ini ke folder project barumu (struktur foldernya sudah sama persis)

# 3. Copy .env
cp .env.example .env
php artisan key:generate
```

Buka `.env`, sesuaikan koneksi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_system
DB_USERNAME=root
DB_PASSWORD=
```

Lalu set locale ke Indonesia supaya format tanggal (`d M Y`) muncul dalam Bahasa Indonesia (Blade di project ini pakai `translatedFormat()`):

```
APP_LOCALE=id
```

> Kalau `.env` versi Laravel-mu belum ada baris `APP_LOCALE`, cukup ubah `'locale' => 'en'` menjadi `'locale' => 'id'` di `config/app.php`.

---

## 3. Daftarkan Middleware `role`

Ini **wajib**, karena route admin/siswa pakai `->middleware('role:admin')` dan `->middleware('role:student')`.

**Kalau project-mu Laravel 11/12 (tidak ada `app/Http/Kernel.php`)** — edit `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

**Kalau project-mu Laravel 10 (masih ada `app/Http/Kernel.php`)** — tambahkan satu baris di array `$middlewareAliases` (atau `$routeMiddleware` di versi lebih lama):

```php
protected $middlewareAliases = [
    // ...alias bawaan lainnya...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## 4. Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Seeder akan membuat:
- **1 akun admin** → username: `admin`, password: `admin123`
- **8 buku contoh** (termasuk 1 buku dengan stok 0, untuk testing tombol "Pinjam" yang nonaktif)

> Ganti password admin default ini sebelum dipakai sungguhan.

---

## 5. Jalankan

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`.

- **Siswa**: klik "Daftar" untuk membuat akun baru, lalu bisa langsung booking buku.
- **Admin**: login pakai `admin` / `admin123`, lalu masuk ke `/admin`.

---

## 6. Alur Sistem yang Diimplementasikan

Mengikuti workflow di dokumen, dengan satu penyesuaian yang memang sudah disarankan di dokumen aslinya:

```
Siswa booking (klik "Pinjam")
  → cek: sudah login? sudah pinjam < 2 buku aktif? stok > 0?
  → status = Pending  (stok BELUM dikurangi)

Admin klik "Accept"
  → borrow_date = hari ini, due_date = hari ini + 3 hari
  → status = Borrowed, stock--

Siswa kembalikan buku, admin klik "Buku Dikembalikan"
  → hitung hari terlambat & denda (Rp2.000 × hari terlambat)
  → status = Returned, stock++
```

Dua penambahan kecil di luar dokumen (supaya status `Cancelled` di skema database benar-benar terpakai & alurnya lengkap):
- Admin bisa **"Tolak"** booking yang masih Pending.
- Siswa bisa **membatalkan sendiri** booking miliknya yang masih Pending, dari halaman Dashboard.

---

## 7. Struktur File

Mengikuti persis struktur di dokumen project:

```
app/Http/Controllers/Admin/   → DashboardController, BookController, BorrowController, ReturnController
app/Http/Controllers/User/    → HomeController, BookController, BorrowController, HistoryController
app/Http/Controllers/AuthController.php
app/Http/Middleware/CheckRole.php
app/Models/                   → User, Book, Borrowing
database/migrations/          → users, books, borrowings
database/seeders/             → DatabaseSeeder, AdminSeeder, BookSeeder
routes/web.php
resources/views/layouts/      → app.blade.php (publik/siswa), admin.blade.php (sidebar admin)
resources/views/auth/         → login, register
resources/views/admin/        → dashboard, books/*, borrowings/*
resources/views/books/        → index (katalog), show (detail)
resources/views/history/      → index (riwayat siswa)
resources/views/home.blade.php
public/css/app.css            → design system (warna navy/teal/brass, tipografi Lora+Inter)
public/covers/                → tempat upload cover buku (langsung, tanpa storage:link)
```

---

## 8. Catatan & Asumsi

Beberapa hal di dokumen yang tidak dirinci lengkap, jadi saya putuskan sendiri secara wajar:

- **Login pakai `username`**, bukan email (sesuai field di dokumen) — jadi bukan sistem auth default Laravel.
- **"Total User"** di dashboard admin = seluruh akun terdaftar (admin + siswa).
- **"Buku Tersedia"** di dashboard = total eksemplar tersisa (`SUM(stock)`), bukan jumlah judul.
- Halaman **"Profil"** siswa yang disebut di daftar halaman belum dibuatkan, karena field & isinya tidak dirinci di dokumen. Field yang perlu ditambah tinggal bilang saja.
- Cover buku disimpan langsung ke `public/covers/` (bukan `storage/app/public` + symlink) — sesuai struktur folder yang sudah ditentukan di dokumen, dan lebih simpel untuk kebutuhan lomba.
- Style pakai CSS custom (bukan Bootstrap/Tailwind) supaya nggak butuh proses build — jadi tinggal jalan begitu di-copy.

Kalau ada bagian yang mau diubah (misalnya field Profil, aturan denda, atau tampilan), tinggal bilang bagian mana.
