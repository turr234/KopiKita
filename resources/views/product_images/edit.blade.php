@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Foto Produk</h1>
            <p class="text-muted small mb-0">Perbarui foto galeri produk kopi</p>
        </div>
        <a href="{{ route('product_images.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('product_images.update', $product_image->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Produk <span class="text-danger">*</span></label>
                    <input type="text" name="product_id" class="form-control" value="{{ old('product_id', $product_image->product_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Produk</label>
                    @if($product_image->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product_image->image) }}" alt="Foto Produk" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jadikan Foto Utama <span class="text-danger">*</span></label>
                    <select name="is_primary" class="form-select" required>
                        <option value="1" {{ old('is_primary', $product_image->is_primary) == '1' ? 'selected' : '' }}>Ya (Foto Utama)</option>
                        <option value="0" {{ old('is_primary', $product_image->is_primary) == '0' ? 'selected' : '' }}>Bukan (Foto Sekunder)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Urutan Tampilan (Sort Order) <span class="text-danger">*</span></label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product_image->sort_order) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('product_images.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
