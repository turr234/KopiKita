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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Rekening Bank</h5>
                        <small class="text-muted">Konfigurasi akun bank tujuan pembayaran transfer pembeli</small>
                    </div>
                    <a href="{{ route('bank_accounts.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('bank_accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Bank --}}
                            <div class="col-md-6">
                                <label for="bank_name" class="form-label fw-semibold small text-secondary">Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" id="bank_name" name="bank_name" 
                                       class="form-control @error('bank_name') is-invalid @enderror" 
                                       value="{{ old('bank_name') }}" placeholder="Contoh: Bank BCA / Mandiri / BRI" required>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Rekening --}}
                            <div class="col-md-6">
                                <label for="account_number" class="form-label fw-semibold small text-secondary">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" id="account_number" name="account_number" 
                                       class="form-control font-monospace @error('account_number') is-invalid @enderror" 
                                       value="{{ old('account_number') }}" placeholder="Contoh: 1234567890" required>
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Atas Nama Pemilik Rekening --}}
                            <div class="col-md-6">
                                <label for="account_holder" class="form-label fw-semibold small text-secondary">Atas Nama (Account Holder) <span class="text-danger">*</span></label>
                                <input type="text" id="account_holder" name="account_holder" 
                                       class="form-control @error('account_holder') is-invalid @enderror" 
                                       value="{{ old('account_holder') }}" placeholder="Contoh: PT Toko Kopi Indonesia" required>
                                @error('account_holder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Aktif --}}
                            <div class="col-md-6">
                                <label for="is_active" class="form-label fw-semibold small text-secondary">Status Rekening <span class="text-danger">*</span></label>
                                <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Tampil saat Checkout)</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Logo Bank --}}
                            <div class="col-12">
                                <label for="logo" class="form-label fw-semibold small text-secondary">Logo Bank</label>
                                <input type="file" id="logo" name="logo" 
                                       class="form-control @error('logo') is-invalid @enderror" 
                                       accept="image/*">
                                <div class="form-text small">Format: PNG, JPG, WEBP, SVG (Rekomendasi latar transparan, maks 2MB)</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Petunjuk Transfer (Instructions) --}}
                            <div class="col-12">
                                <label for="intructions" class="form-label fw-semibold small text-secondary">Petunjuk Transfer (Instructions)</label>
                                <textarea id="intructions" name="intructions" rows="3" 
                                          class="form-control @error('intructions') is-invalid @enderror" 
                                          placeholder="Contoh: Masukkan kode unik pada 3 digit terakhir atau cantumkan nomor pesanan pada berita transfer...">{{ old('instructions', old('intructions')) }}</textarea>
                                @error('intructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('bank_accounts.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Rekening</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection