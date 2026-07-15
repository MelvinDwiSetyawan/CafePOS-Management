@extends('layouts.app')

@section('title', 'Tambah Meja')

@section('content')
<h3 class="mb-3">Tambah Meja</h3>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nomor Meja</label>
                <input type="text" name="table_number" value="{{ old('table_number') }}" class="form-control @error('table_number') is-invalid @enderror" placeholder="Contoh: A1, B2, VIP1">
                @error('table_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control @error('capacity') is-invalid @enderror" placeholder="Jumlah orang">
                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection