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
                <h5 class="mb-0 fw-bold text-dark">Riwayat Status Pesanan</h5>
                <small class="text-muted">Log histori perubahan status pesanan dan catatan pengiriman</small>
            </div>
            <a href="{{ route('order_status_histories.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Catat Riwayat
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>No. Pesanan & Pemesan</th>
                            <th>Tujuan Pengiriman</th>
                            <th class="text-center">Status Pesanan</th>
                            <th class="text-center">Status Bayar</th>
                            <th>Total & Pembayaran</th>
                            <th>Catatan / Alasan</th>
                            <th>Waktu Pencatatan</th>
                            <th class="text-center" style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($order_status_historie as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Identitas Pesanan & Pengguna --}}
                                <td>
                                    <div class="fw-bold text-dark font-monospace">
                                        #{{ $item->order_number ?? $item->order_id }}
                                    </div>
                                    <div class="small text-muted">
                                        User ID: <span class="text-dark">#{{ $item->user_id }}</span>
                                    </div>
                                </td>

                                {{-- Penerima & Lokasi --}}
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->recipient_name ?? '-' }}</div>
                                    <div class="small text-muted">{{ $item->recipient_phone ?? '-' }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 180px;" title="{{ $item->shipping_address }}">
                                        {{ $item->city ?? $item->shipping_address ?? '-' }}
                                    </div>
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
                                </td>

                                {{-- Status Pembayaran --}}
                                <td class="text-center">
                                    @php
                                        $payStatus = strtolower($item->payment_status);
                                        $badgePay = match($payStatus) {
                                            'paid', 'lunas' => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                            'unpaid', 'belum bayar' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                            'failed', 'batal' => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                            default => 'bg-secondary-subtle text-secondary-emphasis border-secondary-subtle',
                                        };
                                    @endphp
                                    <span class="badge border px-2 py-1 text-capitalize {{ $badgePay }}">
                                        {{ $item->payment_status ?? 'Unpaid' }}
                                    </span>
                                </td>

                                {{-- Biaya & Metode --}}
                                <td>
                                    <div class="fw-bold text-dark">
                                        Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ strtoupper($item->payment_method ?? '-') }} / {{ strtoupper($item->shipping_method ?? '-') }}
                                    </div>
                                </td>

                                {{-- Catatan & Alasan Pembatalan --}}
                                <td>
                                    @if ($item->notes)
                                        <div class="small text-dark text-truncate" style="max-width: 170px;" title="{{ $item->notes }}">
                                            <strong>Note:</strong> {{ $item->notes }}
                                        </div>
                                    @endif
                                    @if ($item->cancellation_reason)
                                        <div class="small text-danger text-truncate" style="max-width: 170px;" title="{{ $item->cancellation_reason }}">
                                            <strong>Batal:</strong> {{ $item->cancellation_reason }}
                                        </div>
                                    @endif
                                    @if (!$item->notes && !$item->cancellation_reason)
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                {{-- Timestamp --}}
                                <td>
                                    <div class="small text-dark">
                                        {{ $item->created_at ? $item->created_at->format('d M Y H:i') : ($item->completed_at ?? $item->shipped_at ?? '-') }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                                    </div>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('order_status_histories.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('order_status_histories.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('order_status_histories.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus histori ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada riwayat status pesanan yang dicatat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($order_status_historie->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $order_status_historie->links() }}
            </div>
        @endif
    </div>
</div>
@endsection