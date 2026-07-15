<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class StockController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->paginate(20);

        return view('admin.stocks.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'type' => 'required|in:in,correction',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $menuName = Menu::findOrFail($request->menu_id)->name;

        DB::transaction(function () use ($request) {
            $menu = Menu::findOrFail($request->menu_id);

            if ($request->type === 'in') {
                $menu->increment('stock', $request->qty);
            } else {
                $menu->update(['stock' => $request->qty]);
            }

            StockHistory::create([
                'menu_id' => $menu->id,
                'user_id' => auth()->id(),
                'type' => $request->type,
                'qty' => $request->qty,
                'note' => $request->note,
            ]);
        });

        ActivityLogger::log(
            $request->type === 'in' ? 'Tambah Stok' : 'Koreksi Stok',
            $menuName . ' - jumlah: ' . $request->qty
        );

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Stok berhasil diperbarui.');
    }
}
