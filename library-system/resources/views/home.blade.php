@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="hero" style="margin: -40px -24px 40px; border-radius: 16px;">
    <div class="container">
        <h1>Booking buku sekolah tanpa antre, ambil langsung di perpustakaan.</h1>
        <p>Cari buku, cek ketersediaan stok secara real-time, dan booking online. Pengambilan &amp; pengembalian tetap divalidasi langsung oleh admin perpustakaan.</p>
        <div class="actions-row" style="margin-top:24px;">
            <a href="{{ route('books.index') }}" class="btn btn-brass">Lihat Katalog Buku</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline" style="background:transparent; border-color:rgba(255,255,255,0.4); color:#fff;">Daftar Sekarang</a>
            @endguest
        </div>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalBooks }}</div>
        <div class="stat-label">Judul Buku Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $availableBooks }}</div>
        <div class="stat-label">Judul Buku Tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">3 Hari</div>
        <div class="stat-label">Masa Pinjam</div>
    </div>
</div>

<div class="page-header">
    <h2>Baru Ditambahkan</h2>
    <a href="{{ route('books.index') }}">Lihat semua &rarr;</a>
</div>

@if ($latestBooks->isEmpty())
    <div class="empty-state">Belum ada buku yang ditambahkan.</div>
@else
    <div class="book-grid">
        @foreach ($latestBooks as $book)
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
@endif
@endsection
