@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Produk</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Origin</label>
            <input type="text" name="origin" class="form-control" value="{{ old('origin', $product->origin) }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tasting Notes</label>
            <input type="text" name="tasting_notes" class="form-control"
                value="{{ old('tasting_notes', $product->tasting_notes) }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="any" name="price" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Discount Price</label>
                <input type="number" step="any" name="discount_price" class="form-control"
                    value="{{ old('discount_price', $product->discount_price) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}"
                    required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Weight (Gram / Kg)</label>
                <input type="number" step="any" name="weight" class="form-control"
                    value="{{ old('weight', $product->weight) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Sold Count</label>
                <input type="number" name="sold_count" class="form-control"
                    value="{{ old('sold_count', $product->sold_count ?? 0) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Main Image (URL / Path)</label>
            <input type="text" name="main_image" class="form-control"
                value="{{ old('main_image', $product->main_image) }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Is Featured</label>
                <select name="is_featured" class="form-select">
                    <option value="1" {{ old('is_featured', $product->is_featured) == 1 ? 'selected' : '' }}>Ya
                    </option>
                    <option value="0" {{ old('is_featured', $product->is_featured) == 0 ? 'selected' : '' }}>Tidak
                    </option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Is Active</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Nonaktif
                    </option>
                </select>
            </div>
        </div>

        <div class="mt-4 mb-5">
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </div>
    </form>
@endsection
