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
                <h5 class="mb-0 fw-bold text-dark">Daftar Rekening Bank</h5>
                <small class="text-muted">Kelola akun bank tujuan pembayaran dan petunjuk transfer</small>
            </div>
            <a href="{{ route('bank_accounts.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Rekening
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 60px;">No</th>
                            <th>Bank</th>
                            <th>Informasi Rekening</th>
                            <th>Petunjuk Transfer</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($bank_account as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Logo & Nama Bank --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->logo)
                                            <img src="{{ asset('storage/' . $item->logo) }}" 
                                                 alt="{{ $item->bank_name }}" 
                                                 class="rounded border object-fit-contain p-1 me-3 bg-white" 
                                                 width="48" height="48">
                                        @else
                                            <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted me-3" 
                                                 style="width: 48px; height: 48px; font-size: 0.75rem;">
                                                Bank
                                            </div>
                                        @endif
                                        <div class="fw-bold text-dark">{{ $item->bank_name }}</div>
                                    </div>
                                </td>

                                {{-- Nomor Rekening & Atas Nama --}}
                                <td>
                                    <div class="fw-semibold text-primary font-monospace fs-6">
                                        {{ $item->account_number }}
                                    </div>
                                    <div class="small text-muted">
                                        a.n. <span class="text-dark fw-medium">{{ $item->account_holder }}</span>
                                    </div>
                                </td>

                                {{-- Petunjuk Transfer (Instructions) --}}
                                <td>
                                    <div class="text-truncate small text-secondary" style="max-width: 250px;" title="{{ $item->instructions ?? $item->intructions }}">
                                        {{ $item->instructions ?? $item->intructions ?? '-' }}
                                    </div>
                                </td>

                                {{-- Status Aktif --}}
                                <td class="text-center">
                                    @if ($item->is_active)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle px-2 py-1">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('bank_accounts.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('bank_accounts.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('bank_accounts.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus rekening ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada akun rekening bank yang ditambahkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($bank_account->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $bank_account->links() }}
            </div>
        @endif
    </div>
</div>
@endsection