@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.5rem;">Kelola Buku</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">+ Tambah Buku</a>
</div>

<form action="{{ route('admin.books.index') }}" method="GET" class="search-bar">
    <input type="search" name="search" value="{{ $search }}" placeholder="Cari judul atau penulis...">
    <button type="submit" class="btn btn-outline">Cari</button>
    @if ($search)
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline">Reset</a>
    @endif
</form>

@if ($books->isEmpty())
    <div class="card"><div class="empty-state">Belum ada buku. Klik "Tambah Buku" untuk mulai.</div></div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="wrap"><a href="{{ route('books.show', $book) }}" target="_blank">{{ $book->title }}</a></td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year ?? '-' }}</td>
                        <td>
                            @if ($book->stock > 0)
                                <span class="badge badge-returned">{{ $book->stock }}</span>
                            @else
                                <span class="badge badge-overdue">0</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-row">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $books->links('partials.pagination') }}
    </div>
@endif
@endsection
