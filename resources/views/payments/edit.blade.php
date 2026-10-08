@extends('layout')
@section('content')
    <a href="{{ route('payments.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('payments.update', $payments->id) }}" method="post"></form>
    @csrf
    @method('PUT')
     <div class="mb-3">
            <label>Order id</label>
            <input type="text" name="order_id" class="form_control" value="{{ $payments->order_id }}">
        </div>
        <div class="mb-3">
            <label>Bank account id</label>
            <input type="text" name="bank_account_id" class="form_control" value="{{ $payments->bank_account_id }}">
        </div>
        <div class="mb-3">
            <label>Payment code</label>
            <input type="text" name="payment_code" class="form_control" value="{{ $payments->payment_code }}">
        </div>
        <div class="mb-3">
            <label>Method</label>
            <input type="text" name="method" class="form_control" value="{{ $payments->method }}">
        </div>
        <div class="mb-3">
            <label>Sender name</label>
            <input type="text" name="sender_name" class="form_control" value="{{ $payments->sender_name }}">
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="text" name="amount" class="form_control" value="{{ $payments->amount }}">
        </div>
        <div class="mb-3">
            <label>Proof image</label>
            <input type="text" name="proof_iamge" class="form_control" value="{{ $payments->proof_iamge }}">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <input type="text" name="status" class="form_control" value="{{ $payments->status }}">
        </div>
        <div class="mb-3">
            <label>Rejection reason</label>
            <input type="text" name="rejection_reason" class="form_control" value="{{ $payments->rejection_reason }}">
        </div>
        <div class="mb-3">
            <label>Verified by</label>
            <input type="text" name="verified_by" class="form_control" value="{{ $payments->verified_by }}">
        </div>
        <div class="mb-3">
            <label>Verified at</label>
            <input type="text" name="verified_at" class="form_control" value="{{ $payments->verified_at }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection