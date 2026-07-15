@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<h3 class="mb-3">Dashboard Kasir</h3>
<p class="text-muted mb-4">Selamat datang, {{ auth()->user()->name }}!</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Transaksi Hari Ini</h6>
                <h3>{{ $todayTransactions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Pendapatan Hari Ini</h6>
                <h3>Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-center h-100">
                <a href="{{ route('kasir.transactions.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus"></i> Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Riwayat Transaksi Terakhir</h5>
            <a href="{{ route('kasir.transactions.history') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Meja</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Struk</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $trx)
                <tr>
                    <td>{{ $trx->transaction_code }}</td>
                    <td>{{ $trx->table->table_number }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('kasir.transactions.print', $trx) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection