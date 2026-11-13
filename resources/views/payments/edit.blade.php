@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Verifikasi & Edit Pembayaran</h1>
            <p class="text-muted small mb-0">Konfirmasi bukti transfer dan status pembayaran pelanggan</p>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Pesanan (Order ID) <span class="text-danger">*</span></label>
                        <input type="text" name="order_id" class="form-control" value="{{ old('order_id', $payment->order_id) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Rekening Bank Tujuan <span class="text-danger">*</span></label>
                        <input type="text" name="bank_account_id" class="form-control" value="{{ old('bank_account_id', $payment->bank_account_id) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Pembayaran <span class="text-danger">*</span></label>
                        <input type="text" name="payment_code" class="form-control" value="{{ old('payment_code', $payment->payment_code) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                        <input type="text" name="method" class="form-control" value="{{ old('method', $payment->method) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nama Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="sender_name" class="form-control" value="{{ old('sender_name', $payment->sender_name) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Bank Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="sender_bank" class="form-control" value="{{ old('sender_bank', $payment->sender_bank) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nominal Transfer (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status Verifikasi Pembayaran <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                            <option value="verified" {{ old('status', $payment->status) == 'verified' ? 'selected' : '' }}>Verified (Pembayaran Diterima / Sah)</option>
                            <option value="rejected" {{ old('status', $payment->status) == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak / Bukti Palsu)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Alasan Penolakan (Jika Ditolak)</label>
                        <input type="text" name="rejection_reason" class="form-control" value="{{ old('rejection_reason', $payment->rejection_reason) }}" placeholder="Contoh: Bukti transfer buram / nominal tidak sesuai">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Bukti Transfer</label>
                    @if($payment->proof_image)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Transfer" class="img-thumbnail" style="max-height: 120px;">
                            </a>
                        </div>
                    @endif
                    <input type="file" name="proof_image" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti bukti transfer.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Status Pembayaran
                    </button>
                    <a href="{{ route('payments.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
