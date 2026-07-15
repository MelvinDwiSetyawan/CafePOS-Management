@extends('layouts.app')

@section('title', 'Edit Meja')

@section('content')
<h3 class="mb-3">Edit Meja</h3>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tables.update', $table) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nomor Meja</label>
                <input type="text" name="table_number" value="{{ old('table_number', $table->table_number) }}" class="form-control @error('table_number') is-invalid @enderror">
                @error('table_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="capacity" value="{{ old('capacity', $table->capacity) }}" class="form-control @error('capacity') is-invalid @enderror">
                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="available" {{ old('status', $table->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ old('status', $table->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ old('status', $table->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection