@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 style="font-size:1.7rem;">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="muted" style="margin:0;">Berikut ringkasan peminjaman buku Anda.</p>
    </div>
    <a href="{{ route('books.index') }}" class="btn btn-primary">+ Booking Buku Baru</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $activeBorrowings->count() }}</div>
        <div class="stat-label">Peminjaman Aktif (maks. 2)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $historyCount }}</div>
        <div class="stat-label">Total Riwayat Transaksi</div>
    </div>
</div>

<div class="page-header">
    <h2>Booking &amp; Peminjaman Aktif</h2>
    <a href="{{ route('history.index') }}">Lihat riwayat lengkap &rarr;</a>
</div>

@if ($activeBorrowings->isEmpty())
    <div class="card">
        <div class="empty-state">
            Belum ada booking aktif. <a href="{{ route('books.index') }}">Cari buku sekarang</a>.
        </div>
    </div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Status</th>
                    <th>Tanggal Booking</th>
                    <th>Batas Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeBorrowings as $borrowing)
                    <tr>
                        <td class="wrap">{{ $borrowing->book->title }}</td>
                        <td>
                            @if ($borrowing->status === 'Pending')
                                <span class="badge badge-pending">Pending</span>
                            @elseif ($borrowing->isOverdue())
                                <span class="badge badge-overdue">Terlambat</span>
                            @else
                                <span class="badge badge-borrowed">Dipinjam</span>
                            @endif
                        </td>
                        <td>{{ $borrowing->booking_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>
                            @if ($borrowing->status === 'Pending')
                                <form action="{{ route('borrow.cancel', $borrowing) }}" method="POST" onsubmit="return confirm('Batalkan booking buku ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                </form>
                            @else
                                <span class="muted">Ambil di perpustakaan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
