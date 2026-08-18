@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.5rem;">Edit Buku</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">&larr; Kembali</a>
</div>

<div class="card" style="max-width: 560px;">
    <div class="card-body">
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.books._form', ['book' => $book])
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
