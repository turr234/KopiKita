@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @session('success')
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                <div>{{ $value }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h5 mb-0 fw-bold text-dark">User Management</h2>
                <small class="text-muted">Kelola data pengguna dan role</small>
            </div>
            @can('create users')
                <a class="btn btn-success btn-sm px-3 py-2 fw-medium" href="{{ route('users.create') }}">
                    <i class="fa fa-plus me-1"></i> Create New User
                </a>
            @endcan
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="text-center py-3" style="width: 80px;">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 250px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') ?: 'User' }}</td>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : ($user->status === 'inactive' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($user->status ?? 'unknown') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('view users')
                                        <a class="btn btn-info btn-sm text-white" href="{{ route('users.show', $user->id) }}" title="Detail">
                                            <i class="fa-solid fa-list"></i> Show
                                        </a>
                                    @endcan
                                    @can('edit users')
                                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                    @endcan
                                    @can('delete users')
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" title="Delete">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <p class="mb-0">Belum ada data pengguna yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                {!! $users->links('pagination::bootstrap-5') !!}
            </div>
        @endif
    </div>
</div>
@endsection
