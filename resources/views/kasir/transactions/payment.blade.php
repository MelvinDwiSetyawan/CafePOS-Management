@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<h3 class="mb-3">Pembayaran - {{ $transaction->transaction_code }}</h3>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Detail Pesanan</h5>
                <p>Meja: <strong>{{ $transaction->table->table_number }}</strong></p>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Menu</th><th>Qty</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->details as $detail)
                        <tr>
                            <td>{{ $detail->menu->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Diskon</span>
                    <span>Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Pajak</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Grand Total</span>
                    <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Pembayaran</h5>
                <form action="{{ route('kasir.transactions.process-payment', $transaction) }}" method="POST" id="form-payment">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="method" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="qris">QRIS</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal Bayar</label>
                        <input type="number" name="amount_paid" id="amount_paid" class="form-control" min="{{ $transaction->grand_total }}" required>
                    </div>

                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span>Kembalian</span>
                        <span id="change-display">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Selesaikan Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const grandTotal = {{ $transaction->grand_total }};

document.getElementById('amount_paid').addEventListener('input', function() {
    const paid = parseFloat(this.value) || 0;
    const change = paid - grandTotal;
    document.getElementById('change-display').textContent = 'Rp ' + Math.round(change < 0 ? 0 : change).toLocaleString('id-ID');
});

document.getElementById('form-payment').addEventListener('submit', function(e) {
    const paid = parseFloat(document.getElementById('amount_paid').value) || 0;
    if (paid < grandTotal) {
        e.preventDefault();
        Swal.fire('Nominal kurang', 'Nominal bayar tidak boleh kurang dari total tagihan.', 'warning');
    }
});
</script>
@endpush