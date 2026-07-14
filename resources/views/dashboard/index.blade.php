@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h4 class="mb-3">Dashboard</h4>

@if ($outOfStockCount > 0 || $needRestockCount > 0)
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-2 mb-4">
        <span style="font-size:20px;">⚠️</span>
        <div>
            <strong>Peringatan Stok!</strong>
            @if ($outOfStockCount > 0)
                {{ $outOfStockCount }} barang <strong class="text-danger">stok habis</strong>@if($needRestockCount > 0), @endif
            @endif
            @if ($needRestockCount > 0)
                {{ $needRestockCount }} barang <strong>perlu direstock segera</strong>.
            @endif
            <a href="{{ route('items.index') }}" class="ms-2">Lihat semua data barang →</a>
        </div>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total Barang</div>
                <div class="fs-4 fw-bold">{{ number_format($totalItems) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Kategori</div>
                <div class="fs-4 fw-bold">{{ number_format($totalCategories) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Supplier</div>
                <div class="fs-4 fw-bold">{{ number_format($totalSuppliers) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Transaksi</div>
                <div class="fs-4 fw-bold">{{ number_format($totalTransactions) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
            <div class="card-body">
                <div class="text-muted small">Perlu Restock</div>
                <div class="fs-4 fw-bold text-warning">{{ $needRestockCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
            <div class="card-body">
                <div class="text-muted small">Stok Habis</div>
                <div class="fs-4 fw-bold text-danger">{{ $outOfStockCount }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title">Grafik Barang Masuk vs Keluar (30 Hari Terakhir)</h6>
                <canvas id="trendChart" height="90"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title">🔔 Pengingat Restock</h6>
                <div style="max-height: 280px; overflow-y: auto;">
                    @forelse ($restockItems as $item)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <div class="fw-medium small">{{ $item->name }}</div>
                                <div class="text-muted" style="font-size:11px;">Stok: {{ $item->stock }} {{ $item->unit }}</div>
                            </div>
                            <span class="badge {{ $item->restockPriorityBadgeClass() }}">Prioritas {{ ucfirst($item->restockPriority()) }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Semua stok aman 👍</p>
                    @endforelse
                </div>
                <a href="{{ route('items.index') }}" class="d-block text-center small mt-2">Lihat semua data barang →</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title">📦 Barang Terbaru</h6>
                @foreach ($latestItems as $item)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <div class="fw-medium small">{{ $item->name }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $item->code }} • {{ $item->category->name ?? '-' }}</div>
                        </div>
                        <span class="text-muted small">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title">🕒 Riwayat Aktivitas Pengguna</h6>
                <div style="max-height: 230px; overflow-y: auto;">
                    @forelse ($recentActivities as $log)
                        <div class="border-start border-3 border-secondary ps-2 py-1 mb-2 small">
                            <div>{{ $log->description }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $log->user_name }} • {{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Belum ada aktivitas.</p>
                    @endforelse
                </div>
                <a href="{{ route('audit-logs.index') }}" class="d-block text-center small mt-2">Lihat semua riwayat →</a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="card-title">🔮 Prediksi Kehabisan Stok &amp; Prioritas Restock</h6>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Rata-rata Keluar/Hari</th>
                        <th>Estimasi Habis</th>
                        <th>Prioritas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($atRiskItems as $item)
                        <tr>
                            <td>{{ $item->name }} <span class="text-muted small">({{ $item->code }})</span></td>
                            <td>{{ $item->stock }} {{ $item->unit }}</td>
                            <td>{{ $item->averageDailyUsage() }}</td>
                            <td>{{ $item->predictedDaysUntilStockout() !== null ? $item->predictedDaysUntilStockout().' hari' : '-' }}</td>
                            <td><span class="badge {{ $item->restockPriorityBadgeClass() }}">{{ ucfirst($item->restockPriority()) }}</span></td>
                            <td><a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-dark">Kelola</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada barang berisiko habis dalam waktu dekat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const trendData = @json($trend);
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: trendData.map(d => d.date),
        datasets: [
            { label: 'Masuk', data: trendData.map(d => d.masuk), borderColor: '#15803D', backgroundColor: '#15803D22', tension: 0.35, fill: true },
            { label: 'Keluar', data: trendData.map(d => d.keluar), borderColor: '#EAB308', backgroundColor: '#EAB30822', tension: 0.35, fill: true },
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
