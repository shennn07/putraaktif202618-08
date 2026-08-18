@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.7rem;">Riwayat Peminjaman</h1>
</div>

@if ($borrowings->isEmpty())
    <div class="card">
        <div class="empty-state">
            Anda belum pernah melakukan booking buku. <a href="{{ route('books.index') }}">Cari buku sekarang</a>.
        </div>
    </div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Status</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Hari Terlambat</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowings as $borrowing)
                    <tr>
                        <td class="wrap">{{ $borrowing->book->title }}</td>
                        <td>
                            @php
                                $badgeClass = match($borrowing->status) {
                                    'Pending' => 'badge-pending',
                                    'Borrowed' => $borrowing->isOverdue() ? 'badge-overdue' : 'badge-borrowed',
                                    'Returned' => 'badge-returned',
                                    'Cancelled' => 'badge-cancelled',
                                    default => 'badge-cancelled',
                                };
                                $badgeLabel = $borrowing->isOverdue() && $borrowing->status === 'Borrowed' ? 'Terlambat' : $borrowing->status;
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>
                        <td>{{ $borrowing->borrow_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->return_date?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>{{ $borrowing->late_days > 0 ? $borrowing->late_days . ' hari' : '-' }}</td>
                        <td>{{ $borrowing->fine > 0 ? 'Rp' . number_format($borrowing->fine, 0, ',', '.') : '-' }}</td>
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
