@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Notifikasi Flash Message --}}
    @session('success')
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-circle-check me-2 fs-5"></i>
            <div>{{ $value }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    {{-- Card Wrapper --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h5 mb-0 fw-bold text-dark">Products</h2>
                <small class="text-muted">Kelola inventaris barang, varian, dan status penjualan</small>
            </div>

            {{-- Spatie Permission: Hanya tampil jika user punya permission product-create --}}
            {{-- @can('product-create') --}}
            @can('create product')
                 <a href="{{ route('products.create') }}" class="btn btn-success btn-sm px-3 py-2 fw-medium">
                    <i class="fa fa-plus me-1"></i> Create New Product
                </a>
            @endcan
            {{-- @endcan --}}
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
                            <th class="text-center" style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($product as $products)
                        <tr>
                            {{-- Nomor --}}
                            <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                            {{-- Gambar, Nama, Slug, dan SKU --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($products->main_image)
                                    <img src="{{ asset('storage/' . $products->main_image) }}" alt="{{ $products->name }}"
                                        class="rounded-3 border object-fit-cover me-3" width="48" height="48">
                                    @else
                                    <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted me-3"
                                        style="width: 48px; height: 48px; font-size: 0.75rem;">
                                        No Img
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $products->name }}</div>
                                        <div class="text-muted small">
                                            SKU: <span class="fw-medium text-secondary">{{ $products->sku ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Detail, Asal (Origin), dan Tasting Notes --}}
                            <td>
                                <div class="text-truncate small text-dark fw-medium" style="max-width: 200px;" title="{{ $products->detail }}">
                                    {{ $products->detail ?? '-' }}
                                </div>
                                <div class="small text-muted mt-1">
                                    <strong>Asal:</strong> {{ $products->origin ?? '-' }}
                                </div>
                                @if ($products->tasting_notes)
                                <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $products->tasting_notes }}">
                                    <strong>Notes:</strong> {{ $products->tasting_notes }}
                                </div>
                                @endif
                            </td>

                            {{-- Harga dan Diskon --}}
                            <td>
                                @if ($products->discount_price)
                                <div class="fw-bold text-danger">Rp {{ number_format($products->discount_price, 0, ',', '.') }}</div>
                                <div class="small text-muted text-decoration-line-through">
                                    Rp {{ number_format($products->price, 0, ',', '.') }}
                                </div>
                                @else
                                <div class="fw-bold text-dark">Rp {{ number_format($products->price, 0, ',', '.') }}</div>
                                @endif
                            </td>

                            {{-- Stok dan Berat --}}
                            <td>
                                <div>
                                    <span class="badge {{ $products->stock <= 5 ? 'bg-danger-subtle text-danger-emphasis border border-danger-subtle' : 'bg-light text-dark border' }}">
                                        Stok: {{ $products->stock ?? 0 }}
                                    </span>
                                </div>
                                <div class="small text-muted mt-1">
                                    Berat: {{ $products->weight ?? 0 }} gr
                                </div>
                            </td>

                            {{-- Terjual (Sold) --}}
                            <td class="text-center">
                                <span class="fw-semibold text-dark">{{ $products->sold_count ?? 0 }}</span>
                                <div class="text-muted" style="font-size: 0.72rem;">terjual</div>
                            </td>

                            {{-- Badge Featured & Active --}}
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    @if ($products->is_active)
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">Aktif</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle px-2 py-1">Nonaktif</span>
                                    @endif

                                    @if ($products->is_featured)
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1" style="font-size: 0.7rem;">Featured</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="text-center">
                                <form action="{{ route('products.destroy', $products->id) }}" method="POST" class="d-inline">

                                    {{-- Tombol Show (Bisa diakses siapa saja yang bisa melihat index) --}}
                                    @can('show product')
                                        <a href="{{ route('products.show', $products->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="fa-solid fa-list"></i> Show
                                        </a>
                                    @endcan
                                    {{-- Spatie Permission: Hanya tampil jika user punya permission product-edit --}}
                                    @can('edit product')
                                    <a href="{{ route('products.edit', $products->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    @endcan

                                    @csrf
                                    @method('DELETE')

                                    {{-- Spatie Permission: Hanya tampil jika user punya permission product-delete --}}
                                    @can('delete product')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data produk ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                    @endcan

                                </form>
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
            {!! $product->links('pagination::bootstrap-5') !!}
        </div>
        @endif
    </div>

    {{-- Footer Credit --}}
    <p class="text-center text-primary mt-3"><small>Tutorial by ItSolutionStuff.com</small></p>

</div>
@endsection