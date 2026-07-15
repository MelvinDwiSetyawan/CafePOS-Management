@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h3 class="mb-1">Selamat datang, {{ auth()->user()->name }}</h3>
        <p class="text-light mb-0">Ringkasan performa dan laporan terbaru usaha kafe Anda.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-text me-1"></i> Laporan Lengkap
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            <i class="bi bi-speedometer2 me-1"></i> Dashboard
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-uppercase text-muted small mb-1">Pendapatan Hari Ini</p>
                        <h4 class="mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-pill">Realtime</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-uppercase text-muted small mb-1">Pendapatan Minggu Ini</p>
                        <h4 class="mb-0">Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</h4>
                    </div>
                    <span class="badge bg-success rounded-pill">Stabil</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-uppercase text-muted small mb-1">Pendapatan Bulan Ini</p>
                        <h4 class="mb-0">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h4>
                    </div>
                    <span class="badge bg-info rounded-pill">Trend</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-2">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <p class="text-uppercase text-muted small mb-2">Menu</p>
                <h4>{{ $totalMenus }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <p class="text-uppercase text-muted small mb-2">Kategori</p>
                <h4>{{ $totalCategories }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <p class="text-uppercase text-muted small mb-2">Meja</p>
                <h4>{{ $totalTables }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <p class="text-uppercase text-muted small mb-2">Kasir</p>
                <h4>{{ $totalKasir }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <p class="text-uppercase text-muted small mb-2">Total Transaksi</p>
                <h4>{{ $totalTransactions }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Grafik Penjualan Harian</h6>
                    <small class="text-muted">7 hari terakhir</small>
                </div>
                <canvas id="chartDaily" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Grafik Penjualan Bulanan</h6>
                    <small class="text-muted">6 bulan terakhir</small>
                </div>
                <canvas id="chartMonthly" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="mb-3">Menu Terlaris</h6>
                <ul class="list-group list-group-flush">
                    @forelse($topMenus as $menu)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $menu->name }}
                            <span class="badge bg-primary rounded-pill">{{ $menu->total_qty }} terjual</span>
                        </li>
                    @empty
                        <li class="list-group-item">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="mb-3">Produk Hampir Habis</h6>
                <ul class="list-group list-group-flush">
                    @forelse($lowStockMenus as $menu)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $menu->name }}
                            <span class="badge bg-danger rounded-pill">Stok: {{ $menu->stock }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">Semua stok aman.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const dailyLabels = {!! json_encode($dailySales->pluck('date')) !!};
const dailyData = {!! json_encode($dailySales->pluck('total')) !!};

new Chart(document.getElementById('chartDaily'), {
    type: 'line',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Penjualan',
            data: dailyData,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.15)',
            fill: true,
            tension: 0.35,
            pointRadius: 3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: value => new Intl.NumberFormat('id-ID').format(value) } }
        }
    }
});

const monthlyLabels = {!! json_encode($monthlySales->pluck('month')) !!};
const monthlyData = {!! json_encode($monthlySales->pluck('total')) !!};

new Chart(document.getElementById('chartMonthly'), {
    type: 'bar',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Penjualan',
            data: monthlyData,
            backgroundColor: '#198754'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: value => new Intl.NumberFormat('id-ID').format(value) } }
        }
    }
});
</script>
@endpush