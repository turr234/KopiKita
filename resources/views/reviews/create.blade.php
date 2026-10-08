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

                {{-- Card Form --}}
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Tambah Ulasan Produk</h5>
                            <small class="text-muted">Formulir penilaian, ulasan pelanggan, dan kelayakan tampil</small>
                        </div>
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Bagian 1: Referensi Relasi --}}
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-link-45deg me-1"></i> Data Referensi
                            </h6>

                            <div class="row g-3 mb-4">
                                {{-- User ID --}}
                                <div class="col-md-4">
                                    <label for="user_id" class="form-label fw-semibold small text-secondary">
                                        User ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="user_id" name="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Pilih User
                                        </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Product ID --}}
                                <div class="col-md-4">
                                    <label for="product_id" class="form-label fw-semibold small text-secondary">
                                        Product ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="product_id" name="product_id"
                                        class="form-select @error('product_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>Pilih
                                            Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Order Item ID --}}
                                <div class="col-md-4">
                                    <label for="order_item_id" class="form-label fw-semibold small text-secondary">
                                        Order Item ID
                                    </label>
                                    <select id="order_item_id" name="order_item_id"
                                        class="form-select @error('order_item_id') is-invalid @enderror">
                                        <option value="" selected>Pilih Item Order (Opsional)</option>
                                        @foreach ($order_items as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('order_item_id') == $item->id ? 'selected' : '' }}>
                                                Order #{{ $item->order_id }} -
                                                {{ $item->product->name ?? 'Produk Tidak Diketahui' }}
                                                (x{{ $item->quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_item_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Bagian 2: Isi Ulasan & Rating --}}
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-star me-1"></i> Konten Penilaian
                            </h6>

                            <div class="row g-3 mb-4">
                                {{-- Rating --}}
                                <div class="col-md-6">
                                    <label for="rating" class="form-label fw-semibold small text-secondary">
                                        Rating Bintang <span class="text-danger">*</span>
                                    </label>
                                    <select id="rating" name="rating"
                                        class="form-select @error('rating') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('rating') ? '' : 'selected' }}>Pilih Bintang
                                            (1 - 5)</option>
                                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 - Sangat
                                            Puas)</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 - Puas)
                                        </option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 - Cukup)
                                        </option>
                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2 - Kurang
                                            Puas)</option>
                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1 - Sangat
                                            Buruk)</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Visibilitas --}}
                                <div class="col-md-6">
                                    <label for="is_visible" class="form-label fw-semibold small text-secondary">
                                        Visibilitas Ulasan <span class="text-danger">*</span>
                                    </label>
                                    <select id="is_visible" name="is_visible"
                                        class="form-select @error('is_visible') is-invalid @enderror" required>
                                        <option value="1" {{ old('is_visible', '1') == '1' ? 'selected' : '' }}>
                                            Tampilkan ke Publik</option>
                                        <option value="0" {{ old('is_visible') == '0' ? 'selected' : '' }}>Sembunyikan
                                            (Moderasi)</option>
                                    </select>
                                    @error('is_visible')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Teks Ulasan --}}
                                <div class="col-12">
                                    <label for="review" class="form-label fw-semibold small text-secondary">
                                        Teks Ulasan / Komentar <span class="text-danger">*</span>
                                    </label>
                                    <textarea id="review" name="review" rows="3" class="form-control @error('review') is-invalid @enderror"
                                        placeholder="Tuliskan ulasan atau pengalaman penggunaan produk..." required>{{ old('review') }}</textarea>
                                    @error('review')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Lampiran Gambar --}}
                                <div class="col-12">
                                    <label for="image" class="form-label fw-semibold small text-secondary">Foto Lampiran
                                        Ulasan</label>
                                    <input type="file" id="image" name="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    <div class="form-text small">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('reviews.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
