<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Riwayat booking & peminjaman milik siswa yang sedang login.
     */
    public function index(Request $request): View
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('history.index', compact('borrowings'));
    }
}
