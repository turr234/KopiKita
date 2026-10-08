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
                <h5 class="mb-0 fw-bold text-dark">Daftar Review Produk</h5>
                <small class="text-muted">Kelola ulasan, penilaian rating, dan visibilitas komentar pembeli</small>
            </div>
            <a href="{{ route('reviews.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Review
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Pengguna & Pesanan</th>
                            <th>Rating & Ulasan</th>
                            <th class="text-center">Lampiran</th>
                            <th class="text-center">Status Tampil</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($review as $item)
                            <tr>
                                {{-- No --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- User & Ref ID (Menggunakan relasi jika ada, atau fallback ke ID) --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $item->user->name ?? 'User ID #' . $item->user_id }}
                                    </div>
                                    <div class="small text-muted">
                                        Produk: <span class="text-dark">{{ $item->product->name ?? '#' . $item->product_id }}</span>
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        Order Item: #{{ $item->order_item_id }}
                                    </div>
                                </td>

                                {{-- Rating & Review Text --}}
                                <td>
                                    {{-- Bintang Rating --}}
                                    <div class="text-warning mb-1" style="font-size: 0.85rem;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item->rating)
                                                ★
                                            @else
                                                <span class="text-muted opacity-25">★</span>
                                            @endif
                                        @endfor
                                        <span class="badge bg-warning-subtle text-warning-emphasis ms-1 border border-warning-subtle py-0">
                                            {{ $item->rating }}/5
                                        </span>
                                    </div>
                                    {{-- Teks Ulasan --}}
                                    <div class="text-muted text-truncate" style="max-width: 280px;" title="{{ $item->review }}">
                                        {{ $item->review ?? '-' }}
                                    </div>
                                </td>

                                {{-- Foto Ulasan --}}
                                <td class="text-center">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Lampiran" class="rounded border object-fit-cover shadow-sm" width="45" height="45">
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                {{-- Status Visibilitas --}}
                                <td class="text-center">
                                    @if ($item->is_visible)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            Tampil
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-1">
                                            Disembunyikan
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('reviews.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('reviews.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('reviews.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus review ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada review produk yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($review->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $review->links() }}
            </div>
        @endif
    </div>
</div>
@endsection