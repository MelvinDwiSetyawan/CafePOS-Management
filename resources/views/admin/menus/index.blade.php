@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen Menu</h3>
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Menu
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="table-menus" class="table table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $index => $menu)
                <tr>
                    <td>{{ $menus->firstItem() + $index }}</td>
                    <td>
                        @if($menu->photo)
                            <img src="{{ Storage::url($menu->photo) }}" alt="{{ $menu->name }}" width="50" height="50" class="rounded object-fit-cover">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->category->name }}</td>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>{{ $menu->stock }}</td>
                    <td>
                        @if($menu->status == 'active')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#table-menus').DataTable();

    $('.btn-delete').on('click', function() {
        const form = $(this).closest('.form-delete');

        Swal.fire({
            title: 'Yakin hapus menu ini?',
            text: 'Data yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush