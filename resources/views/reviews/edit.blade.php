@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Ulasan Produk</h1>
            <p class="text-muted small mb-0">Moderasi ulasan dan rating produk KopiKita</p>
        </div>
        <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Produk <span class="text-danger">*</span></label>
                        <input type="text" name="product_id" class="form-control" value="{{ old('product_id', $review->product_id) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Item Pesanan <span class="text-danger">*</span></label>
                        <input type="text" name="order_item_id" class="form-control" value="{{ old('order_item_id', $review->order_item_id) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Rating (Bintang 1 - 5) <span class="text-danger">*</span></label>
                    <select name="rating" class="form-select" required>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>{{ $i }} Bintang ⭐</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Ulasan <span class="text-danger">*</span></label>
                    <textarea name="review" class="form-control" rows="3" required>{{ old('review', $review->review) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Lampiran Ulasan</label>
                    @if($review->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $review->image) }}" alt="Foto Ulasan" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto ulasan.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Tampilkan Ulasan di Web? <span class="text-danger">*</span></label>
                    <select name="is_visible" class="form-select" required>
                        <option value="1" {{ old('is_visible', $review->is_visible) == '1' ? 'selected' : '' }}>Ya (Tampilkan ke Publik)</option>
                        <option value="0" {{ old('is_visible', $review->is_visible) == '0' ? 'selected' : '' }}>Tidak (Sembunyikan)</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('reviews.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
