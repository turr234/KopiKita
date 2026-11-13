@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Riwayat Status Pesanan</h1>
            <p class="text-muted small mb-0">Perbarui log perubahan status transaksi pesanan</p>
        </div>
        <a href="{{ route('order_status_histories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('order_status_histories.update', $order_status_historie->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Pesanan (Order ID) <span class="text-danger">*</span></label>
                    <input type="text" name="order_id" class="form-control" value="{{ old('order_id', $order_status_historie->order_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Pesanan <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('status', $order_status_historie->status) == $val ? 'selected' : '' }}>{{ $lbl }} ({{ $val }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi / Catatan Perubahan <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $order_status_historie->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Diubah Oleh (Changed By)</label>
                    <input type="text" name="change_by" class="form-control" value="{{ old('change_by', $order_status_historie->change_by) }}">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('order_status_histories.index') }}" class="btn btn-light px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
