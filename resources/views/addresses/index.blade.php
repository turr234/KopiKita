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
                <h5 class="mb-0 fw-bold text-dark">Daftar Alamat Pengguna</h5>
                <small class="text-muted">Kelola buku alamat pengiriman pelanggan dan status alamat utama</small>
            </div>
            <a href="{{ route('addresses.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Alamat
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Pengguna</th>
                            <th>Label & Penerima</th>
                            <th>Wilayah & Kode Pos</th>
                            <th>Alamat Lengkap</th>
                            <th class="text-center">Status Alamat</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($addresse as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Akun Pengguna Pemilik Alamat --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $item->user->name ?? 'User ID #' . $item->user_id }}
                                    </div>
                                    <small class="text-muted">ID: #{{ $item->user_id }}</small>
                                </td>

                                {{-- Label, Nama Penerima & Nomor Telepon --}}
                                <td>
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-0">
                                            {{ $item->label ?? 'Alamat' }}
                                        </span>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $item->recipient_name }}</div>
                                    <div class="small text-muted">{{ $item->phone }}</div>
                                </td>

                                {{-- Wilayah Bertingkat (Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos) --}}
                                <td>
                                    <div class="text-dark fw-medium">{{ $item->city }}, {{ $item->province }}</div>
                                    <div class="small text-muted">
                                        Kec. {{ $item->district }}, Kel. {{ $item->village }}
                                    </div>
                                    <span class="badge bg-light text-secondary border font-monospace mt-1" style="font-size: 0.75rem;">
                                        Kode Pos: {{ $item->postal_code }}
                                    </span>
                                </td>

                                {{-- Alamat Lengkap / Patokan --}}
                                <td>
                                    <div class="text-truncate small text-secondary" style="max-width: 250px;" title="{{ $item->full_address }}">
                                        {{ $item->full_address }}
                                    </div>
                                </td>

                                {{-- Status Alamat Utama --}}
                                <td class="text-center">
                                    @if ($item->is_primary)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            Utama
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border px-2 py-1">
                                            Sekunder
                                        </span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('addresses.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('addresses.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('addresses.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus alamat ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data alamat tersimpan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($addresse->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $addresse->links() }}
            </div>
        @endif
    </div>
</div>
@endsection