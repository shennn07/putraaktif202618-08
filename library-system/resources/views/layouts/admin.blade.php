<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <span class="brand-mark"></span>
                Panel Admin
            </a>
            <ul class="admin-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">Kelola Buku</a></li>
                <li><a href="{{ route('admin.borrowings.index') }}" class="{{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">Booking &amp; Peminjaman</a></li>
                <li class="section-label">Lainnya</li>
                <li><a href="{{ url('/') }}">Lihat Situs Utama</a></li>
            </ul>
        </aside>

        <div class="admin-main">
            <div class="admin-topbar">
                <div>@yield('title', 'Dashboard')</div>
                <div style="display:flex; align-items:center; gap:14px;">
                    <span class="muted" style="font-size:0.88rem;">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                    </form>
                </div>
            </div>

            <div class="admin-content">
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
        </div>
    </div>
</body>
</html>
