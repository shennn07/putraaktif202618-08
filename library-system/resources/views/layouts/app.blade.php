<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') — Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark"></span>
                Perpustakaan Digital
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('books.index') }}" class="{{ request()->is('books*') ? 'active' : '' }}">Katalog Buku</a></li>
                @auth
                    @if (auth()->user()->isStudent())
                        <li><a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('history.index') }}" class="{{ request()->is('history*') ? 'active' : '' }}">Riwayat</a></li>
                    @else
                        <li><a href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                    @endif
                    <li class="nav-user">Halo, {{ auth()->user()->name }}</li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a></li>
                    <li><a href="{{ route('register') }}" class="{{ request()->is('register') ? 'active' : '' }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <main class="page">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Periksa kembali isian Anda:</strong>
                    <ul style="margin:6px 0 0 18px; padding:0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Sistem Informasi Perpustakaan Digital — dibangun dengan Laravel.
        </div>
    </footer>
</body>
</html>
