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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Kategori Baru</h5>
                        <small class="text-muted">Kelompokkan produk dengan membuat kategori baru</small>
                    </div>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Kategori --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small text-secondary">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Contoh: Biji Kopi Arabika" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6">
                                <label for="slug" class="form-label fw-semibold small text-secondary">Slug URL</label>
                                <input type="text" id="slug" name="slug" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       value="{{ old('slug') }}" placeholder="biji-kopi-arabika">
                                <div class="form-text small" style="font-size: 0.72rem;">Opsional (bisa dibuat otomatis oleh sistem)</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold small text-secondary">Deskripsi Kategori</label>
                                <textarea id="description" name="description" rows="3" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Jelaskan jenis atau cakupan produk dalam kategori ini...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gambar Kategori --}}
                            <div class="col-md-8">
                                <label for="image" class="form-label fw-semibold small text-secondary">Foto / Ikon Kategori</label>
                                <input type="file" id="image" name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*">
                                <div class="form-text small">Format: JPG, PNG, WEBP (Maksimal 2MB)</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Aktif --}}
                            <div class="col-md-4">
                                <label for="is_active" class="form-label fw-semibold small text-secondary">Status <span class="text-danger">*</span></label>
                                <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('categories.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection