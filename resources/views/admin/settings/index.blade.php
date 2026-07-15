@php
use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<h3 class="mb-3">Pengaturan Cafe</h3>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Cafe</label>
                <input type="text" name="cafe_name" value="{{ old('cafe_name', $setting->cafe_name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Logo</label>
                @if($setting->logo)
                    <div class="mb-2"><img src="{{ Storage::url($setting->logo) }}" width="80"></div>
                @endif
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $setting->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Pajak / PPN Default (%)</label>
                <input type="number" name="tax_percentage" value="{{ old('tax_percentage', $setting->tax_percentage) }}" class="form-control" step="0.01">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
