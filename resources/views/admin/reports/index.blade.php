@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Penjualan</h3>
        <p class="text-muted mb-0">Filter data transaksi untuk melihat pendapatan sesuai periode.</p>
    </div>
    <div>
        <a href="{{ route('admin.reports.pdf', request()->query()) }}" target="_blank" class="btn btn-pdf">
            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Periode</label>
                <select name="period" class="form-select" onchange="this.form.submit()">
                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                    <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>
            @if($period == 'custom')
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <div class="card-body p-0">
                <h6 class="text-muted mb-2">Total Pendapatan</h6>
                <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <div class="card-body p-0">
                <h6 class="text-muted mb-2">Total Transaksi</h6>
                <h3>{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Meja</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_code }}</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->table->table_number }}</td>
                        <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
