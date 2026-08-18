<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReturnController extends Controller
{
    /**
     * Denda per hari keterlambatan (Rupiah).
     */
    private const FINE_PER_DAY = 2000;

    /**
     * Validasi pengembalian buku oleh admin.
     *
     * Menghitung keterlambatan & denda otomatis, stock++, status = Returned.
     */
    public function update(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'Borrowed') {
            return back()->with('error', 'Peminjaman ini tidak dalam status dipinjam.');
        }

        $today = Carbon::today();
        $lateDays = $borrowing->due_date && $today->greaterThan($borrowing->due_date)
            ? $borrowing->due_date->diffInDays($today)
            : 0;
        $fine = $lateDays * self::FINE_PER_DAY;

        DB::transaction(function () use ($borrowing, $today, $lateDays, $fine) {
            $borrowing->update([
                'return_date' => $today->toDateString(),
                'late_days' => $lateDays,
                'fine' => $fine,
                'status' => 'Returned',
            ]);

            $borrowing->book()->increment('stock');
        });

        $message = $lateDays > 0
            ? "Buku dikembalikan. Terlambat {$lateDays} hari, denda Rp" . number_format($fine, 0, ',', '.') . '.'
            : 'Buku dikembalikan tepat waktu. Tidak ada denda.';

        return back()->with('success', $message);
    }
}
