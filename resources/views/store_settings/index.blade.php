@extends('layout')

@section('content')
<div class="container-fluid py-4">
    {{-- Notifikasi Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
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
                <h5 class="mb-0 fw-bold text-dark">Daftar Pengaturan Toko</h5>
                <small class="text-muted">Kelola identitas, kontak, dan tautan sosial media toko</small>
            </div>
            <a href="{{ route('store_settings.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Pengaturan
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Profil Toko</th>
                            <th>Kontak</th>
                            <th>Alamat & Tentang</th>
                            <th class="text-center">Sosial Media</th>
                            <th class="text-center">Min. Stok</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($store_setting as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Identitas Toko (Nama, Tagline, Logo, Favicon) --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            @if ($item->logo)
                                                <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="rounded-3 border object-fit-cover" width="46" height="46">
                                            @else
                                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted fw-bold" style="width: 46px; height: 46px; font-size: 0.8rem;">
                                                    NA
                                                </div>
                                            @endif

                                            @if ($item->favicon)
                                                <img src="{{ asset('storage/' . $item->favicon) }}" alt="Favicon" class="position-absolute bottom-0 end-0 rounded-circle border border-white shadow-sm" width="18" height="18" title="Favicon">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->store_name }}</div>
                                            <div class="text-muted small text-truncate" style="max-width: 180px;">{{ $item->tagline ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kontak --}}
                                <td>
                                    <div class="d-flex flex-column gap-1 small">
                                        <span class="text-dark"><i class="bi bi-envelope text-muted me-1"></i>{{ $item->email }}</span>
                                        <span class="text-muted"><i class="bi bi-telephone text-muted me-1"></i>{{ $item->phone }}</span>
                                        @if($item->whatsapp)
                                            <span class="text-success"><i class="bi bi-whatsapp me-1"></i>{{ $item->whatsapp }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Alamat & Tentang --}}
                                <td>
                                    <div class="small text-truncate" style="max-width: 220px;" title="{{ $item->address }}">
                                        <strong>Alamat:</strong> {{ $item->address }}
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 220px;" title="{{ $item->about }}">
                                        <strong>Tentang:</strong> {{ $item->about ?? '-' }}
                                    </div>
                                </td>

                                {{-- Media Sosial (Grup Ikon) --}}
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        @if ($item->instagram_url)
                                            <a href="{{ $item->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-danger p-1" title="Instagram" style="width: 28px; height: 28px; line-height: 1;">IG</a>
                                        @endif
                                        @if ($item->tiktok_url)
                                            <a href="{{ $item->tiktok_url }}" target="_blank" class="btn btn-sm btn-outline-dark p-1" title="TikTok" style="width: 28px; height: 28px; line-height: 1;">TT</a>
                                        @endif
                                        @if ($item->facebook_url)
                                            <a href="{{ $item->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary p-1" title="Facebook" style="width: 28px; height: 28px; line-height: 1;">FB</a>
                                        @endif
                                        @if (!$item->instagram_url && !$item->tiktok_url && !$item->facebook_url)
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Min Stock --}}
                                <td class="text-center">
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                        {{ $item->minimum_stock_warning }} unit
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('store_settings.show', $item->id) }}" class="btn btn-outline-secondary" title="Lihat Detail">Detail</a>
                                        <a href="{{ route('store_settings.edit', $item->id) }}" class="btn btn-outline-primary" title="Ubah Data">Edit</a>
                                        
                                        <form action="{{ route('store_settings.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus Data">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada konfigurasi pengaturan toko yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card Footer untuk Pagination --}}
        @if ($store_setting->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $store_setting->links() }}
            </div>
        @endif
    </div>
</div>
@endsection