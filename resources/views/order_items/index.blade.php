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
                <h5 class="mb-0 fw-bold text-dark">Daftar Item Pesanan (Order Items)</h5>
                <small class="text-muted">Rincian produk, kuantitas, dan harga subtotal per item transaksi</small>
            </div>
            <a href="{{ route('order_items.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Item
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>No. Order</th>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Jumlah (Qty)</th>
                            <th>Subtotal</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($order_item as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Order ID / Referensi --}}
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        #{{ $item->order->order_number ?? $item->order_id }}
                                    </span>
                                </td>

                                {{-- Gambar, Nama Produk, SKU & ID Produk --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->product_image)
                                            <img src="{{ asset('storage/' . $item->product_image) }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 class="rounded-3 border object-fit-cover me-3" 
                                                 width="45" height="45">
                                        @else
                                            <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted me-3" 
                                                 style="width: 45px; height: 45px; font-size: 0.75rem;">
                                                No Img
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $item->product_name }}</div>
                                            <div class="small text-muted">
                                                SKU: <span class="fw-medium text-secondary">{{ $item->product_sku ?? '-' }}</span> 
                                                <span class="mx-1">•</span> ID: #{{ $item->product_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Harga Satuan --}}
                                <td>
                                    <span class="text-dark">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Kuantitas --}}
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-1">
                                        {{ $item->quantity }}x
                                    </span>
                                </td>

                                {{-- Subtotal --}}
                                <td>
                                    <span class="fw-bold text-success">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('order_items.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('order_items.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('order_items.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada item pesanan yang terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($order_item->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $order_item->links() }}
            </div>
        @endif
    </div>
</div>
@endsection