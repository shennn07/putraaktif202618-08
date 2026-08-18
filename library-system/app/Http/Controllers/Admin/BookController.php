<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Daftar semua buku (dengan pencarian) untuk dikelola admin.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $books = Book::query()
            ->when($search, fn ($query) => $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%"))
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books', 'search'));
    }

    /**
     * Form tambah buku baru.
     */
    public function create(): View
    {
        return view('admin.books.create');
    }

    /**
     * Simpan buku baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBook($request);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $this->storeCover($request);
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Form edit buku.
     */
    public function edit(Book $book): View
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update data buku, termasuk ganti cover dan ubah stok.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $this->validateBook($request, $book->id);

        if ($request->hasFile('cover')) {
            $this->deleteCover($book->cover);
            $validated['cover'] = $this->storeCover($request);
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Hapus buku. Ditolak jika masih ada peminjaman aktif agar data historis aman.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $hasActiveBorrowing = $book->borrowings()->whereIn('status', ['Pending', 'Borrowed'])->exists();

        if ($hasActiveBorrowing) {
            return back()->with('error', 'Buku tidak dapat dihapus karena masih ada booking/peminjaman aktif.');
        }

        $this->deleteCover($book->cover);
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Validasi input form buku. $ignoreId dipakai saat update agar unique title tidak bentrok diri sendiri (opsional).
     */
    private function validateBook(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    /**
     * Simpan file cover ke public/covers dan kembalikan nama filenya.
     */
    private function storeCover(Request $request): string
    {
        $file = $request->file('cover');
        $filename = uniqid('cover_') . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('covers'), $filename);

        return $filename;
    }

    /**
     * Hapus file cover lama dari public/covers (kalau ada).
     */
    private function deleteCover(?string $filename): void
    {
        if ($filename && file_exists(public_path('covers/' . $filename))) {
            @unlink(public_path('covers/' . $filename));
        }
    }
}
