@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Card Container --}}
            <div class="card border-0 shadow-sm rounded-3">
                
                {{-- Card Header (Sama seperti Index) --}}
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Alamat Pengguna</h5>
                        <small class="text-muted">Perbarui rincian alamat pengiriman pelanggan</small>
                    </div>
                    <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-medium">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">
                    <form action="{{ route('addresses.update', $addresse->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Hidden User ID --}}
                        <input type="hidden" name="user_id" value="{{ old('user_id', $addresse->user_id) }}">

                        <div class="row g-3" style="font-size: 0.88rem;">
                            
                            {{-- Label Alamat --}}
                            <div class="col-md-6">
                                <label for="label" class="form-label fw-semibold text-dark">Label Alamat</label>
                                <input type="text" id="label" name="label" 
                                       class="form-control form-control-sm @error('label') is-invalid @enderror" 
                                       value="{{ old('label', $addresse->label) }}" 
                                       placeholder="Contoh: Rumah, Kantor, Kost">
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Penerima --}}
                            <div class="col-md-6">
                                <label for="recipient_name" class="form-label fw-semibold text-dark">Nama Penerima</label>
                                <input type="text" id="recipient_name" name="recipient_name" 
                                       class="form-control form-control-sm @error('recipient_name') is-invalid @enderror" 
                                       value="{{ old('recipient_name', $addresse->recipient_name) }}"
                                       placeholder="Nama lengkap penerima">
                                @error('recipient_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Telepon --}}
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold text-dark">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" 
                                       class="form-control form-control-sm @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $addresse->phone) }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kode Pos --}}
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label fw-semibold text-dark">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       class="form-control form-control-sm @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code', $addresse->postal_code) }}"
                                       placeholder="Contoh: 12345">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Provinsi --}}
                            <div class="col-md-6">
                                <label for="province" class="form-label fw-semibold text-dark">Provinsi</label>
                                <input type="text" id="province" name="province" 
                                       class="form-control form-control-sm @error('province') is-invalid @enderror" 
                                       value="{{ old('province', $addresse->province) }}">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kota / Kabupaten --}}
                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold text-dark">Kota / Kabupaten</label>
                                <input type="text" id="city" name="city" 
                                       class="form-control form-control-sm @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $addresse->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="col-md-6">
                                <label for="district" class="form-label fw-semibold text-dark">Kecamatan</label>
                                <input type="text" id="district" name="district" 
                                       class="form-control form-control-sm @error('district') is-invalid @enderror" 
                                       value="{{ old('district', $addresse->district) }}">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kelurahan / Desa --}}
                            <div class="col-md-6">
                                <label for="village" class="form-label fw-semibold text-dark">Kelurahan / Desa</label>
                                <input type="text" id="village" name="village" 
                                       class="form-control form-control-sm @error('village') is-invalid @enderror" 
                                       value="{{ old('village', $addresse->village) }}">
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div class="col-12">
                                <label for="full_address" class="form-label fw-semibold text-dark">Alamat Lengkap</label>
                                <textarea id="full_address" name="full_address" rows="3" 
                                          class="form-control form-control-sm @error('full_address') is-invalid @enderror"
                                          placeholder="Jalan, No. Rumah, RT/RW, Patokan">{{ old('full_address', $addresse->full_address) }}</textarea>
                                @error('full_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Alamat Utama --}}
                            <div class="col-12">
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="is_primary" id="is_primary" value="1" 
                                           {{ old('is_primary', $addresse->is_primary) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-dark" for="is_primary">
                                        Jadikan Alamat Utama
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer Actions --}}
                        <div class="pt-4 mt-4 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('addresses.index') }}" class="btn btn-light border btn-sm px-4">Batal</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection