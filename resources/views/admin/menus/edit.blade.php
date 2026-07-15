@php use
Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<h3 class="mb-3">Edit Menu</h3>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Modal</label>
                    <input type="number" name="cost_price" value="{{ old('cost_price', $menu->cost_price) }}" class="form-control @error('cost_price') is-invalid @enderror">
                    @error('cost_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Menu</label>
                @if($menu->photo)
                    <div class="mb-2">
                        <img src="{{ Storage::url($menu->photo) }}" width="80" class="rounded">
                    </div>
                @endif
                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}" class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $menu->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $menu->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection