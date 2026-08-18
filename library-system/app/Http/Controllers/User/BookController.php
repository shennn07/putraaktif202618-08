<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Daftar katalog buku, bisa diakses guest maupun siswa. Mendukung pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->orderBy('title')
            ->paginate(9)
            ->withQueryString();

        return view('books.index', compact('books', 'search'));
    }

    /**
     * Detail satu buku.
     */
    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }
}
