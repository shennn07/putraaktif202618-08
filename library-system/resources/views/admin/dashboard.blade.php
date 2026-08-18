@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_books'] }}</div>
        <div class="stat-label">Total Judul Buku</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total User Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['borrowed_books'] }}</div>
        <div class="stat-label">Buku Sedang Dipinjam</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['available_books'] }}</div>
        <div class="stat-label">Eksemplar Tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color: var(--rust);">{{ $stats['overdue_books'] }}</div>
        <div class="stat-label">Peminjaman Terlambat</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color: var(--brass);">{{ $stats['pending_bookings'] }}</div>
        <div class="stat-label">Booking Menunggu Validasi</div>
    </div>
</div>

<div class="page-header">
    <h2>Aktivitas Terbaru</h2>
    <a href="{{ route('admin.borrowings.index') }}">Lihat semua &rarr;</a>
</div>

@if ($recentBorrowings->isEmpty())
    <div class="card"><div class="empty-state">Belum ada aktivitas booking/peminjaman.</div></div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Tanggal Booking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentBorrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->user->name }}</td>
                        <td class="wrap">{{ $borrowing->book->title }}</td>
                        <td>
                            @php
                                $badgeClass = match($borrowing->status) {
                                    'Pending' => 'badge-pending',
                                    'Borrowed' => 'badge-borrowed',
                                    'Returned' => 'badge-returned',
                                    default => 'badge-cancelled',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $borrowing->status }}</span>
                        </td>
                        <td>{{ $borrowing->booking_date?->translatedFormat('d M Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
