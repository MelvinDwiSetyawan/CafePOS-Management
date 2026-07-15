<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\TableModel;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Transaction::where('status', 'paid')->whereDate('created_at', today())->sum('grand_total');
        $weeklyRevenue = Transaction::where('status', 'paid')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('grand_total');
        $monthlyRevenue = Transaction::where('status', 'paid')->whereMonth('created_at', now()->month)->sum('grand_total');

        $totalMenus = Menu::count();
        $totalCategories = Category::count();
        $totalTables = TableModel::count();
        $totalKasir = User::whereHas('role', fn($q) => $q->where('name', 'kasir'))->count();
        $totalTransactions = Transaction::where('status', 'paid')->count();

        $topMenus = DB::table('transaction_details')
            ->join('menus', 'menus.id', '=', 'transaction_details.menu_id')
            ->select('menus.name', DB::raw('SUM(transaction_details.qty) as total_qty'))
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $lowStockMenus = Menu::where('stock', '<=', 10)->orderBy('stock')->limit(5)->get();

        $dailySales = Transaction::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $monthlySales = Transaction::where('status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'todayRevenue', 'weeklyRevenue', 'monthlyRevenue',
            'totalMenus', 'totalCategories', 'totalTables', 'totalKasir', 'totalTransactions',
            'topMenus', 'lowStockMenus', 'dailySales', 'monthlySales'
        ));
    }
}