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
                        <h2 class="h5 mb-0 fw-bold text-dark">Edit Product</h2>
                        <small class="text-muted">Perbarui spesifikasi produk, harga, dan ketersediaan stok</small>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Bagian 1: Informasi Utama --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-box-open me-1"></i> Informasi Produk</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small text-secondary"><strong>Name:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" placeholder="Name"
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label for="sku" class="form-label fw-semibold small text-secondary"><strong>SKU:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="sku" name="sku" 
                                       class="form-control text-uppercase @error('sku') is-invalid @enderror" 
                                       value="{{ old('sku', $product->sku) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label for="slug" class="form-label fw-semibold small text-secondary"><strong>Slug URL:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="slug" name="slug" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       value="{{ old('slug', $product->slug) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="origin" class="form-label fw-semibold small text-secondary"><strong>Origin:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="origin" name="origin" 
                                       class="form-control @error('origin') is-invalid @enderror" 
                                       value="{{ old('origin', $product->origin) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="tasting_notes" class="form-label fw-semibold small text-secondary"><strong>Tasting Notes:</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="tasting_notes" name="tasting_notes" 
                                       class="form-control @error('tasting_notes') is-invalid @enderror" 
                                       value="{{ old('tasting_notes', $product->tasting_notes) }}" required>
                            </div>

                            <div class="col-12">
                                <label for="detail" class="form-label fw-semibold small text-secondary"><strong>Detail:</strong> <span class="text-danger">*</span></label>
                                <textarea id="detail" name="detail" rows="5" style="height:150px" placeholder="Detail"
                                          class="form-control @error('detail') is-invalid @enderror" required>{{ old('detail', $product->detail) }}</textarea>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 2: Harga & Manajemen Stok --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-tags me-1"></i> Harga & Inventaris</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="price" class="form-label fw-semibold small text-secondary"><strong>Price:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" step="any" id="price" name="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $product->price) }}" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="discount_price" class="form-label fw-semibold small text-secondary"><strong>Discount Price:</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" step="any" id="discount_price" name="discount_price" 
                                           class="form-control @error('discount_price') is-invalid @enderror" 
                                           value="{{ old('discount_price', $product->discount_price) }}" min="0">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="stock" class="form-label fw-semibold small text-secondary"><strong>Stock:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="stock" name="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', $product->stock) }}" min="0" required>
                                    <span class="input-group-text small">Unit</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="weight" class="form-label fw-semibold small text-secondary"><strong>Weight:</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="any" id="weight" name="weight" 
                                           class="form-control @error('weight') is-invalid @enderror" 
                                           value="{{ old('weight', $product->weight) }}" min="1" required>
                                    <span class="input-group-text small">Gram/Kg</span>
                                </div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 3: Media & Pengaturan Status --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-image me-1"></i> Media & Visibilitas</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="main_image" class="form-label fw-semibold small text-secondary"><strong>Main Image (URL / Path):</strong> <span class="text-danger">*</span></label>
                                <input type="text" id="main_image" name="main_image" 
                                       class="form-control @error('main_image') is-invalid @enderror" 
                                       value="{{ old('main_image', $product->main_image) }}" required>
                            </div>

                            <div class="col-md-2">
                                <label for="is_featured" class="form-label fw-semibold small text-secondary"><strong>Is Featured:</strong></label>
                                <select id="is_featured" name="is_featured" class="form-select @error('is_featured') is-invalid @enderror">
                                    <option value="0" {{ old('is_featured', $product->is_featured) == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_featured', $product->is_featured) == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="is_active" class="form-label fw-semibold small text-secondary"><strong>Is Active:</strong></label>
                                <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="sold_count" class="form-label fw-semibold small text-secondary"><strong>Sold Count:</strong></label>
                                <input type="number" id="sold_count" name="sold_count" 
                                       class="form-control @error('sold_count') is-invalid @enderror" 
                                       value="{{ old('sold_count', $product->sold_count ?? 0) }}" min="0">
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
            <p class="text-center text-primary mt-3"><small>Tutorial by ItSolutionStuff.com</small></p>

        </div>
    </div>
</div>
@endsection