@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Notifikasi Error Validation --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <strong class="me-auto">Terjadi Kesalahan Validasi</strong>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Form --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Jenis Produk</h5>
                        <small class="text-muted">Perbarui informasi nama dan keterangan jenis produk</small>
                    </div>
                    <a href="{{ route('jenis_products.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-medium">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('jenis_products.update', $jenisProducts->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">
                        {{-- Input Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark" style="font-size: 0.88rem;">
                                Nama Jenis Produk <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $jenisProducts->name) }}" 
                                placeholder="Masukkan nama jenis produk"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input Keterangan --}}
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold text-dark" style="font-size: 0.88rem;">
                                Keterangan
                            </label>
                            <textarea 
                                class="form-control @error('keterangan') is-invalid @enderror" 
                                id="keterangan" 
                                name="keterangan" 
                                rows="4" 
                                placeholder="Masukkan keterangan (opsional)"
                            >{{ old('keterangan', $jenisProducts->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('jenis_products.index') }}" class="btn btn-light border btn-sm px-4 py-2 fw-medium">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection