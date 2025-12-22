@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 text-gray-800">Detail Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <img src="{{ $product->primaryImage?->image_url }}" class="img-fluid rounded mb-3">

                <div class="row g-2">
                    @foreach($product->images as $image)
                    <div class="col-4">
                        <img src="{{ $image->image_url }}" class="img-fluid rounded">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="fw-bold">{{ $product->name }}</h4>
                <p class="text-muted mb-1">{{ $product->category->name }}</p>

                <h5 class="text-primary">
                    Rp {{ number_format($product->price) }}
                </h5>

                <p class="mt-3">{{ $product->description ?? '-' }}</p>

                <hr>

                <ul class="list-unstyled">
                    <li><strong>Stok:</strong> {{ $product->stock }}</li>
                    <li><strong>Status:</strong>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection