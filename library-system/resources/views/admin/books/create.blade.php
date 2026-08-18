@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<div class="page-header">
    <h1 style="font-size:1.5rem;">Tambah Buku Baru</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">&larr; Kembali</a>
</div>

<div class="card" style="max-width: 560px;">
    <div class="card-body">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.books._form')
            <button type="submit" class="btn btn-primary">Simpan Buku</button>
        </form>
    </div>
</div>
@endsection
