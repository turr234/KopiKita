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
                <h5 class="mb-0 fw-bold text-dark">Galeri Foto Produk</h5>
                <small class="text-muted">Kelola foto sekunder, gambar utama, dan urutan tampilan</small>
            </div>
            <a href="{{ route('product_images.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Foto
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 60px;">No</th>
                            <th>Foto</th>
                            <th>Produk Terkait</th>
                            <th class="text-center">Status Utama</th>
                            <th class="text-center">Urutan Tampil</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($product_image as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Gambar Thumbnail --}}
                                <td>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="Foto Produk" 
                                             class="rounded-3 border object-fit-cover shadow-sm" 
                                             width="50" height="50">
                                    @else
                                        <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted" 
                                             style="width: 50px; height: 50px; font-size: 0.75rem;">
                                            No Img
                                        </div>
                                    @endif
                                </td>

                                {{-- Produk --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $item->product->name ?? 'Produk ID #' . $item->product_id }}
                                    </div>
                                    <small class="text-muted">Ref ID: #{{ $item->product_id }}</small>
                                </td>

                                {{-- Status Primary --}}
                                <td class="text-center">
                                    @if ($item->is_primary)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            Gambar Utama
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border px-2 py-1">
                                            Galeri Tambahan
                                        </span>
                                    @endif
                                </td>

                                {{-- Urutan Sort Order --}}
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-dark border px-2 py-1">
                                        Urutan #{{ $item->sort_order ?? 0 }}
                                    </span>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('product_images.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('product_images.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('product_images.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus foto ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada foto produk yang diunggah.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($product_image->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $product_image->links() }}
            </div>
        @endif
    </div>
</div>
@endsection