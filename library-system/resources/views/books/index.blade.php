@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.7rem;">Katalog Buku</h1>
</div>

<form action="{{ route('books.index') }}" method="GET" class="search-bar">
    <input type="search" name="search" value="{{ $search }}" placeholder="Cari judul atau penulis...">
    <button type="submit" class="btn btn-outline">Cari</button>
    @if ($search)
        <a href="{{ route('books.index') }}" class="btn btn-outline">Reset</a>
    @endif
</form>

@if ($books->isEmpty())
    <div class="card">
        <div class="empty-state">Tidak ada buku yang cocok dengan pencarian Anda.</div>
    </div>
@else
    <div class="book-grid">
        @foreach ($books as $book)
            <a href="{{ route('books.show', $book) }}" class="book-card" style="text-decoration:none; color:inherit;">
                <div class="book-cover">
                    @if ($book->cover)
                        <img src="{{ asset('covers/' . $book->cover) }}" alt="Sampul {{ $book->title }}">
                    @else
                        {{ $book->title }}
                    @endif
                </div>
                <div class="book-card-body">
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-author">{{ $book->author }}</div>
                    @if ($book->stock > 0)
                        <div class="book-stock in-stock">Tersedia · {{ $book->stock }} eksemplar</div>
                    @else
                        <div class="book-stock out-of-stock">Stok habis</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <div class="pagination">
        {{ $books->links('partials.pagination') }}
    </div>
@endif
@endsection
