@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Detail Pesanan #{{ $order->order_number }}</h4>
                    <span class="text-muted small">Dibuat pada {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span>
                </div>
                <div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm px-3">&larr; Kembali</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm px-3 ms-2">Edit Pesanan</a>
                </div>
            </div>

            {{-- Notifikasi Flash Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Aksi Cepat Pengelolaan Status Pesanan (Admin / Toko) --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4 border-start border-4 border-primary">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark"><i class="bi bi-sliders me-1 text-primary"></i> Tindakan Pengelolaan Pesanan (Admin Toko)</h5>
                            <small class="text-muted">Ubah tahapan pesanan saat kopi mulai diproses, diserahkan ke kurir, atau dibatalkan</small>
                        </div>
                        <div>
                            <span class="badge px-3 py-2 fs-6 text-uppercase 
                                {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'shipped' ? 'bg-info text-dark' : ($order->status === 'processing' ? 'bg-primary' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark'))) }}">
                                Status Saat Ini: {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="row g-3 pt-2">
                        {{-- 1. Tombol Terima & Proses Pesanan --}}
                        @if($order->status === 'pending')
                            <div class="col-md-6 col-lg-4">
                                <form action="{{ route('orders.update_status', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <input type="hidden" name="payment_status" value="paid">
                                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold shadow-sm text-start" onclick="return confirm('Konfirmasi pembayaran dan mulai proses pesanan kopi ini?')">
                                        <i class="bi bi-play-circle-fill me-2"></i> 1. Terima & Proses Kopi
                                        <div class="small fw-normal text-white-50" style="font-size: 0.75rem;">Konfirmasi bayar & mulai roasting/packing</div>
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- 2. Form Kirim Pesanan + Input Resi --}}
                        @if(in_array($order->status, ['pending', 'processing']))
                            <div class="col-md-6 col-lg-5">
                                <form action="{{ route('orders.update_status', $order->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="status" value="shipped">
                                    <div class="flex-grow-1">
                                        <input type="text" name="tracking_number" class="form-control form-control-sm py-2 font-monospace" 
                                               placeholder="Ketik No. Resi Kurir..." value="{{ $order->tracking_number }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-info text-dark btn-sm px-3 py-2 fw-semibold shadow-sm flex-shrink-0" onclick="return confirm('Kirim pesanan ini dengan nomor resi tersebut?')">
                                        <i class="bi bi-truck me-1"></i> Kirim Pesanan
                                    </button>
                                </form>
                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">*Masukkan nomor resi kurir (JNE/J&T) lalu klik Kirim</small>
                            </div>
                        @endif

                        {{-- 3. Tombol Selesaikan Pesanan --}}
                        @if(in_array($order->status, ['processing', 'shipped']))
                            <div class="col-md-6 col-lg-3">
                                <form action="{{ route('orders.update_status', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <input type="hidden" name="payment_status" value="paid">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold shadow-sm" onclick="return confirm('Tandai pesanan ini telah selesai dan diterima pelanggan?')">
                                        <i class="bi bi-check2-circle me-1"></i> Tandai Selesai
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- 4. Tombol Batalkan Pesanan --}}
                        @if($order->status !== 'completed' && $order->status !== 'cancelled')
                            <div class="col-md-6 col-lg-3">
                                <button type="button" class="btn btn-outline-danger w-100 py-2 fw-medium" data-bs-toggle="collapse" data-bs-target="#cancelOrderCollapse">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Pesanan
                                </button>
                            </div>

                            <div class="col-12 collapse mt-2" id="cancelOrderCollapse">
                                <form action="{{ route('orders.update_status', $order->id) }}" method="POST" class="p-3 bg-light rounded-3 border border-danger-subtle">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <label class="form-label small fw-bold text-danger mb-1">Alasan Pembatalan Pesanan:</label>
                                    <div class="input-group">
                                        <input type="text" name="cancellation_reason" class="form-control form-control-sm" placeholder="Contoh: Stok biji kopi habis / Pelanggan minta batal..." required>
                                        <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Konfirmasi Batal</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Info Status & Pembayaran --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-info-circle me-1"></i> Status & Informasi Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted" style="width: 40%;">Status Pesanan:</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 text-capitalize">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status Pembayaran:</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 text-capitalize">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Metode Bayar:</td>
                                    <td class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kurir / Ekspedisi:</td>
                                    <td class="text-uppercase">{{ $order->shipping_method ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No. Resi:</td>
                                    <td class="font-monospace text-primary">{{ $order->tracking_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Catatan:</td>
                                    <td>{{ $order->notes ?? '-' }}</td>
                                </tr>
                                @if($order->cancellation_reason)
                                <tr>
                                    <td class="text-danger">Alasan Batal:</td>
                                    <td class="text-danger">{{ $order->cancellation_reason }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Penerima & Alamat Pengiriman --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-geo-alt me-1"></i> Data Penerima & Pengiriman</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted" style="width: 40%;">Nama Penerima:</td>
                                    <td class="fw-bold">{{ $order->recipient_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nomor Telepon:</td>
                                    <td>{{ $order->recipient_phone }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat:</td>
                                    <td>{{ $order->shipping_address }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kel / Kec:</td>
                                    <td>{{ $order->village ? $order->village . ', ' : '' }}{{ $order->district }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kota / Prov:</td>
                                    <td>{{ $order->city }}, {{ $order->province }} ({{ $order->postal_code ?? '-' }})</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Akun Pelanggan:</td>
                                    <td>{{ $order->user->name ?? 'User #' . $order->user_id }} ({{ $order->user->email ?? '-' }})</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Daftar Produk yang Dipesan --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-box-seam me-1"></i> Produk yang Dipesan ({{ $order->items->count() }} item)</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-end pe-4">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->items as $item)
                                            <tr>
                                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $item->product_name }}</div>
                                                    @if($item->product_sku)
                                                        <div class="small text-muted font-monospace">SKU: {{ $item->product_sku }}</div>
                                                    @endif
                                                </td>
                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                                <td class="text-end pe-4 fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">Tidak ada data item produk.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rincian Biaya --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-wallet2 me-1"></i> Rincian Tagihan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Subtotal Produk:</span>
                                        <span class="fw-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Ongkos Kirim:</span>
                                        <span class="fw-semibold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                    </div>
                                    @if($order->discount > 0)
                                    <div class="d-flex justify-content-between py-1 text-danger">
                                        <span>Potongan Diskon:</span>
                                        <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="fw-bold fs-6">Total Pembayaran:</span>
                                        <span class="fw-bold text-success fs-5">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Status Pesanan (Audit Log Timeline) --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-1"></i> Riwayat Pelacakan & Log Perubahan Status ({{ $order->statusHistories->count() }})</h6>
                        </div>
                        <div class="card-body p-3">
                            @if($order->statusHistories->isNotEmpty())
                                <div class="list-group list-group-flush small">
                                    @foreach($order->statusHistories as $log)
                                        <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                                            <div>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 text-uppercase me-2">{{ $log->status }}</span>
                                                <span class="text-dark fw-medium">{{ $log->description }}</span>
                                                @if($log->changedByUser)
                                                    <span class="text-muted small ms-1">(oleh: {{ $log->changedByUser->name }})</span>
                                                @endif
                                            </div>
                                            <span class="text-muted small text-nowrap">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted small text-center py-2">Belum ada riwayat perubahan status.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
