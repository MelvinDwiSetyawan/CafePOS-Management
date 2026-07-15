<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Transaction::with('user', 'table')->where('status', 'paid');

        match ($period) {
            'daily' => $query->whereDate('created_at', today()),
            'weekly' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'monthly' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'yearly' => $query->whereYear('created_at', now()->year),
            'custom' => $startDate && $endDate
                ? $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                : null,
            default => null,
        };

        $transactions = $query->latest()->paginate(15)->withQueryString();

        $totalRevenue = (clone $query)->sum('grand_total');
        $totalTransactions = (clone $query)->count();

        return view('admin.reports.index', compact('transactions', 'period', 'startDate', 'endDate', 'totalRevenue', 'totalTransactions'));
    }

    public function exportPdf(Request $request)
    {
        $period = $request->get('period', 'daily');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Transaction::with('user', 'table')->where('status', 'paid');

        match ($period) {
            'daily' => $query->whereDate('created_at', today()),
            'weekly' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'monthly' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'yearly' => $query->whereYear('created_at', now()->year),
            'custom' => $startDate && $endDate
                ? $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                : null,
            default => null,
        };

        $transactions = (clone $query)->latest()->get();
        $totalRevenue = (clone $query)->sum('grand_total');
        $totalTransactions = (clone $query)->count();

        return Pdf::loadView('pdf.reports', compact('transactions', 'period', 'startDate', 'endDate', 'totalRevenue', 'totalTransactions'))
            ->setPaper('a4', 'landscape')
            ->stream('laporan-penjualan-' . now()->format('Ymd') . '.pdf');
    }
}
