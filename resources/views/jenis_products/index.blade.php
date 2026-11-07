@extends('layouts.app')

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
                <h5 class="mb-0 fw-bold text-dark">Daftar Jenis Produk</h5>
                <small class="text-muted">Kelola kategori dan jenis produk yang tersedia</small>
            </div>
            @can('create jenis products')
                <a href="{{ route('jenis_products.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                    + Tambah Jenis Produk
                </a>
            @endcan
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Nama Jenis Produk</th>
                            <th>Keterangan</th>
                            <th>Waktu Dibuat</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($jenisProducts as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Nama Jenis Produk --}}
                                <td>
                                    <div class="fw-bold text-dark">
                                        {{ $item->name }}
                                    </div>
                                </td>

                                {{-- Keterangan --}}
                                <td>
                                    @if ($item->keterangan)
                                        <div class="text-secondary text-truncate" style="max-width: 350px;" title="{{ $item->keterangan }}">
                                            {{ $item->keterangan }}
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                {{-- Timestamp --}}
                                <td>
                                    <div class="small text-dark">
                                        {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                                    </div>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @can('show jenis products')
                                            <a href="{{ route('jenis_products.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        @endcan
                                        @can('edit jenis products')
                                            <a href="{{ route('jenis_products.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>
                                        @endcan
                                        @can('delete jenis products')
                                            <form action="{{ route('jenis_products.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus jenis produk ini?')" title="Hapus">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data jenis produk yang dicatat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($jenisProducts, 'hasPages') && $jenisProducts->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $jenisProducts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection