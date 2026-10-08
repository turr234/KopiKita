@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Alert Error Validasi --}}
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
                        <h5 class="mb-0 fw-bold text-dark">Edit Pesanan #{{ $order->order_number }}</h5>
                        <small class="text-muted">Perbarui rincian pesanan, alamat, pembayaran, dan status</small>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                        &larr; Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Bagian 1: Identitas Pesanan & Akun --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-receipt me-1"></i> Data Transaksi & Akun</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="order_number" class="form-label fw-semibold small text-secondary">Nomor Pesanan <span class="text-danger">*</span></label>
                                <input type="text" id="order_number" name="order_number" 
                                       class="form-control font-monospace text-uppercase @error('order_number') is-invalid @enderror" 
                                       value="{{ old('order_number', $order->order_number) }}" required>
                                @error('order_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="user_id" class="form-label fw-semibold small text-secondary">Pelanggan (User) <span class="text-danger">*</span></label>
                                <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Pelanggan --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="address_id" class="form-label fw-semibold small text-secondary">Address ID</label>
                                <input type="number" id="address_id" name="address_id" 
                                       class="form-control @error('address_id') is-invalid @enderror" 
                                       value="{{ old('address_id', $order->address_id) }}" placeholder="Contoh: 12">
                                @error('address_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 2: Data Penerima & Alamat Pengiriman --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt me-1"></i> Penerima & Lokasi Pengiriman</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="recipient_name" class="form-label fw-semibold small text-secondary">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" id="recipient_name" name="recipient_name" 
                                       class="form-control @error('recipient_name') is-invalid @enderror" 
                                       value="{{ old('recipient_name', $order->recipient_name) }}" placeholder="Contoh: Budi Santoso" required>
                                @error('recipient_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="recipient_phone" class="form-label fw-semibold small text-secondary">Nomor HP Penerima <span class="text-danger">*</span></label>
                                <input type="text" id="recipient_phone" name="recipient_phone" 
                                       class="form-control @error('recipient_phone') is-invalid @enderror" 
                                       value="{{ old('recipient_phone', $order->recipient_phone) }}" placeholder="08xxxxxxxxxx" required>
                                @error('recipient_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="province" class="form-label fw-semibold small text-secondary">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" id="province" name="province" 
                                       class="form-control @error('province') is-invalid @enderror" 
                                       value="{{ old('province', $order->province) }}" placeholder="Contoh: Jawa Barat" required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold small text-secondary">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" id="city" name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $order->city) }}" placeholder="Contoh: Bandung" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="district" class="form-label fw-semibold small text-secondary">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" id="district" name="district" 
                                       class="form-control @error('district') is-invalid @enderror" 
                                       value="{{ old('district', $order->district) }}" placeholder="Contoh: Coblong" required>
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="village" class="form-label fw-semibold small text-secondary">Kelurahan / Desa</label>
                                <input type="text" id="village" name="village" 
                                       class="form-control @error('village') is-invalid @enderror" 
                                       value="{{ old('village', $order->village) }}" placeholder="Contoh: Dago">
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="postal_code" class="form-label fw-semibold small text-secondary">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code', $order->postal_code) }}" placeholder="40135">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="shipping_address" class="form-label fw-semibold small text-secondary">Alamat Lengkap & Patokan <span class="text-danger">*</span></label>
                                <textarea id="shipping_address" name="shipping_address" rows="2" 
                                          class="form-control @error('shipping_address') is-invalid @enderror" 
                                          placeholder="Jl. Nama Jalan No. XX, RT/RW, Patokan..." required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 3: Rincian Biaya, Pembayaran & Ekspedisi --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-wallet2 me-1"></i> Biaya & Logistik</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="subtotal" class="form-label fw-semibold small text-secondary">Subtotal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="subtotal" name="subtotal" 
                                           class="form-control @error('subtotal') is-invalid @enderror" 
                                           value="{{ old('subtotal', $order->subtotal) }}" min="0" required>
                                </div>
                                @error('subtotal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="shipping_cost" class="form-label fw-semibold small text-secondary">Ongkir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="shipping_cost" name="shipping_cost" 
                                           class="form-control @error('shipping_cost') is-invalid @enderror" 
                                           value="{{ old('shipping_cost', $order->shipping_cost) }}" min="0" required>
                                </div>
                                @error('shipping_cost')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="discount" class="form-label fw-semibold small text-secondary">Diskon</label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" id="discount" name="discount" 
                                           class="form-control @error('discount') is-invalid @enderror" 
                                           value="{{ old('discount', $order->discount) }}" min="0">
                                </div>
                                @error('discount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="total" class="form-label fw-semibold small text-secondary">Total Tagihan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text small fw-bold">Rp</span>
                                    <input type="number" id="total" name="total" 
                                           class="form-control fw-bold text-success @error('total') is-invalid @enderror" 
                                           value="{{ old('total', $order->total) }}" min="0" required>
                                </div>
                                @error('total')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="payment_method" class="form-label fw-semibold small text-secondary">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select id="payment_method" name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                    <option value="bank_transfer" {{ old('payment_method', $order->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="ewallet" {{ old('payment_method', $order->payment_method) == 'ewallet' ? 'selected' : '' }}>E-Wallet / QRIS</option>
                                    <option value="cod" {{ old('payment_method', $order->payment_method) == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="shipping_method" class="form-label fw-semibold small text-secondary">Kurir / Ekspedisi</label>
                                <input type="text" id="shipping_method" name="shipping_method" 
                                       class="form-control @error('shipping_method') is-invalid @enderror" 
                                       value="{{ old('shipping_method', $order->shipping_method) }}" placeholder="Contoh: JNE REG / SiCepat">
                                @error('shipping_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tracking_number" class="form-label fw-semibold small text-secondary">Nomor Resi (Tracking)</label>
                                <input type="text" id="tracking_number" name="tracking_number" 
                                       class="form-control font-monospace @error('tracking_number') is-invalid @enderror" 
                                       value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="JPxxxxxxxxxx">
                                @error('tracking_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        {{-- Bagian 4: Status, Catatan & Timeline --}}
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-clock-history me-1"></i> Status & Timeline</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold small text-secondary">Status Pesanan <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Diproses (Packing)</option>
                                    <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="payment_status" class="form-label fw-semibold small text-secondary">Status Pembayaran <span class="text-danger">*</span></label>
                                <select id="payment_status" name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="unpaid" {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>Belum Dibayar (Unpaid)</option>
                                    <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                                    <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Gagal / Kadaluarsa</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="notes" class="form-label fw-semibold small text-secondary">Catatan Pesanan</label>
                                <textarea id="notes" name="notes" rows="2" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="Catatan dari pembeli atau instruksi pengiriman...">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="cancellation_reason" class="form-label fw-semibold small text-secondary">Alasan Pembatalan</label>
                                <textarea id="cancellation_reason" name="cancellation_reason" rows="2" 
                                          class="form-control @error('cancellation_reason') is-invalid @enderror" 
                                          placeholder="Diisi apabila status pesanan dibatalkan...">{{ old('cancellation_reason', $order->cancellation_reason) }}</textarea>
                                @error('cancellation_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="paid_at" class="form-label fw-semibold small text-secondary">Waktu Dibayar</label>
                                <input type="datetime-local" id="paid_at" name="paid_at" 
                                       class="form-control @error('paid_at') is-invalid @enderror" 
                                       value="{{ old('paid_at', $order->paid_at ? $order->paid_at->format('Y-m-d\TH:i') : '') }}">
                                @error('paid_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="shipped_at" class="form-label fw-semibold small text-secondary">Waktu Dikirim</label>
                                <input type="datetime-local" id="shipped_at" name="shipped_at" 
                                       class="form-control @error('shipped_at') is-invalid @enderror" 
                                       value="{{ old('shipped_at', $order->shipped_at ? $order->shipped_at->format('Y-m-d\TH:i') : '') }}">
                                @error('shipped_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="cancelled_at" class="form-label fw-semibold small text-secondary">Waktu Dibatalkan</label>
                                <input type="datetime-local" id="cancelled_at" name="cancelled_at" 
                                       class="form-control @error('cancelled_at') is-invalid @enderror" 
                                       value="{{ old('cancelled_at', $order->cancelled_at ? $order->cancelled_at->format('Y-m-d\TH:i') : '') }}">
                                @error('cancelled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="completed_at" class="form-label fw-semibold small text-secondary">Waktu Selesai</label>
                                <input type="datetime-local" id="completed_at" name="completed_at" 
                                       class="form-control @error('completed_at') is-invalid @enderror" 
                                       value="{{ old('completed_at', $order->completed_at ? $order->completed_at->format('Y-m-d\TH:i') : '') }}">
                                @error('completed_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('orders.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-medium">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection