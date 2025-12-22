@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 text-gray-800">Edit Produk</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->
                                category_id)==$category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stock" class="form-control"
                                value="{{ old('stock', $product->stock) }}">
                        </div>
                    </div>

                    {{-- Upload Gambar Baru --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tambah Gambar</label>
                        <input type="file" name="images[]" multiple class="form-control">
                    </div>
                </div>
            </div>

            {{-- Gambar Lama --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Gambar Produk</h5>

                    <div class="row g-3">
                        @foreach($product->images as $image)
                        <div class="col-md-3 text-center">
                            <img src="{{ $image->image_url }}" class="img-fluid rounded mb-2">

                            <div class="form-check">
                                <input type="radio" name="primary_image" value="{{ $image->id }}" {{ $image->is_primary
                                ? 'checked' : '' }}>
                                <label>Primary</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                <label>Hapus</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button class="btn btn-primary btn-lg w-100">Update Produk</button>
        </form>
    </div>
</div>
@endsection