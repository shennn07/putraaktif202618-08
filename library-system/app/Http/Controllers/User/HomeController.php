<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Halaman utama (landing page) — bisa diakses tanpa login.
     */
    public function index(): View
    {
        $latestBooks = Book::latest()->take(6)->get();
        $totalBooks = Book::count();
        $availableBooks = Book::where('stock', '>', 0)->count();

        return view('home', compact('latestBooks', 'totalBooks', 'availableBooks'));
    }

    /**
     * Dashboard siswa setelah login — ringkasan peminjaman aktif.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        $activeBorrowings = Borrowing::with('book')
            ->activeForUser($user->id)
            ->latest()
            ->get();

        $historyCount = Borrowing::where('user_id', $user->id)->count();

        return view('dashboard', compact('activeBorrowings', 'historyCount'));
    }
}
