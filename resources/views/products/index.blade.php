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

    {{-- Card Wrapper --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Daftar Produk</h5>
                <small class="text-muted">Kelola inventaris barang, varian, dan status penjualan</small>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Produk
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Produk</th>
                            <th>Detail & Asal</th>
                            <th>Harga & Diskon</th>
                            <th>Stok & Berat</th>
                            <th class="text-center">Penjualan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($product as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Gambar, Nama, Slug, dan SKU --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->main_image)
                                            <img src="{{ asset('storage/' . $item->main_image) }}" alt="{{ $item->name }}" 
                                                 class="rounded-3 border object-fit-cover me-3" width="48" height="48">
                                        @else
                                            <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted me-3" 
                                                 style="width: 48px; height: 48px; font-size: 0.75rem;">
                                                No Img
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->name }}</div>
                                            <div class="text-muted small">
                                                SKU: <span class="fw-medium text-secondary">{{ $item->sku }}</span>
                                            </div>
                                            <div class="text-muted small text-truncate" style="max-width: 200px;" title="{{ $item->slug }}">
                                                /{{ $item->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Deskripsi, Asal (Origin), dan Tasting Notes --}}
                                <td>
                                    <div class="text-truncate small text-dark fw-medium" style="max-width: 200px;" title="{{ $item->description }}">
                                        {{ $item->description ?? '-' }}
                                    </div>
                                    <div class="small text-muted mt-1">
                                        <strong>Asal:</strong> {{ $item->origin ?? '-' }}
                                    </div>
                                    @if ($item->tasting_notes)
                                        <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $item->tasting_notes }}">
                                            <strong>Notes:</strong> {{ $item->tasting_notes }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Harga dan Diskon --}}
                                <td>
                                    @if ($item->discount_price)
                                        <div class="fw-bold text-danger">Rp {{ number_format($item->discount_price, 0, ',', '.') }}</div>
                                        <div class="small text-muted text-decoration-line-through">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="fw-bold text-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    @endif
                                </td>

                                {{-- Stok dan Berat --}}
                                <td>
                                    <div>
                                        <span class="badge {{ $item->stock <= 5 ? 'bg-danger-subtle text-danger-emphasis border border-danger-subtle' : 'bg-light text-dark border' }}">
                                            Stok: {{ $item->stock }}
                                        </span>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        Berat: {{ $item->weight }} gr
                                    </div>
                                </td>

                                {{-- Terjual (Sold) --}}
                                <td class="text-center">
                                    <span class="fw-semibold text-dark">{{ $item->sold_count ?? 0 }}</span>
                                    <div class="text-muted" style="font-size: 0.72rem;">terjual</div>
                                </td>

                                {{-- Badge Featured & Active --}}
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        @if ($item->is_active)
                                            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle px-2 py-1">Nonaktif</span>
                                        @endif

                                        @if ($item->is_featured)
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1" style="font-size: 0.7rem;">Featured</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('products.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('products.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('products.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus data produk ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data produk yang terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($product->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $product->links() }}
            </div>
        @endif
    </div>
</div>
@endsection