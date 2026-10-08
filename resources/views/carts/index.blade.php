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
                <h5 class="mb-0 fw-bold text-dark">Daftar Keranjang Belanja</h5>
                <small class="text-muted">Kelola sesi keranjang aktif milik pengguna</small>
            </div>
            <a href="{{ route('carts.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Keranjang
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 60px;">No</th>
                            <th>ID Keranjang</th>
                            <th>Pengguna</th>
                            <th>Jumlah Item</th>
                            <th>Terakhir Diperbarui</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($cart as $item)
                            <tr>
                                {{-- Nomor Iterasi --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- ID Keranjang --}}
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        #{{ $item->id }}
                                    </span>
                                </td>

                                {{-- Pengguna Pemilik Keranjang --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $item->user->name ?? 'User ID #' . $item->user_id }}
                                    </div>
                                    <div class="small text-muted">
                                        ID Pengguna: #{{ $item->user_id }}
                                    </div>
                                </td>

                                {{-- Total Item (jika ada relasi cartItems/items) --}}
                                <td>
                                    @if(isset($item->items))
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-1">
                                            {{ $item->items->count() }} item
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                {{-- Waktu Pembaruan --}}
                                <td>
                                    <div class="small text-dark">
                                        {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $item->updated_at ? $item->updated_at->diffForHumans() : '' }}
                                    </div>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('carts.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('carts.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('carts.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus keranjang ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data keranjang yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($cart->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $cart->links() }}
            </div>
        @endif
    </div>
</div>
@endsection