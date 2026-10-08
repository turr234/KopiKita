@extends('layout')
@section('content')
    <a href="{{ route('product_images.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('product_images.update', $product_image->id) }}" method="post"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>Product id</label>
            <input type="text" name="product_id" class="form_control" value="{{ $product_image->product_id }}">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="text" name="image" class="form_control" value="{{ $product_image->image }}">
        </div>
        <div class="mb-3">
            <label>Is primary</label>
            <input type="text" name="is_primary" class="form_control" value="{{ $product_image->is_primary }}">
        </div>
        <div class="mb-3">
            <label>Sort order</label>
            <input type="text" name="sort_order" class="form_control" value="{{ $product_image->sort_order }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection