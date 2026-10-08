@extends('layout')

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
            </div>
        </div>
    </div>
</div>
@endsection
