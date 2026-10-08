@extends('layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
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
                            <h5 class="mb-0 fw-bold text-dark">Tambah / Catat Pembayaran</h5>
                            <small class="text-muted">Input konfirmasi transfer, bukti bayar, dan status verifikasi</small>
                        </div>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Bagian 1: Referensi Transaksi --}}
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-receipt me-1"></i> Data Transaksi &
                                Pesanan</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="order_id" class="form-label fw-semibold small text-secondary">Order ID <span
                                            class="text-danger">*</span></label>
                                    <select id="order_id" name="order_id"
                                        class="form-select @error('order_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('order_id') ? '' : 'selected' }}>Pilih Order
                                            Id</option>
                                        @foreach ($order as $orders)
                                            <option value="{{ $orders->id }}"
                                                {{ old('order_id') == $orders->id ? 'selected' : '' }}>
                                                {{ $orders->id }} - {{ $orders->order_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="bank_account_id"
                                        class="form-label fw-semibold small text-secondary">Rekening Bank Tujuan</label>

                                    <select id="bank_account_id" name="bank_account_id"
                                        class="form-select @error('bank_account_id') is-invalid @enderror">
                                        <option value="">-- Pilih Rekening Tujuan --</option>
                                        @foreach ($bank_accounts as $account)
                                            <option value="{{ $account->id }}"
                                                {{ old('bank_account_id') == $account->id ? 'selected' : '' }}>
                                                {{ $account->bank_name }} - {{ $account->account_number }} (a.n
                                                {{ $account->account_name }})
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('bank_account_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="payment_code" class="form-label fw-semibold small text-secondary">Kode
                                        Pembayaran <span class="text-danger">*</span></label>
                                    <input type="text" id="payment_code" name="payment_code"
                                        class="form-control font-monospace text-uppercase @error('payment_code') is-invalid @enderror"
                                        value="{{ old('payment_code', 'PAY-' . strtoupper(Str::random(8))) }}" required>
                                    @error('payment_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Bagian 2: Informasi Pembayaran --}}
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-wallet2 me-1"></i> Detail Pembayaran</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="method" class="form-label fw-semibold small text-secondary">Metode
                                        Pembayaran <span class="text-danger">*</span></label>
                                    <select id="method" name="method"
                                        class="form-select @error('method') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('method') ? '' : 'selected' }}>Pilih Metode
                                        </option>
                                        <option value="bank_transfer"
                                            {{ old('method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="ewallet" {{ old('method') == 'ewallet' ? 'selected' : '' }}>E-Wallet
                                            / QRIS</option>
                                        <option value="cod" {{ old('method') == 'cod' ? 'selected' : '' }}>Cash on
                                            Delivery (COD)</option>
                                    </select>
                                    @error('method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="amount" class="form-label fw-semibold small text-secondary">Nominal Bayar
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text small">Rp</span>
                                        <input type="number" id="amount" name="amount"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            value="{{ old('amount') }}" placeholder="150000" min="0" required>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="sender_name" class="form-label fw-semibold small text-secondary">Nama
                                        Pengirim (Atas Nama)</label>
                                    <input type="text" id="sender_name" name="sender_name"
                                        class="form-control @error('sender_name') is-invalid @enderror"
                                        value="{{ old('sender_name') }}" placeholder="Contoh: Budi Santoso">
                                    @error('sender_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="sender_bank" class="form-label fw-semibold small text-secondary">Bank
                                        Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" id="sender_bank" name="sender_bank"
                                        class="form-control @error('sender_bank') is-invalid @enderror"
                                        value="{{ old('sender_bank') }}" placeholder="Contoh: BCA / BRI / Mandiri"
                                        required>
                                    @error('sender_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="proof_image" class="form-label fw-semibold small text-secondary">Unggah
                                        Bukti Transfer</label>
                                    <input type="file" id="proof_image" name="proof_image"
                                        class="form-control @error('proof_image') is-invalid @enderror" accept="image/*">
                                    <div class="form-text small">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</div>
                                    @error('proof_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Bagian 3: Verifikasi & Status --}}
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shield-check me-1"></i> Status &
                                Verifikasi</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-semibold small text-secondary">Status
                                        Pembayaran <span class="text-danger">*</span></label>
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending"
                                            {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending (Menunggu
                                            Verifikasi)</option>
                                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid
                                            (Diterima / Lunas)</option>
                                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected (Ditolak)</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="user_id" class="form-label fw-semibold small text-secondary">
                                        User ID <span class="text-danger">*</span>
                                    </label>
                                    <select id="user_id" name="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Pilih User
                                        </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="verified_at" class="form-label fw-semibold small text-secondary">Waktu
                                        Verifikasi</label>
                                    <input type="datetime-local" id="verified_at" name="verified_at"
                                        class="form-control @error('verified_at') is-invalid @enderror"
                                        value="{{ old('verified_at') }}">
                                    @error('verified_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="rejection_reason"
                                        class="form-label fw-semibold small text-secondary">Alasan Penolakan (Jika status
                                        ditolak)</label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="2"
                                        class="form-control @error('rejection_reason') is-invalid @enderror"
                                        placeholder="Contoh: Bukti transfer buram atau nominal tidak sesuai...">{{ old('rejection_reason') }}</textarea>
                                    @error('rejection_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('payments.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
