@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="auth-card">
    <div class="card">
        <div class="card-body">
            <h1 style="font-size:1.5rem;">Daftar Akun Siswa</h1>
            <p class="muted">Buat akun untuk mulai booking buku secara online.</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="field">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}" required>
                </div>
                <div class="field">
                    <label for="student_card">Nomor Kartu Pelajar</label>
                    <input type="text" id="student_card" name="student_card" value="{{ old('student_card') }}" required>
                </div>
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <div class="help-text">Minimal 6 karakter.</div>
                </div>
                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </form>

            <p class="muted" style="margin-top:18px; text-align:center;">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
