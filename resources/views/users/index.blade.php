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
                <h5 class="mb-0 fw-bold text-dark">Daftar Pengguna</h5>
                <small class="text-muted">Kelola akun, role, dan hak akses pengguna sistem</small>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-medium">
                + Tambah Pengguna
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">No</th>
                            <th>Pengguna</th>
                            <th>Kontak</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($users as $item)
                            <tr>
                                {{-- Nomor --}}
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>

                                {{-- Avatar & Nama --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->avatar)
                                            <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->name }}" class="rounded-circle object-fit-cover me-3 border" width="40" height="40">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-3 border border-primary-subtle" style="width: 40px; height: 40px; font-size: 0.85rem;">
                                                {{ strtoupper(substr($item->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                            <div class="text-muted small">ID: #{{ $item->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email & Telepon --}}
                                <td>
                                    <div class="small text-dark fw-medium">{{ $item->email }}</div>
                                    <div class="small text-muted">{{ $item->phone ?? '-' }}</div>
                                </td>

                                {{-- Role --}}
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2 py-1 text-capitalize">
                                        {{ $item->role ?? 'User' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    @php
                                        $status = strtolower($item->status);
                                        $badgeClass = match($status) {
                                            'active', 'aktif' => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                            'inactive', 'nonaktif' => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                            'pending' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                            default => 'bg-light text-secondary border-secondary-subtle',
                                        };
                                    @endphp
                                    <span class="badge border px-2 py-1 text-capitalize {{ $badgeClass }}">
                                        {{ $item->status ?? 'Unknown' }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('users.show', $item->id) }}" class="btn btn-outline-secondary" title="Detail">Detail</a>
                                        <a href="{{ route('users.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">Edit</a>

                                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus data pengguna ini?')" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data pengguna yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card Footer untuk Pagination --}}
        @if ($users->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection