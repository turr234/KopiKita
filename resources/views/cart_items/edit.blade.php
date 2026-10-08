@extends('layout')
@section('content')
    <a href="{{ route('cart_items.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('cart_items.update', $cart_items->id) }}" method="post"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>Cart id</label>
            <input type="text" name="card_id" class="form_control" value="{{ $cart_items->cart_id }}">
    </div>
    <div class="mb-3">
            <label>Product id</label>
            <input type="text" name="product_id" class="form_control" value="{{ $cart_items->product_id }}">
    </div>
    <div class="mb-3">
            <label>Quantity</label>
            <input type="text" name="quantity" class="form_control" value="{{ $cart_items->quantity }}">
    </div>
    <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" class="form_control" value="{{ $cart_items->price }}">
    </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection