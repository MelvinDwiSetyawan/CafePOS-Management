<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\TableModel;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Transaction::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('grand_total');

        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $activeTables = TableModel::where('status', 'occupied')->count();
        $activeMenus = Menu::where('status', 'active')->count();

        $topMenusToday = DB::table('transaction_details')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('menus', 'menus.id', '=', 'transaction_details.menu_id')
            ->where('transactions.status', 'paid')
            ->whereDate('transactions.created_at', today())
            ->select('menus.name', DB::raw('SUM(transaction_details.qty) as total_qty'))
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $recentTransactions = Transaction::with('table', 'payment')
            ->latest()
            ->limit(5)
            ->get();

        return view('kasir.dashboard', compact(
            'todayRevenue',
            'todayTransactions',
            'pendingTransactions',
            'activeTables',
            'activeMenus',
            'topMenusToday',
            'recentTransactions'
        ));
    }
}
