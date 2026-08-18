<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard admin: total buku, total user, buku dipinjam,
     * buku tersedia, buku terlambat, dan jumlah booking pending.
     */
    public function index(): View
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'borrowed_books' => Borrowing::borrowed()->count(),
            'available_books' => (int) Book::sum('stock'),
            'overdue_books' => Borrowing::borrowed()->whereDate('due_date', '<', now())->count(),
            'pending_bookings' => Borrowing::pending()->count(),
        ];

        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBorrowings'));
    }
}
