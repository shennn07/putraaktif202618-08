<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowController extends Controller
{
    /**
     * Lama masa pinjam dalam hari, dihitung sejak admin accept.
     */
    private const LOAN_PERIOD_DAYS = 3;

    /**
     * Daftar booking & peminjaman (validasi booking + monitoring dalam satu halaman).
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $borrowings = Borrowing::with(['user', 'book'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.borrowings.index', compact('borrowings', 'status'));
    }

    /**
     * Admin menyetujui booking (Pending -> Borrowed) & menyerahkan buku ke siswa.
     *
     * borrow_date = hari ini, due_date = hari ini + 3 hari, stock--.
     */
    public function accept(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'Pending') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $book = $borrowing->book;

        if (! $book->isAvailable()) {
            return back()->with('error', 'Stok buku ini sudah habis, booking tidak dapat disetujui.');
        }

        DB::transaction(function () use ($borrowing, $book) {
            $borrowing->update([
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addDays(self::LOAN_PERIOD_DAYS)->toDateString(),
                'status' => 'Borrowed',
            ]);

            $book->decrement('stock');
        });

        return back()->with('success', 'Booking disetujui. Buku sudah bisa diserahkan ke siswa.');
    }

    /**
     * Admin menolak booking (Pending -> Cancelled), mis. buku tidak bisa diambil siswa.
     */
    public function reject(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'Pending') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $borrowing->update(['status' => 'Cancelled']);

        return back()->with('success', 'Booking berhasil ditolak.');
    }
}
