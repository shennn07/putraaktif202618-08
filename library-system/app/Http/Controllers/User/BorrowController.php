<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Maksimal jumlah buku yang boleh dipinjam aktif per siswa.
     */
    private const MAX_ACTIVE_BORROW = 2;

    /**
     * Proses booking buku oleh siswa yang sedang login.
     *
     * Alur: sudah login (middleware auth) -> jumlah pinjaman aktif < 2
     * -> stok > 0 -> status Pending.
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        $user = $request->user();

        $activeCount = Borrowing::activeForUser($user->id)->count();

        if ($activeCount >= self::MAX_ACTIVE_BORROW) {
            return back()->with('error', 'Anda sudah meminjam ' . self::MAX_ACTIVE_BORROW . ' buku. Kembalikan salah satu buku terlebih dahulu sebelum booking lagi.');
        }

        if (! $book->isAvailable()) {
            return back()->with('error', 'Stok buku ini sedang habis.');
        }

        $alreadyBooked = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['Pending', 'Borrowed'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Anda sudah memesan buku ini sebelumnya.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'booking_date' => now()->toDateString(),
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Booking berhasil dibuat. Silakan datang ke perpustakaan untuk mengambil buku setelah dikonfirmasi admin.');
    }

    /**
     * Siswa membatalkan booking miliknya sendiri selama masih Pending.
     */
    public function cancel(Request $request, Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($borrowing->status !== 'Pending') {
            return back()->with('error', 'Booking ini sudah diproses dan tidak bisa dibatalkan.');
        }

        $borrowing->update(['status' => 'Cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
