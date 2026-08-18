<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'booking_date',
        'borrow_date',
        'due_date',
        'return_date',
        'late_days',
        'fine',
        'status',
    ];

    /**
     * Cast atribut bawaan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    /**
     * Siswa yang melakukan booking/peminjaman.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Buku yang dibooking/dipinjam.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope: booking yang masih berstatus Pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope: peminjaman yang sedang berjalan (Borrowed).
     */
    public function scopeBorrowed($query)
    {
        return $query->where('status', 'Borrowed');
    }

    /**
     * Scope: peminjaman aktif (belum Returned/Cancelled) milik satu user.
     * Dipakai untuk validasi maksimal 2 buku per siswa.
     */
    public function scopeActiveForUser($query, int $userId)
    {
        return $query->where('user_id', $userId)
            ->whereIn('status', ['Pending', 'Borrowed']);
    }

    /**
     * Cek apakah peminjaman ini sedang terlambat (belum dikembalikan & lewat due_date).
     */
    public function isOverdue(): bool
    {
        return $this->status === 'Borrowed'
            && $this->due_date !== null
            && $this->due_date->isPast();
    }
}
