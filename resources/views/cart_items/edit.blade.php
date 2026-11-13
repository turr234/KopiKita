@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Item Keranjang</h1>
            <p class="text-muted small mb-0">Perbarui item keranjang belanja</p>
        </div>
        <a href="{{ route('cart_items.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('cart_items.update', $cart_item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Keranjang (Cart ID) <span class="text-danger">*</span></label>
                    <input type="text" name="cart_id" class="form-control" value="{{ old('cart_id', $cart_item->cart_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Produk (Product ID) <span class="text-danger">*</span></label>
                    <input type="text" name="product_id" class="form-control" value="{{ old('product_id', $cart_item->product_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah (Quantity) <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $cart_item->quantity) }}" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Harga Satuan (Price) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $cart_item->price) }}" min="0" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('cart_items.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
