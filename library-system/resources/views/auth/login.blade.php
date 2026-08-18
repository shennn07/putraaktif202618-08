@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="card">
        <div class="card-body">
            <h1 style="font-size:1.5rem;">Masuk ke Akun Anda</h1>
            <p class="muted">Login untuk booking buku dan melihat riwayat peminjaman.</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="field" style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" id="remember" name="remember" style="width:auto;">
                    <label for="remember" style="margin:0; font-weight:500;">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <p class="muted" style="margin-top:18px; text-align:center;">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai siswa</a>
            </p>
        </div>
    </div>
</div>
@endsection
