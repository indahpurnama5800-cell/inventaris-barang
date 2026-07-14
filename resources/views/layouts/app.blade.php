<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Inventaris Barang')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <style>
        :root {
            --brand-green: #15803D;
            --brand-green-dark: #14532D;
            --brand-yellow: #EAB308;
            --brand-yellow-dark: #A16207;
        }
        body { background: #FAFAF5; font-family: 'Segoe UI', system-ui, sans-serif; }
        .navbar-brand-custom { background: var(--brand-green); }
        .btn-brand { background: var(--brand-green); border-color: var(--brand-green); color: #fff; }
        .btn-brand:hover { background: var(--brand-green-dark); border-color: var(--brand-green-dark); color: #fff; }
        .btn-brand-accent { background: var(--brand-yellow); border-color: var(--brand-yellow); color: #422006; font-weight: 500; }
        .btn-brand-accent:hover { background: var(--brand-yellow-dark); border-color: var(--brand-yellow-dark); color: #fff; }
        .nav-link.active-brand { color: #fff !important; font-weight: 600; border-bottom: 2px solid var(--brand-yellow); }
        .card-accent-top { border-top: 4px solid var(--brand-green); }
        .badge-role-bos { background: var(--brand-green); }
        .badge-role-karyawan { background: var(--brand-yellow); color: #422006; }
        a { color: var(--brand-green-dark); }
        .table thead { background: #F0FDF4; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--brand-green);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🌿 Inventaris Barang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active-brand' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('items.*') ? 'active-brand' : '' }}" href="{{ route('items.index') }}">Barang</a></li>
                    @if (auth()->user()->isBos())
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('categories.*') ? 'active-brand' : '' }}" href="{{ route('categories.index') }}">Kategori</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active-brand' : '' }}" href="{{ route('suppliers.index') }}">Supplier</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('transactions.*') ? 'active-brand' : '' }}" href="{{ route('transactions.index') }}">Transaksi</a></li>
                    @if (auth()->user()->isBos())
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active-brand' : '' }}" href="{{ route('audit-logs.index') }}">Audit Log</a></li>
                    @endif
                </ul>
                <ul class="navbar-nav align-items-lg-center">
                    {{-- Notifikasi stok menipis --}}
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                            🔔
                            @if (($lowStockNotifCount ?? 0) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:10px;">
                                    {{ $lowStockNotifCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                            <li><h6 class="dropdown-header">⚠️ Peringatan Stok Menipis</h6></li>
                            @forelse (($lowStockNotifItems ?? []) as $notifItem)
                                <li>
                                    <a class="dropdown-item small" href="{{ route('items.edit', $notifItem) }}">
                                        {{ $notifItem->name }} —
                                        <span class="{{ $notifItem->stock <= 0 ? 'text-danger fw-bold' : 'text-warning-emphasis fw-bold' }}">
                                            {{ $notifItem->stock <= 0 ? 'Stok Habis' : 'Sisa '.$notifItem->stock }}
                                        </span>
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text small text-muted">Tidak ada barang menipis 👍</span></li>
                            @endforelse
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name ?? 'Pengguna' }}
                            <span class="badge {{ auth()->user()->isBos() ? 'badge-role-bos' : 'badge-role-karyawan' }} ms-1" style="font-size:10px;">
                                {{ ucfirst(auth()->user()->role ?? '') }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
