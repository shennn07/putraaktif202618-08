@extends('layouts.admin')

@section('title', 'Booking & Peminjaman')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.5rem;">Booking &amp; Peminjaman</h1>
</div>

<div class="filter-tabs">
    <a href="{{ route('admin.borrowings.index') }}" class="{{ ! $status ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'Pending']) }}" class="{{ $status === 'Pending' ? 'active' : '' }}">Pending</a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'Borrowed']) }}" class="{{ $status === 'Borrowed' ? 'active' : '' }}">Dipinjam</a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'Returned']) }}" class="{{ $status === 'Returned' ? 'active' : '' }}">Selesai</a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'Cancelled']) }}" class="{{ $status === 'Cancelled' ? 'active' : '' }}">Dibatalkan</a>
</div>

@if ($borrowings->isEmpty())
    <div class="card"><div class="empty-state">Tidak ada data untuk filter ini.</div></div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Judul Buku</th>
                    <th>Status</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->user->name }}</td>
                        <td class="wrap">{{ $borrowing->book->title }}</td>
                        <td>
                            @php
                                $badgeClass = match($borrowing->status) {
                                    'Pending' => 'badge-pending',
                                    'Borrowed' => $borrowing->isOverdue() ? 'badge-overdue' : 'badge-borrowed',
                                    'Returned' => 'badge-returned',
                                    default => 'badge-cancelled',
                                };
                                $badgeLabel = $borrowing->isOverdue() && $borrowing->status === 'Borrowed' ? 'Terlambat' : $borrowing->status;
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>
                        <td>{{ $borrowing->borrow_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->return_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->fine > 0 ? 'Rp' . number_format($borrowing->fine, 0, ',', '.') : '-' }}</td>
                        <td>
                            <div class="actions-row">
                                @if ($borrowing->status === 'Pending')
                                    <form action="{{ route('admin.borrowings.accept', $borrowing) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                    </form>
                                    <form action="{{ route('admin.borrowings.reject', $borrowing) }}" method="POST" onsubmit="return confirm('Tolak booking ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @elseif ($borrowing->status === 'Borrowed')
                                    <form action="{{ route('admin.returns.update', $borrowing) }}" method="POST" onsubmit="return confirm('Konfirmasi buku sudah dikembalikan?');">
                                        @csrf
                                        <button type="submit" class="btn btn-brass btn-sm">Buku Dikembalikan</button>
                                    </form>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $borrowings->links('partials.pagination') }}
    </div>
@endif
@endsection
