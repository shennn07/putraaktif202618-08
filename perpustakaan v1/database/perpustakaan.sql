-- =============================================================
-- Database: perpustakaan
-- Sistem Perpustakaan Sekolah (PHP Native + MySQL)
-- Cara pakai: buat database baru bernama "perpustakaan" di phpMyAdmin,
-- lalu import file ini (tab Import).
-- =============================================================

CREATE DATABASE IF NOT EXISTS perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE perpustakaan;

-- -------------------------------------------------------------
-- Tabel: users
-- Menyimpan akun admin & siswa
-- -------------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(30) NULL,
    kartu_pelajar VARCHAR(30) NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'siswa') NOT NULL DEFAULT 'siswa',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Tabel: books
-- Setiap baris = 1 eksemplar fisik buku
-- -------------------------------------------------------------
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(30) NOT NULL UNIQUE,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NULL,
    tahun YEAR NULL,
    kategori VARCHAR(50) NULL,
    cover VARCHAR(255) NULL,
    status ENUM('available', 'booked', 'borrowed') NOT NULL DEFAULT 'available',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Tabel: borrowings
-- Menyimpan transaksi booking / peminjaman / pengembalian
-- -------------------------------------------------------------
CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    booking_date DATETIME NOT NULL,
    borrow_date DATE NULL,
    due_date DATE NULL,
    return_date DATE NULL,
    late_days INT NOT NULL DEFAULT 0,
    fine INT NOT NULL DEFAULT 0,
    status ENUM('booking', 'borrowed', 'returned', 'rejected') NOT NULL DEFAULT 'booking',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_borrowings_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_borrowings_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Akun admin default
-- username: admin
-- password: admin123
-- -------------------------------------------------------------
INSERT INTO users (nama, nis, kartu_pelajar, username, password, role) VALUES
('Administrator', NULL, NULL, 'admin', '$2b$12$jvnWg/5F1emIjo5C2h0LH.0KCnvlBYd.twVEn9hUq3UBbgv.p/7yO', 'admin');
-- password di atas adalah hash bcrypt dari "admin123"

-- -------------------------------------------------------------
-- Data contoh buku (boleh dihapus/diganti)
-- -------------------------------------------------------------
INSERT INTO books (kode_buku, judul, penulis, penerbit, tahun, kategori, status) VALUES
('BK-001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Novel', 'available'),
('BK-002', 'Bumi', 'Tere Liye', 'Gramedia', 2014, 'Novel', 'available'),
('BK-003', 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 'Pengembangan Diri', 'available'),
('BK-004', 'Sapiens', 'Yuval Noah Harari', 'Pustaka Alvabet', 2017, 'Sains Populer', 'available'),
('BK-005', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 'Novel', 'available');
