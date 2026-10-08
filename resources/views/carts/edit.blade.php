@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Tampilkan Error Validasi Jika Ada --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4 border-0 shadow-sm rounded-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card Container --}}
            <div class="card border-0 shadow-sm rounded-3">
                
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Keranjang</h5>
                        <small class="text-muted">Perbarui data pemilik keranjang belanja</small>
                    </div>
                    <a href="{{ route('carts.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-medium">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">
                    <form action="{{ route('carts.update', $cart->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3" style="font-size: 0.88rem;">
                            
                            {{-- User ID --}}
                            {{-- <div class="col-12">
                                <label for="user_id" class="form-label fw-semibold text-dark">ID Pengguna (User ID)</label>
                                <input type="text" id="user_id" name="user_id" 
                                       class="form-control form-control-sm @error('user_id') is-invalid @enderror" 
                                       value="{{ old('user_id', $cart->user_id) }}" 
                                       placeholder="Masukkan User ID">
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold small text-secondary">
                                ID Pengguna (User ID) <span class="text-danger">*</span>
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

                        </div>

                        {{-- Card Footer Actions --}}
                        <div class="pt-4 mt-4 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('carts.index') }}" class="btn btn-light border btn-sm px-4">Batal</a>
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