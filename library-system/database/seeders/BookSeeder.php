<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Isi beberapa data buku contoh supaya sistem langsung bisa didemokan.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'description' => 'Novel tentang perjuangan anak-anak Belitung mengejar pendidikan.',
                'stock' => 4,
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'year' => 1980,
                'description' => 'Novel sejarah tetralogi Pulau Buru.',
                'stock' => 3,
            ],
            [
                'title' => 'Matematika untuk SMA/SMK Kelas XI',
                'author' => 'Tim Kemendikbud',
                'publisher' => 'Kemendikbud',
                'year' => 2021,
                'description' => 'Buku paket matematika kurikulum nasional.',
                'stock' => 6,
            ],
            [
                'title' => 'Fisika Dasar',
                'author' => 'Halliday & Resnick',
                'publisher' => 'Erlangga',
                'year' => 2010,
                'description' => 'Buku referensi fisika untuk tingkat menengah.',
                'stock' => 2,
            ],
            [
                'title' => 'Belajar Pemrograman Web dengan Laravel',
                'author' => 'Budi Santoso',
                'publisher' => 'Elex Media',
                'year' => 2022,
                'description' => 'Panduan praktis membangun aplikasi web dengan Laravel.',
                'stock' => 5,
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2009,
                'description' => 'Kisah santri di pondok pesantren mengejar cita-cita.',
                'stock' => 0,
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'publisher' => 'Serambi',
                'year' => 2008,
                'description' => 'Sejarah Indonesia dari masa kolonial hingga modern.',
                'stock' => 3,
            ],
            [
                'title' => 'Cerita Rakyat Nusantara',
                'author' => 'Tim Penulis',
                'publisher' => 'Balai Pustaka',
                'year' => 2015,
                'description' => 'Kumpulan cerita rakyat dari berbagai daerah di Indonesia.',
                'stock' => 4,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(['title' => $book['title']], $book);
        }
    }
}
