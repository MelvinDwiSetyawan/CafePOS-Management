@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<h3 class="mb-3">Transaksi Berhasil</h3>

<div class="card">
    <div class="card-body">
        <p><strong>No. Transaksi:</strong> {{ $transaction->transaction_code }}</p>
        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
        <p><strong>Meja:</strong> {{ $transaction->table->table_number }}</p>

        <table class="table table-sm">
            <thead>
                <tr><th>Menu</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->menu->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between"><span>Subtotal</span><span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between"><span>Diskon</span><span>Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between"><span>Pajak</span><span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between fw-bold fs-5"><span>Grand Total</span><span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span></div>

        <hr>

        <p><strong>Metode Bayar:</strong> {{ strtoupper($transaction->payment->method) }}</p>
        <p><strong>Dibayar:</strong> Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</p>

        <a href="{{ route('kasir.transactions.create') }}" class="btn btn-primary">Transaksi Baru</a>
        <a href="{{ route('kasir.transactions.print', $transaction) }}" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-printer"></i> Cetak Struk
        </a>
    </div>
</div>
@endsection