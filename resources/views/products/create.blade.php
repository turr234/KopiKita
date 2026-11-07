@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                        <strong class="mb-0">Whoops!</strong>&nbsp;There were some problems with your input.
                    </div>
                    <ul class="mb-0 ps-4 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Formulir --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h5 mb-0 fw-bold text-dark">Add New Product</h2>
                        <small class="text-muted">Lengkapi spesifikasi produk, harga, dan ketersediaan stok</small>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Bagian 1: Informasi Utama --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-box-open me-1"></i> Informasi Produk</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small text-secondary"><strong>Name:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="sku" class="form-label fw-semibold small text-secondary"><strong>SKU:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="sku" name="sku" 
                                       class="form-control text-uppercase @error('sku') is-invalid @enderror" 
                                       value="{{ old('sku') }}" placeholder="PRD-001" required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="slug" class="form-label fw-semibold small text-secondary"><strong>Slug URL:</strong></label>
                                <input type="text" id="slug" name="slug" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       value="{{ old('slug') }}" placeholder="nama-produk">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin" class="form-label fw-semibold small text-secondary"><strong>Origin:</strong></label>
                                <input type="text" id="origin" name="origin" 
                                       class="form-control @error('origin') is-invalid @enderror" 
                                       value="{{ old('origin') }}" placeholder="Asal produk">
                                @error('origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tasting_notes" class="form-label fw-semibold small text-secondary"><strong>Tasting Notes:</strong></label>
                                <input type="text" id="tasting_notes" name="tasting_notes" 
                                       class="form-control @error('tasting_notes') is-invalid @enderror" 
                                       value="{{ old('tasting_notes') }}" placeholder="Karakteristik rasa">
                                @error('tasting_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="detail" class="form-label fw-semibold small text-secondary"><strong>Detail:</strong></label>
                                <textarea id="detail" name="detail" rows="4" style="height:120px"
                                          class="form-control @error('detail') is-invalid @enderror" 
                                          placeholder="Detail produk...">{{ old('detail') }}</textarea>
                                @error('detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold small text-secondary"><strong>Description:</strong> <span class="text-danger">*</span></label>
                                <textarea id="description" name="description" rows="5" style="height:150px"
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Deskripsi lengkap produk..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 2: Harga & Manajemen Stok --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-tags me-1"></i> Harga & Inventaris</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="price" class="form-label fw-semibold small text-secondary"><strong>Harga Normal:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="price" name="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" placeholder="0" min="0" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="discount_price" class="form-label fw-semibold small text-secondary"><strong>Harga Diskon:</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="discount_price" name="discount_price" 
                                           class="form-control @error('discount_price') is-invalid @enderror" 
                                           value="{{ old('discount_price') }}" placeholder="0" min="0">
                                </div>
                                @error('discount_price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="stock" class="form-label fw-semibold small text-secondary"><strong>Stok:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="stock" name="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', 0) }}" min="0" required>
                                    <span class="input-group-text small">Unit</span>
                                </div>
                                @error('stock')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="weight" class="form-label fw-semibold small text-secondary"><strong>Berat:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="weight" name="weight" 
                                           class="form-control @error('weight') is-invalid @enderror" 
                                           value="{{ old('weight') }}" placeholder="0" min="1" required>
                                    <span class="input-group-text small">Gram</span>
                                </div>
                                @error('weight')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 3: Media & Pengaturan Status --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-image me-1"></i> Media & Visibilitas</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="main_image" class="form-label fw-semibold small text-secondary"><strong>Foto Utama:</strong></label>
                                <input type="file" id="main_image" name="main_image" 
                                       class="form-control @error('main_image') is-invalid @enderror" 
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <div class="form-text small">Format: JPG, PNG, WEBP (Maks 2MB)</div>
                                @error('main_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="is_featured" class="form-label fw-semibold small text-secondary"><strong>Featured:</strong></label>
                                <select id="is_featured" name="is_featured" class="form-select @error('is_featured') is-invalid @enderror">
                                    <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>Biasa</option>
                                    <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Unggulan</option>
                                </select>
                                @error('is_featured')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="is_active" class="form-label fw-semibold small text-secondary"><strong>Status Aktif:</strong></label>
                                <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="sold_count" class="form-label fw-semibold small text-secondary"><strong>Penjualan Awal:</strong></label>
                                <input type="number" id="sold_count" name="sold_count" 
                                       class="form-control @error('sold_count') is-invalid @enderror" 
                                       value="{{ old('sold_count', 0) }}" min="0">
                                @error('sold_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-center gap-2 mt-4 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Footer Credit --}}
            <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>

        </div>
    </div>
</div>
@endsection