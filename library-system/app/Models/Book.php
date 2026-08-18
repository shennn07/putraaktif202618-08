<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'description',
        'cover',
        'stock',
    ];

    /**
     * Semua riwayat booking/peminjaman untuk buku ini.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Cek apakah buku masih bisa dibooking (stok tersedia).
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
}
