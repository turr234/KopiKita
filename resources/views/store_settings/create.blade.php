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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Pengaturan Toko</h5>
                        <small class="text-muted">Konfigurasi profil toko, informasi kontak, dan media sosial</small>
                    </div>
                    <a href="{{ route('store_settings.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('store_settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Bagian 1: Identitas & Gambar --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shop me-1"></i> Identitas Toko</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="store_name" class="form-label fw-semibold small text-secondary">Nama Toko <span class="text-danger">*</span></label>
                                <input type="text" id="store_name" name="store_name" 
                                       class="form-control @error('store_name') is-invalid @enderror" 
                                       value="{{ old('store_name') }}" placeholder="Contoh: Kopi Nusantara" required>
                                @error('store_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tagline" class="form-label fw-semibold small text-secondary">Tagline / Slogan</label>
                                <input type="text" id="tagline" name="tagline" 
                                       class="form-control @error('tagline') is-invalid @enderror" 
                                       value="{{ old('tagline') }}" placeholder="Contoh: Rasa Asli Biji Nusantara">
                                @error('tagline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="logo" class="form-label fw-semibold small text-secondary">Logo Toko</label>
                                <input type="file" id="logo" name="logo" 
                                       class="form-control @error('logo') is-invalid @enderror" 
                                       accept="image/*">
                                <div class="form-text small">Format: PNG, JPG, WEBP (Rekomendasi persegi, maks 2MB)</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="favicon" class="form-label fw-semibold small text-secondary">Favicon (Ikon Tab Browser)</label>
                                <input type="file" id="favicon" name="favicon" 
                                       class="form-control @error('favicon') is-invalid @enderror" 
                                       accept="image/x-icon,image/png">
                                <div class="form-text small">Format: ICO, PNG (Rekomendasi 32x32 px)</div>
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 2: Kontak & Lokasi --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-telephone me-1"></i> Kontak & Lokasi</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="email" class="form-label fw-semibold small text-secondary">Email Resmi <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" placeholder="info@toko.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="phone" class="form-label fw-semibold small text-secondary">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="021xxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="whatsapp" class="form-label fw-semibold small text-secondary">Nomor WhatsApp</label>
                                <input type="text" id="whatsapp" name="whatsapp" 
                                       class="form-control @error('whatsapp') is-invalid @enderror" 
                                       value="{{ old('whatsapp') }}" placeholder="628xxxxxxx">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold small text-secondary">Alamat Lengkap Toko</label>
                                <textarea id="address" name="address" rows="2" 
                                          class="form-control @error('address') is-invalid @enderror" 
                                          placeholder="Jl. Nama Jalan No. XX, Kota, Provinsi">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 3: Media Sosial --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-share me-1"></i> Tautan Media Sosial</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="instagram_url" class="form-label fw-semibold small text-secondary">Instagram URL</label>
                                <input type="url" id="instagram_url" name="instagram_url" 
                                       class="form-control @error('instagram_url') is-invalid @enderror" 
                                       value="{{ old('instagram_url') }}" placeholder="https://instagram.com/username">
                                @error('instagram_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tiktok_url" class="form-label fw-semibold small text-secondary">TikTok URL</label>
                                <input type="url" id="tiktok_url" name="tiktok_url" 
                                       class="form-control @error('tiktok_url') is-invalid @enderror" 
                                       value="{{ old('tiktok_url') }}" placeholder="https://tiktok.com/@username">
                                @error('tiktok_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="facebook_url" class="form-label fw-semibold small text-secondary">Facebook URL</label>
                                <input type="url" id="facebook_url" name="facebook_url" 
                                       class="form-control @error('facebook_url') is-invalid @enderror" 
                                       value="{{ old('facebook_url') }}" placeholder="https://facebook.com/username">
                                @error('facebook_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 4: Deskripsi & Pengaturan Sistem --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-gear me-1"></i> Informasi Tambahan</h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="about" class="form-label fw-semibold small text-secondary">Tentang Toko (About Us)</label>
                                <textarea id="about" name="about" rows="3" 
                                          class="form-control @error('about') is-invalid @enderror" 
                                          placeholder="Tuliskan profil singkat atau sejarah toko Anda...">{{ old('about') }}</textarea>
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="minimum_stock_warning" class="form-label fw-semibold small text-secondary">Peringatan Minimum Stok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="minimum_stock_warning" name="minimum_stock_warning" 
                                           class="form-control @error('minimum_stock_warning') is-invalid @enderror" 
                                           value="{{ old('minimum_stock_warning', 5) }}" min="0" required>
                                    <span class="input-group-text small text-muted">Unit</span>
                                    @error('minimum_stock_warning')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text small">Notifikasi batas stok menipis</div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('store_settings.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection