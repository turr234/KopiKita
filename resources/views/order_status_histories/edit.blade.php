@extends('layout')
@section('content')
    <a href="{{ route('order_status_histories.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('order_status_histories.update', $order_status_histories->id) }}" method="post"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>Order id</label>
            <input type="text" name="order_id" class="form_control" value="{{ $order_status_histories->order_id }}">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <input type="text" name="status" class="form_control" value="{{ $order_status_histories->status }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form_control" value="{{ $order_status_histories->description }}">
        </div>
        <div class="mb-3">
            <label>Change by</label>
            <input type="text" name="change_by" class="form_control" value="{{ $order_status_histories->change_by }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection