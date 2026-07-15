@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<h3 class="mb-3">Riwayat Transaksi</h3>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Meja</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->table->table_number }}</td>
                    <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('kasir.transactions.detail', $transaction) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
</div>
@endsection
