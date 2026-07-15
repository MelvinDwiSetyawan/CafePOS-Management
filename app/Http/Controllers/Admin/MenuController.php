<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.menus.create', compact('categories'));
    }

    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        $menu = Menu::create($data);

        ActivityLogger::log('Tambah Menu', 'Menambahkan menu: ' . $menu->name);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();

        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        $menu->update($data);
        ActivityLogger::log('Edit Menu', 'Mengubah menu: ' . $menu->name);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }
        ActivityLogger::log('Hapus Menu', 'Menghapus menu: ' . $menu->name);

        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}