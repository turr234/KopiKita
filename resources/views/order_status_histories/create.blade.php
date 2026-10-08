@extends('layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                {{-- Alert Error Global --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <strong class="mb-0">Terdapat beberapa kesalahan pengisian:</strong>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Card Formulir --}}
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Catat Riwayat Status Pesanan</h5>
                            <small class="text-muted">Perbarui progres tahapan pesanan beserta catatan log aktivitas</small>
                        </div>
                        <a href="{{ route('order_status_histories.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('order_status_histories.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                {{-- Order ID --}}
                                <div class="col-md-6">
                                    <label for="order_number" class="form-label fw-semibold small text-secondary">
                                        Order ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="order_id" name="order_id"
                                        class="form-select @error('order_number') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('order_id') ? '' : 'selected' }}>Pilih Order
                                            ID</option>
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->id }}"
                                                {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                                {{ $order->order_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Baru --}}
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold small text-secondary">
                                        Status Pesanan <span class="text-danger">*</span>
                                    </label>
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status
                                        </option>
                                        <option value="waiting_payment" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                            (Menunggu Pembayaran)</option>
                                        <option value="waiting_verification"
                                            {{ old('status') == 'processing' ? 'selected' : '' }}>
                                            Processing (Sedang Dikemas)</option>
                                        <option value="processing" {{ old('status') == 'shipped' ? 'selected' : '' }}>
                                            Shipped
                                            (Dalam Pengiriman)</option>
                                        <option value="packed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed (Selesai)</option>
                                        <option value="shipped" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled (Dibatalkan)</option>
                                        <option value="completed" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled (Dibatalkan)</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled (Dibatalkan)</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Diubah Oleh (Change By) --}}
                                <div class="col-12">
                                    <label for="changed_by" class="form-label fw-semibold small text-secondary">
                                        Diperbarui Oleh (User ID / Nama) <span class="text-danger">*</span>
                                    </label>
                                    <select id="changed_by" name="changed_by"
                                        class="form-select @error('changed_by') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('changed_by') ? '' : 'selected' }}>Pilih
                                            User
                                        </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('changed_by') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('changed_by')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi / Catatan Perubahan --}}
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold small text-secondary">
                                        Deskripsi / Keterangan Log
                                    </label>
                                    <textarea id="description" name="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Contoh: Paket telah diserahkan ke pihak ekspedisi JNE, resi telah terbit...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('order_status_histories.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Riwayat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
