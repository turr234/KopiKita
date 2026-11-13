@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Item Pesanan</h1>
            <p class="text-muted small mb-0">Perbarui rincian produk pada transaksi pesanan</p>
        </div>
        <a href="{{ route('order_items.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('order_items.update', $order_item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Pesanan (Order ID) <span class="text-danger">*</span></label>
                        <input type="text" name="order_id" class="form-control" value="{{ old('order_id', $order_item->order_id) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Produk (Product ID) <span class="text-danger">*</span></label>
                        <input type="text" name="product_id" class="form-control" value="{{ old('product_id', $order_item->product_id) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $order_item->product_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">SKU Produk</label>
                        <input type="text" name="product_sku" class="form-control" value="{{ old('product_sku', $order_item->product_sku) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Harga Satuan <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $order_item->price) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Kuantitas <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $order_item->quantity) }}" min="1" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Subtotal <span class="text-danger">*</span></label>
                        <input type="number" name="subtotal" class="form-control" value="{{ old('subtotal', $order_item->subtotal) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Foto Produk</label>
                    @if($order_item->product_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $order_item->product_image) }}" alt="{{ $order_item->product_name }}" class="img-thumbnail" style="max-height: 80px;">
                        </div>
                    @endif
                    <input type="file" name="product_image" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto produk.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('order_items.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
