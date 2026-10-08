@extends('layout')
@section('content')
    <a href="{{ route('order_items.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('order_items.update', $order_items->id) }}" method="post"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>Order id</label>
            <input type="text" name="order_id" class="form_control" value="{{ $order_items->order_id }}">
        </div>
        <div class="mb-3">
            <label>Product id</label>
            <input type="text" name="product_id" class="form_control" value="{{ $order_items->product_id }}">
        </div>
        <div class="mb-3">
            <label>Product name</label>
            <input type="text" name="product_name" class="form_control" value="{{ $order_items->product_name }}">
        </div>
        <div class="mb-3">
            <label>Product sku</label>
            <input type="text" name="product_sku" class="form_control" value="{{ $order_items->product_sku }}">
        </div>
        <div class="mb-3">
            <label>Product image</label>
            <input type="text" name="product_image" class="form_control" value="{{ $order_items->product_image }}">
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" class="form_control" value="{{ $order_items->price }}">
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="text" name="quantity" class="form_control" value="{{ $order_items->quantity }}">
        </div>
        <div class="mb-3">
            <label>Subtotal</label>
            <input type="text" name="subtotal" class="form_control" value="{{ $order_items->subtotal }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection