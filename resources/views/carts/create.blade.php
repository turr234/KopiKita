@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
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
                        <h5 class="mb-0 fw-bold text-dark">Buat Keranjang Baru</h5>
                        <small class="text-muted">Inisialisasi sesi keranjang belanja untuk pengguna</small>
                    </div>
                    <a href="{{ route('carts.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold small text-secondary">
                                Pengguna (User ID) <span class="text-danger">*</span>
                            </label>
                            
                            {{-- Jika controller mengirim variabel $users, gunakan select dropdown berikut: --}}
                            @if(isset($users))
                                <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>-- Pilih Pengguna --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} (ID: #{{ $user->id }} - {{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{-- Fallback jika controller hanya menerima ID manual --}}
                                <input type="number" id="user_id" name="user_id" 
                                       class="form-control @error('user_id') is-invalid @enderror" 
                                       value="{{ old('user_id') }}" placeholder="Contoh: 1" min="1" required>
                            @endif

                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Masukkan ID pengguna yang akan dikaitkan dengan keranjang ini.</div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('carts.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Keranjang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection