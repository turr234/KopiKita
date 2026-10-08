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
                <h5 class="mb-0 fw-bold text-dark">Daftar Kategori Produk</h5>
                <small class="text-muted">Kelola grup kategori produk, slug URL, dan status aktif</small>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Kategori
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 60px;">No</th>
                            <th>Gambar</th>
                            <th>Kategori & Slug</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($categories as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Gambar Thumbnail --}}
                                <td>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="{{ $item->name }}" 
                                             class="rounded-3 border object-fit-cover shadow-sm" 
                                             width="48" height="48">
                                    @else
                                        <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted" 
                                             style="width: 48px; height: 48px; font-size: 0.75rem;">
                                            No Img
                                        </div>
                                    @endif
                                </td>

                                {{-- Nama & Slug --}}
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                    <div class="small text-muted font-monospace">/{{ $item->slug }}</div>
                                </td>

                                {{-- Deskripsi --}}
                                <td>
                                    <div class="text-truncate text-secondary small" style="max-width: 250px;" title="{{ $item->description }}">
                                        {{ $item->description ?? '-' }}
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
                                        <a href="{{ route('categories.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('categories.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('categories.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada kategori produk yang terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($categories->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection