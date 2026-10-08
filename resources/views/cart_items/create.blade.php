@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <strong class="mb-0">Terdapat beberapa kesalahan pengisian:</strong>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Formulir --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Tambah Item Keranjang</h5>
                        <small class="text-muted">Masukkan produk ke dalam keranjang belanja pengguna</small>
                    </div>
                    <a href="{{ route('cart_items.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('cart_items.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- Cart ID --}}
                            AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                            <div class="col-md-6">
                                <label for="cart_id" class="form-label fw-semibold small text-secondary">Cart ID <span class="text-danger">*</span></label>
                                <input type="number" id="cart_id" name="cart_id" 
                                       class="form-control @error('cart_id') is-invalid @enderror" 
                                       value="{{ old('cart_id') }}" placeholder="Contoh: 1" min="1" required>
                                @error('cart_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Product ID / Pilihan Produk --}}
                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold small text-secondary">Produk <span class="text-danger">*</span></label>
                                @if(isset($products))
                                    <select id="product_id" name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>-- Pilih Produk --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="number" id="product_id" name="product_id" 
                                           class="form-control @error('product_id') is-invalid @enderror" 
                                           value="{{ old('product_id') }}" placeholder="Contoh: 15" min="1" required>
                                @endif
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kuantitas --}}
                            <div class="col-md-6">
                                <label for="quantity" class="form-label fw-semibold small text-secondary">Jumlah (Quantity) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="quantity" name="quantity" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           value="{{ old('quantity', 1) }}" min="1" required>
                                    <span class="input-group-text small">Pcs</span>
                                </div>
                                @error('quantity')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-semibold small text-secondary">Harga Satuan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="price" name="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" min="0" placeholder="50000" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('cart_items.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection