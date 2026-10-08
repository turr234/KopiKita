@extends('layout')

@section('content')
<div class="container-fluid py-4">
    {{-- Notifikasi Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Container --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Daftar Pesanan (Orders)</h5>
                <small class="text-muted">Kelola transaksi pelanggan, pengiriman kurir, dan riwayat pesanan</small>
            </div>
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Buat Pesanan
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>No. Pesanan & Pelanggan</th>
                            <th>Penerima & Alamat Kirim</th>
                            <th>Metode & Pengiriman</th>
                            <th>Total Pembayaran</th>
                            <th class="text-center">Status Pesanan</th>
                            <th class="text-center">Status Bayar</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($order as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Nomor Order & Akun Pembeli --}}
                                <td>
                                    <div class="fw-bold text-dark font-monospace">
                                        #{{ $item->order_number }}
                                    </div>
                                    <div class="small text-muted">
                                        User: <span class="fw-medium text-dark">{{ $item->user->name ?? 'ID #' . $item->user_id }}</span>
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '' }}
                                    </div>
                                </td>

                                {{-- Penerima, Kontak & Alamat Tujuan --}}
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->recipient_name }}</div>
                                    <div class="small text-muted mb-1">{{ $item->recipient_phone }}</div>
                                    <div class="small text-truncate text-secondary" style="max-width: 220px;" 
                                         title="{{ $item->shipping_address }}, {{ $item->village }}, {{ $item->district }}, {{ $item->city }}, {{ $item->province }} ({{ $item->postal_code }})">
                                        {{ $item->shipping_address }}, {{ $item->city }}
                                    </div>
                                </td>

                                {{-- Metode Pembayaran, Pengiriman & Resi --}}
                                <td>
                                    <div class="small text-dark">
                                        <strong>Bayar:</strong> <span class="text-capitalize">{{ $item->payment_method ?? '-' }}</span>
                                    </div>
                                    <div class="small text-dark">
                                        <strong>Kurir:</strong> <span class="text-uppercase">{{ $item->shipping_method ?? '-' }}</span>
                                    </div>
                                    @if ($item->tracking_number)
                                        <div class="small font-monospace text-muted" style="font-size: 0.78rem;">
                                            Resi: <span class="text-primary">{{ $item->tracking_number }}</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Rincian Biaya (Subtotal, Ongkir, Diskon, Total) --}}
                                <td>
                                    <div class="fw-bold text-dark">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        Sub: Rp {{ number_format($item->subtotal, 0, ',', '.') }} | Ongkir: Rp {{ number_format($item->shipping_cost, 0, ',', '.') }}
                                    </div>
                                    @if($item->discount > 0)
                                        <div class="small text-danger" style="font-size: 0.75rem;">
                                            Diskon: -Rp {{ number_format($item->discount, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Status Pesanan --}}
                                <td class="text-center">
                                    @php
                                        $status = strtolower($item->status);
                                        $badgeStatus = match($status) {
                                            'completed', 'selesai' => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                            'shipped', 'dikirim' => 'bg-info-subtle text-info-emphasis border-info-subtle',
                                            'processing', 'diproses' => 'bg-primary-subtle text-primary-emphasis border-primary-subtle',
                                            'cancelled', 'batal' => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                            default => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                        };
                                    @endphp
                                    <span class="badge border px-2 py-1 text-capitalize {{ $badgeStatus }}">
                                        {{ $item->status ?? 'Pending' }}
                                    </span>

                                    @if ($item->cancellation_reason)
                                        <div class="small text-danger text-truncate mt-1" style="max-width: 140px;" title="{{ $item->cancellation_reason }}">
                                            Alasan: {{ $item->cancellation_reason }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Status Pembayaran --}}
                                <td class="text-center">
                                    @php
                                        $payStatus = strtolower($item->payment_status);
                                        $badgePay = match($payStatus) {
                                            'paid', 'lunas', 'settlement' => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                            'unpaid', 'belum bayar' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                            'failed', 'expired', 'gagal' => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                            default => 'bg-secondary-subtle text-secondary-emphasis border-secondary-subtle',
                                        };
                                    @endphp
                                    <span class="badge border px-2 py-1 text-capitalize {{ $badgePay }}">
                                        {{ $item->payment_status ?? 'Unpaid' }}
                                    </span>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('orders.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail Pesanan">Detail</a>
                                        <a href="{{ route('orders.edit', $item->id) }}" class="btn btn-outline-primary" title="Ubah Pesanan">Edit</a>

                                        <form action="{{ route('orders.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data pesanan yang masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($order->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $order->links() }}
            </div>
        @endif
    </div>
</div>
@endsection