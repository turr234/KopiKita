@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Alamat Pengiriman</h5>
                        <small class="text-muted">Lengkapi data destinasi pengiriman dan penerima pesanan</small>
                    </div>
                    <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('addresses.store') }}" method="POST">
                        @csrf

                        {{-- Bagian 1: Akun & Informasi Penerima --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person me-1"></i> Kontak & Identitas Alamat</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="user_id" class="form-label fw-semibold small text-secondary">User ID <span class="text-danger">*</span></label>
                                {{-- <input type="number" id="user_id" name="user_id" 
                                       class="form-control @error('user_id') is-invalid @enderror" 
                                       value="{{ old('user_id') }}" placeholder="Contoh: 1" min="1" required> --}}
                                       <select name="user_id">
                                        @foreach ($users as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('myselect', $model->option ?? '') == $key ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="label" class="form-label fw-semibold small text-secondary">Label Alamat <span class="text-danger">*</span></label>
                                <input type="text" id="label" name="label" 
                                       class="form-control @error('label') is-invalid @enderror" 
                                       value="{{ old('label') }}" placeholder="Contoh: Rumah, Kantor, Kos" required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="is_primary" class="form-label fw-semibold small text-secondary">Jadikan Alamat Utama? <span class="text-danger">*</span></label>
                                <select id="is_primary" name="is_primary" class="form-select @error('is_primary') is-invalid @enderror" required>
                                    <option value="0" {{ old('is_primary', '0') == '0' ? 'selected' : '' }}>Bukan (Sekunder)</option>
                                    <option value="1" {{ old('is_primary') == '1' ? 'selected' : '' }}>Ya (Alamat Utama)</option>
                                </select>
                                @error('is_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="recipient_name" class="form-label fw-semibold small text-secondary">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" id="recipient_name" name="recipient_name" 
                                       class="form-control @error('recipient_name') is-invalid @enderror" 
                                       value="{{ old('recipient_name') }}" placeholder="Contoh: Budi Santoso" required>
                                @error('recipient_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold small text-secondary">Nomor Telepon / HP <span class="text-danger">*</span></label>
                                <input type="tel" id="phone" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 2: Wilayah Administratif & Alamat Fisik --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt me-1"></i> Lokasi & Wilayah Pengiriman</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="province" class="form-label fw-semibold small text-secondary">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" id="province" name="province" 
                                       class="form-control @error('province') is-invalid @enderror" 
                                       value="{{ old('province') }}" placeholder="Contoh: Jawa Barat" required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold small text-secondary">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" id="city" name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city') }}" placeholder="Contoh: Kota Bandung" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="district" class="form-label fw-semibold small text-secondary">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" id="district" name="district" 
                                       class="form-control @error('district') is-invalid @enderror" 
                                       value="{{ old('district') }}" placeholder="Contoh: Coblong" required>
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="village" class="form-label fw-semibold small text-secondary">Kelurahan / Desa <span class="text-danger">*</span></label>
                                <input type="text" id="village" name="village" 
                                       class="form-control @error('village') is-invalid @enderror" 
                                       value="{{ old('village') }}" placeholder="Contoh: Dago" required>
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="postal_code" class="form-label fw-semibold small text-secondary">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code') }}" placeholder="Contoh: 40135" required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="full_address" class="form-label fw-semibold small text-secondary">Alamat Lengkap & Patokan <span class="text-danger">*</span></label>
                                <textarea id="full_address" name="full_address" rows="3" 
                                          class="form-control @error('full_address') is-invalid @enderror" 
                                          placeholder="Jl. Nama Jalan No. XX, RT/RW, Patokan gedung atau warna pagar..." required>{{ old('full_address') }}</textarea>
                                @error('full_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('addresses.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Alamat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection