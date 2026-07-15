<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 4px 0; font-size: 12px; }
        .summary { margin-bottom: 20px; }
        .summary .item { margin-bottom: 4px; }
        .table-report { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-report th, .table-report td { border: 1px solid #ddd; padding: 8px; }
        .table-report th { background-color: #f4f4f4; font-weight: 700; }
        .table-report tbody tr:nth-child(odd) { background-color: #fbfbfb; }
        .footer { font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan CafePOS</h1>
        <p>Periode: {{ ucfirst($period) }} @if($period === 'custom' && $startDate && $endDate) ({{ $startDate }} sampai {{ $endDate }}) @endif</p>
    </div>

    <div class="summary">
        <div class="item"><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="item"><strong>Total Transaksi:</strong> {{ $totalTransactions }}</div>
    </div>

    <table class="table-report">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Meja</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->transaction_code }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->table->table_number }}</td>
                <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
