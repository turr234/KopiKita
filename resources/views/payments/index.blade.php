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
                    <h5 class="mb-0 fw-bold text-dark">Daftar Pembayaran</h5>
                    <small class="text-muted">Kelola transaksi, konfirmasi bukti transfer, dan status verifikasi</small>
                </div>
                <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                    + Tambah Pembayaran
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                        <thead class="table-light text-secondary text-uppercase"
                            style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="text-center py-3" style="width: 50px;">No</th>
                                <th>Transaksi & Pesanan</th>
                                <th>Metode & Pengirim</th>
                                <th>Nominal</th>
                                <th class="text-center">Bukti Bayar</th>
                                <th class="text-center">Status</th>
                                <th>Verifikasi</th>
                                <th class="text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($payment as $item)
                                <tr>
                                    {{-- Nomor --}}
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                    {{-- Kode Pembayaran & Order ID --}}
                                    <td>
                                        <div class="fw-bold text-dark font-monospace">
                                            {{ $item->payment_code ?? $item->paymeny_code }}
                                        </div>
                                        <div class="small text-muted">
                                            Order: <span class="fw-medium text-secondary">#{{ $item->order_id }}</span>
                                        </div>
                                    </td>

                                    {{-- Metode & Nama Pengirim --}}
                                    <td>
                                        <div class="fw-medium text-dark text-capitalize">
                                            {{ $item->method }}
                                        </div>
                                        <div class="small text-muted">
                                            Pengirim: <span class="text-dark">{{ $item->sender_name ?? '-' }}</span>
                                        </div>
                                        @if ($item->bank_account_id)
                                            <div class="small text-muted" style="font-size: 0.75rem;">
                                                Bank Acc: #{{ $item->bank_account_id }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Nominal Jumlah --}}
                                    <td>
                                        <span class="fw-bold text-success">
                                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- Gambar Bukti Transfer --}}
                                    <td class="text-center">
                                        @if ($item->proof_image)
                                            <a href="{{ asset('storage/' . $item->proof_image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $item->proof_image) }}"
                                                    alt="Bukti Transfer" class="rounded border object-fit-cover shadow-sm"
                                                    width="45" height="45" title="Klik untuk memperbesar">
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    {{-- Status Pembayaran & Alasan Penolakan --}}
                                    <td class="text-center">
                                        @php
                                            $status = strtolower($item->status);
                                            $badgeClass = match ($status) {
                                                'paid',
                                                'verified',
                                                'berhasil',
                                                'success'
                                                    => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                                'rejected',
                                                'ditolak',
                                                'failed'
                                                    => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                                'pending',
                                                'menunggu'
                                                    => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                                default
                                                    => 'bg-secondary-subtle text-secondary-emphasis border-secondary-subtle',
                                            };
                                        @endphp
                                        <span class="badge border px-2 py-1 text-capitalize {{ $badgeClass }}">
                                            {{ $item->status ?? 'Pending' }}
                                        </span>

                                        @if ($item->rejection_reason)
                                            <div class="small text-danger text-truncate mt-1" style="max-width: 140px;"
                                                title="{{ $item->rejection_reason }}">
                                                {{ $item->rejection_reason }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Data Verifikasi --}}
                                    <td>
                                        @if ($item->verified_at || $item->virified_by || $item->verified_by)
                                            <div class="small text-dark fw-medium">
                                                {{ $item->verifier->name ?? 'User #' . ($item->verified_by ?? $item->virified_by) }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                {{ \Carbon\Carbon::parse($item->verified_at)->format('d M Y H:i') }}
                                            </div>
                                        @else
                                            <span class="text-muted small">Belum diverifikasi</span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('payments.show', $item->id) }}"
                                                class="btn btn-outline-secondary" title="Detail">Detail</a>
                                            <a href="{{ route('payments.edit', $item->id) }}"
                                                class="btn btn-outline-primary" title="Edit">Edit</a>

                                            <form action="{{ route('payments.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data pembayaran ini?')"
                                                    title="Hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <p class="mb-0">Belum ada riwayat pembayaran yang tersedia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($payment->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {{ $payment->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
