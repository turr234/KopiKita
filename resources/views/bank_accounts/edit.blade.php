@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Tampilkan Error Jika Ada Validasi yang Gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4 border-0 shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Edit Rekening Bank</h5>
                        <small class="text-muted">Perbarui rincian informasi dan instruksi pembayaran bank</small>
                    </div>
                    <a href="{{ route('bank_accounts.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-medium">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    {{-- PENTING: Tambahkan enctype="multipart/form-data" untuk upload file --}}
                    <form action="{{ route('bank_accounts.update', $bank_account->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3" style="font-size: 0.88rem;">
                            
                            {{-- Nama Bank --}}
                            <div class="col-md-6">
                                <label for="bank_name" class="form-label fw-semibold text-dark">Nama Bank</label>
                                <input type="text" id="bank_name" name="bank_name" 
                                       class="form-control form-control-sm @error('bank_name') is-invalid @enderror" 
                                       value="{{ old('bank_name', $bank_account->bank_name) }}">
                            </div>

                            {{-- Nomor Rekening --}}
                            <div class="col-md-6">
                                <label for="account_number" class="form-label fw-semibold text-dark">Nomor Rekening</label>
                                <input type="text" id="account_number" name="account_number" 
                                       class="form-control form-control-sm @error('account_number') is-invalid @enderror" 
                                       value="{{ old('account_number', $bank_account->account_number) }}">
                            </div>

                            {{-- Nama Pemilik Rekening --}}
                            <div class="col-md-6">
                                <label for="account_holder" class="form-label fw-semibold text-dark">Nama Pemilik Rekening</label>
                                <input type="text" id="account_holder" name="account_holder" 
                                       class="form-control form-control-sm @error('account_holder') is-invalid @enderror" 
                                       value="{{ old('account_holder', $bank_account->account_holder) }}">
                            </div>

                            {{-- File Logo Bank --}}
                            <div class="col-md-6">
                                <label for="logo" class="form-label fw-semibold text-dark">Logo Bank (Opsional)</label>
                                <input type="file" id="logo" name="logo" 
                                       class="form-control form-control-sm @error('logo') is-invalid @enderror">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo.</small>
                            </div>

                            {{-- Instruksi Pembayaran --}}
                            <div class="col-12">
                                <label for="intructions" class="form-label fw-semibold text-dark">Instruksi Pembayaran</label>
                                <textarea id="intructions" name="intructions" rows="4" 
                                          class="form-control form-control-sm @error('intructions') is-invalid @enderror">{{ old('intructions', $bank_account->intructions) }}</textarea>
                            </div>

                            {{-- Status Aktif --}}
                            <div class="col-12">
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', $bank_account->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-dark" for="is_active">
                                        Aktifkan Rekening Bank Ini
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="pt-4 mt-4 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('bank_accounts.index') }}" class="btn btn-light border btn-sm px-4">Batal</a>
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