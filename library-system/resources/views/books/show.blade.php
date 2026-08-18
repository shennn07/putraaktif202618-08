@extends('layouts.app')

@section('title', $book->title)

@section('content')
<p><a href="{{ route('books.index') }}">&larr; Kembali ke katalog</a></p>

<div class="book-detail">
    <div class="book-cover" style="border-radius: var(--radius); aspect-ratio: 3/4;">
        @if ($book->cover)
            <img src="{{ asset('covers/' . $book->cover) }}" alt="Sampul {{ $book->title }}" style="border-radius: var(--radius);">
        @else
            {{ $book->title }}
        @endif
    </div>

    <div>
        <h1>{{ $book->title }}</h1>
        <p class="muted" style="font-size:1.05rem;">oleh {{ $book->author }}</p>

        <div class="actions-row" style="margin: 16px 0;">
            @if ($book->stock > 0)
                <span class="badge badge-returned">Tersedia · {{ $book->stock }} eksemplar</span>
            @else
                <span class="badge badge-overdue">Stok Habis</span>
            @endif
        </div>

        @if ($book->description)
            <p>{{ $book->description }}</p>
        @endif

        <div class="table-wrap" style="margin: 20px 0; max-width: 420px;">
            <table>
                <tbody>
                    <tr><th style="white-space:nowrap;">Penerbit</th><td>{{ $book->publisher ?? '-' }}</td></tr>
                    <tr><th>Tahun Terbit</th><td>{{ $book->year ?? '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        @auth
            @if (auth()->user()->isStudent())
                <form action="{{ route('borrow.store', $book) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" @disabled($book->stock <= 0)>
                        {{ $book->stock > 0 ? 'Booking / Pinjam Buku Ini' : 'Stok Habis' }}
                    </button>
                </form>
                <p class="help-text" style="margin-top:10px;">Maksimal 2 buku aktif per siswa. Setelah booking disetujui admin, ambil buku langsung di perpustakaan.</p>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Booking</a>
        @endauth
    </div>
</div>
@endsection
