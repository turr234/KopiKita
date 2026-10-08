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
                <h5 class="mb-0 fw-bold text-dark">Daftar Item Keranjang (Cart Items)</h5>
                <small class="text-muted">Kelola item produk yang tersimpan di dalam keranjang belanja</small>
            </div>
            <a href="{{ route('cart_items.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Item Keranjang
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 60px;">No</th>
                            <th>ID Keranjang</th>
                            <th>Produk</th>
                            <th class="text-center">Jumlah (Qty)</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($cart_item as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Cart ID (antisipasi typo field card_id / cart_id) --}}
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        #{{ $item->cart_id ?? $item->card_id }}
                                    </span>
                                </td>

                                {{-- Produk Terkait --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($item->product->main_image))
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="rounded-3 border object-fit-cover me-3" 
                                                 width="40" height="40">
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">
                                                {{ $item->product->name ?? 'Produk ID #' . $item->product_id }}
                                            </div>
                                            <div class="small text-muted">
                                                Ref ID: #{{ $item->product_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Jumlah (Quantity) --}}
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-1">
                                        {{ $item->quantity }}x
                                    </span>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('cart_items.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('cart_items.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('cart_items.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada item produk di dalam keranjang.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($cart_item->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $cart_item->links() }}
            </div>
        @endif
    </div>
</div>
@endsection