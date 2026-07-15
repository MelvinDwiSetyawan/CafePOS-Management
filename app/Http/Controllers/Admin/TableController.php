<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Table\StoreTableRequest;
use App\Http\Requests\Table\UpdateTableRequest;
use App\Models\TableModel;
use App\Helpers\ActivityLogger;

class TableController extends Controller
{
    public function index()
    {
        $tables = TableModel::latest()->paginate(10);

        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(StoreTableRequest $request)
    {
        $table = TableModel::create($request->validated());

        ActivityLogger::log('Tambah Meja', 'Menambahkan meja: ' . $table->table_number);

        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(TableModel $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(UpdateTableRequest $request, TableModel $table)
    {
        $table->update($request->validated());

        ActivityLogger::log('Edit Meja', 'Mengubah meja: ' . $table->table_number);

        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(TableModel $table)
    {
        ActivityLogger::log('Hapus Meja', 'Menghapus meja: ' . $table->table_number);

        $table->delete();

        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil dihapus.');
    }
}