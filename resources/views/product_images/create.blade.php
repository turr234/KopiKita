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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Foto Galeri Produk</h5>
                        <small class="text-muted">Unggah foto tambahan atau foto utama untuk katalog produk</small>
                    </div>
                    <a href="{{ route('product_images.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('product_images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Pilihan Produk --}}
                            <div class="col-12">
                                <label for="product_id" class="form-label fw-semibold small text-secondary">Pilih Produk <span class="text-danger">*</span></label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>-- Pilih Produk Terkait --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} (SKU: {{ $product->sku ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Upload Berkas Gambar --}}
                            <div class="col-12">
                                <label for="image" class="form-label fw-semibold small text-secondary">Berkas Foto <span class="text-danger">*</span></label>
                                <input type="file" id="image" name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*" required>
                                <div class="form-text small">Format: JPG, JPEG, PNG, WEBP (Rekomendasi rasio 1:1, maks 2MB)</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Utama (Primary) --}}
                            <div class="col-md-6">
                                <label for="is_primary" class="form-label fw-semibold small text-secondary">Jadikan Gambar Utama? <span class="text-danger">*</span></label>
                                <select id="is_primary" name="is_primary" class="form-select @error('is_primary') is-invalid @enderror" required>
                                    <option value="0" {{ old('is_primary', '0') == '0' ? 'selected' : '' }}>Bukan (Foto Galeri Tambahan)</option>
                                    <option value="1" {{ old('is_primary') == '1' ? 'selected' : '' }}>Ya (Foto Sampul Utama)</option>
                                </select>
                                @error('is_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Urutan Tampil (Sort Order) --}}
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label fw-semibold small text-secondary">Urutan Tampil (Sort Order)</label>
                                <input type="number" id="sort_order" name="sort_order" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       value="{{ old('sort_order', 0) }}" min="0" placeholder="0">
                                <div class="form-text small">Nilai lebih kecil tampil lebih awal</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('product_images.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection