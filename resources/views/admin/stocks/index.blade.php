@extends('layouts.app')

@section('title', 'Stok')

@section('content')
<h3 class="mb-3">Manajemen Stok</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->category->name ?? '-' }}</td>
                    <td>{{ $menu->stock ?? 0 }}</td>
                    <td>
                        <form action="{{ route('admin.stocks.store') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <select name="type" class="form-select" style="width:100px;">
                                <option value="in">Masuk</option>
                                <option value="out">Keluar</option>
                            </select>
                            <input type="number" name="qty" class="form-control" style="width:100px;" min="1" value="1">
                            <input type="text" name="note" class="form-control" placeholder="Keterangan" style="width:200px;">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $menus->links() }}
    </div>
</div>
@endsection
