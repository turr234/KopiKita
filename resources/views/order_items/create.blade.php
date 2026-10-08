@extends('layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
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
                            <h5 class="mb-0 fw-bold text-dark">Tambah Item Pesanan</h5>
                            <small class="text-muted">Input rincian snapshot produk yang dibeli pada pesanan pelanggan</small>
                        </div>
                        <a href="{{ route('order_items.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('order_items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Bagian 1: Referensi Relasi --}}
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-link-45deg me-1"></i> Data Referensi
                            </h6>

                            <div class="row g-3 mb-4">
                                {{-- Order ID --}}
                                <div class="col-md-6">
                                    <label for="order_id" class="form-label fw-semibold small text-secondary">
                                        Order ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="order_id" name="order_id" class="form-select @error('order_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('order_id') ? '' : 'selected' }}>Pilih Order</option>
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                                {{ $order->order_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Product ID --}}
                                <div class="col-md-6">
                                    <label for="product_id" class="form-label fw-semibold small text-secondary">
                                        Product ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="product_id" name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Bagian 2: Snapshot Produk --}}
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-box-seam me-1"></i> Detail Snapshot Produk
                            </h6>

                            <div class="row g-3 mb-4">
                                {{-- Nama Produk --}}
                                <div class="col-md-8">
                                    <label for="product_name" class="form-label fw-semibold small text-secondary">
                                        Nama Produk <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="product_name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        value="{{ old('product_name') }}" placeholder="Contoh: Kopi Arabika Gayo 250gr" required>
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- SKU Produk --}}
                                <div class="col-md-4">
                                    <label for="product_sku" class="form-label fw-semibold small text-secondary">SKU Produk</label>
                                    <select id="product_sku" name="product_sku" class="form-select @error('product_sku') is-invalid @enderror">
                                        <option value="" selected>Pilih SKU (Opsional)</option>
                                        @foreach ($product_sku as $sku)
                                            <option value="{{ $sku->id }}" {{ old('product_sku') == $sku->id ? 'selected' : '' }}>
                                                {{ $sku->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Foto Produk --}}
                                <div class="col-12">
                                    <label for="product_image" class="form-label fw-semibold small text-secondary">Foto Produk</label>
                                    <input type="file" id="product_image" name="product_image"
                                        class="form-control @error('product_image') is-invalid @enderror" accept="image/*">
                                    <div class="form-text small">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</div>
                                    @error('product_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Bagian 3: Harga & Perhitungan Subtotal --}}
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-calculator me-1"></i> Kuantitas & Harga
                            </h6>

                            <div class="row g-3">
                                {{-- Harga Satuan --}}
                                <div class="col-md-4">
                                    <label for="price" class="form-label fw-semibold small text-secondary">
                                        Harga Satuan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text small">Rp</span>
                                        <input type="number" id="price" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price', 0) }}" min="0" placeholder="75000" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jumlah (Quantity) --}}
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label fw-semibold small text-secondary">
                                        Jumlah (Quantity) <span class="text-danger">*</span>
                                    </label>
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

                                {{-- Subtotal --}}
                                <div class="col-md-4">
                                    <label for="subtotal" class="form-label fw-semibold small text-secondary">
                                        Subtotal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text small fw-bold">Rp</span>
                                        <input type="number" id="subtotal" name="subtotal"
                                            class="form-control fw-bold text-success @error('subtotal') is-invalid @enderror"
                                            value="{{ old('subtotal', 0) }}" min="0" required readonly>
                                    </div>
                                    <div class="form-text small" style="font-size: 0.72rem;">Otomatis dihitung (Harga × Qty)</div>
                                    @error('subtotal')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('order_items.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Perhitungan Otomatis Subtotal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');
            const qtyInput = document.getElementById('quantity');
            const subtotalInput = document.getElementById('subtotal');

            function calculateSubtotal() {
                const price = parseFloat(priceInput.value) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                subtotalInput.value = price * qty;
            }

            priceInput.addEventListener('input', calculateSubtotal);
            qtyInput.addEventListener('input', calculateSubtotal);
            calculateSubtotal();
        });
    </script>
@endsection