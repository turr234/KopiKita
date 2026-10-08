@extends('layout')
@section('content')
    <a href="{{ route('reviews.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>User id</label>
            <input type="text" name="user_id" class="form_control" value="{{ $review->user_id }}">
        </div>
        <div class="mb-3">
            <label>Product id</label>
            <input type="text" name="product_id" class="form_control" value="{{ $review->product_id }}">
        </div>
        <div class="mb-3">
            <label>Order item id</label>
            <input type="text" name="order_item_id" class="form_control" value="{{ $review->order_item_id }}">
        </div>
        <div class="mb-3">
            <label>Rating</label>
            <input type="text" name="rating" class="form_control" value="{{ $review->rating }}">
        </div>
        <div class="mb-3">
            <label>Review</label>
            <input type="text" name="review" class="form_control" value="{{ $review->review }}">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="text" name="image" class="form_control" value="{{ $review->image }}">
        </div>
        <div class="mb-3">
            <label>Is visible</label>
            <input type="text" name="is_visible" class="form_control" value="{{ $review->is_visible }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection