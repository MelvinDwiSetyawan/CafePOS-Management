@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h3 class="mb-1">Selamat datang, {{ auth()->user()->name }}</h3>
        <p class="text-light mb-0">Ringkasan operasional kasir untuk transaksi hari ini, meja aktif, dan menu terlaris.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('kasir.transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-bag-plus me-1"></i> Transaksi Baru
        </a>
        <a href="{{ route('kasir.dashboard') }}" class="btn btn-outline-light">
            <i class="bi bi-arrow-repeat me-1"></i> Segarkan
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-uppercase text-muted small mb-1">Pendapatan Hari Ini</p>
                <h4 class="mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-uppercase text-muted small mb-1">Transaksi Hari Ini</p>
                <h4 class="mb-0">{{ $todayTransactions }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-uppercase text-muted small mb-1">Transaksi Pending</p>
                <h4 class="mb-0">{{ $pendingTransactions }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-uppercase text-muted small mb-1">Meja Aktif</p>
                <h4 class="mb-0">{{ $activeTables }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="mb-3">Menu Aktif</h6>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Jumlah menu siap dijual</p>
                        <h4 class="mb-0">{{ $activeMenus }}</h4>
                    </div>
                    <i class="bi bi-ui-checks display-6 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="mb-3">Menu Terlaris Hari Ini</h6>
                <ul class="list-group list-group-flush">
                    @forelse($topMenusToday as $menu)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span>{{ $menu->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $menu->total_qty }} pcs</span>
                        </li>
                    @empty
                        <li class="list-group-item border-0 px-0 py-2">Belum ada penjualan hari ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Transaksi Terbaru</h6>
                    <small class="text-muted">5 terakhir</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Meja</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_code }}</td>
                                    <td>{{ $transaction->table->table_number }}</td>
                                    <td class="text-end">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'paid' ? 'success' : ($transaction->status === 'pending' ? 'warning text-dark' : 'secondary') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="mb-3">Info Cepat Kasir</h6>
                <p class="mb-2 text-muted">Gunakan panel ini untuk melihat status meja dan transaksi tanpa harus meninggalkan meja kerja.</p>
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 py-2 border-0">
                        <strong>Transaksi Pending:</strong>
                        <span class="float-end">{{ $pendingTransactions }}</span>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0">
                        <strong>Meja Terisi:</strong>
                        <span class="float-end">{{ $activeTables }}</span>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0">
                        <strong>Menu Aktif:</strong>
                        <span class="float-end">{{ $activeMenus }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
