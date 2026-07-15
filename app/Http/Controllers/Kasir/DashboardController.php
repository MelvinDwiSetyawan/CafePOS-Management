<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $todayTransactions = Transaction::where('user_id', $userId)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->count();

        $todayRevenue = Transaction::where('user_id', $userId)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('grand_total');

        $recentTransactions = Transaction::with('table')
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->latest()
            ->limit(5)
            ->get();

        return view('kasir.dashboard', compact('todayTransactions', 'todayRevenue', 'recentTransactions'));
    }
}