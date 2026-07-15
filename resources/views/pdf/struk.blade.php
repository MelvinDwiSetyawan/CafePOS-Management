<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 16px;
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
        }

        .info,
        .totals {
            width: 100%;
            margin-bottom: 12px;
        }

        .info td,
        .totals td {
            padding: 4px 0;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .items th,
        .items td {
            border-bottom: 1px solid #ddd;
            padding: 6px 4px;
            text-align: left;
        }

        .items th {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 8px;
        }

        .summary p {
            margin: 2px 0;
        }

        .footer {
            margin-top: 16px;
            text-align: center;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Struk Pembayaran</h1>
            <p>CafePOS</p>
        </div>

        <table class="info">
            <tr>
                <td><strong>No. Transaksi:</strong></td>
                <td class="text-right">{{ $transaction->transaction_code }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal:</strong></td>
                <td class="text-right">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Kasir:</strong></td>
                <td class="text-right">{{ $transaction->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Meja:</strong></td>
                <td class="text-right">{{ $transaction->table->table_number }}</td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->menu->name }}</td>
                        <td class="text-right">{{ $detail->qty }}</td>
                        <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p><strong>Subtotal:</strong> Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</p>
            <p><strong>Diskon:</strong> Rp {{ number_format($transaction->discount, 0, ',', '.') }}</p>
            <p><strong>Pajak:</strong> Rp {{ number_format($transaction->tax, 0, ',', '.') }}</p>
            <p><strong>Grand Total:</strong> Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
            <p><strong>Metode Bayar:</strong> {{ strtoupper($transaction->payment->method) }}</p>
            <p><strong>Dibayar:</strong> Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</p>
            <p><strong>Kembalian:</strong> Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</p>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>
</html>
