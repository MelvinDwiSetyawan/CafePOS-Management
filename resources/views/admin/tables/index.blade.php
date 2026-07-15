@extends('layouts.app')

@section('title', 'Meja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen Meja</h3>
    <a href="{{ route('admin.tables.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Meja
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="table-tables" class="table table-striped w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Meja</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $index => $table)
                <tr>
                    <td>{{ $tables->firstItem() + $index }}</td>
                    <td>{{ $table->table_number }}</td>
                    <td>{{ $table->capacity }} orang</td>
                    <td>
                        @if($table->status == 'available')
                            <span class="badge bg-success">Available</span>
                        @elseif($table->status == 'occupied')
                            <span class="badge bg-danger">Occupied</span>
                        @else
                            <span class="badge bg-warning text-dark">Reserved</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="d-inline form-delete">
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
    $('#table-tables').DataTable();

    $('.btn-delete').on('click', function() {
        const form = $(this).closest('.form-delete');

        Swal.fire({
            title: 'Yakin hapus meja ini?',
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