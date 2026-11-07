@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Card Detail --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h5 mb-0 fw-bold text-dark">Show User</h2>
                        <small class="text-muted">Informasi detail data pengguna</small>
                    </div>
                    <a class="btn btn-primary btn-sm px-3" href="{{ route('users.index') }}">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        {{-- Kolom Kiri: Foto Avatar --}}
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded shadow-sm object-fit-cover" width="150" height="150">
                            @else
                                <div class="rounded shadow-sm bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <h5 class="mt-3 mb-1 fw-bold text-dark">{{ $user->name }}</h5>
                            <p class="text-muted small mb-0">{{ $user->email }}</p>
                        </div>

                        {{-- Kolom Kanan: Detail Informasi --}}
                        <div class="col-md-8">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <th class="text-secondary w-25"><strong>Name:</strong></th>
                                        <td class="fw-medium">{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-secondary"><strong>Email:</strong></th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-secondary"><strong>Phone:</strong></th>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-secondary"><strong>Roles:</strong></th>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                    <label class="badge bg-success px-2 py-1 text-capitalize me-1">{{ $v }}</label>
                                                @endforeach
                                            @else
                                                <label class="badge bg-secondary px-2 py-1">User</label>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-secondary"><strong>Status:</strong></th>
                                        <td>
                                            @php
                                                $status = strtolower($user->status ?? '');
                                                $badgeClass = match($status) {
                                                    'active', 'aktif' => 'bg-success-subtle text-success-emphasis border-success-subtle',
                                                    'inactive', 'nonaktif' => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
                                                    'pending' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                                    default => 'bg-light text-secondary border-secondary-subtle',
                                                };
                                            @endphp
                                            <span class="badge border px-2 py-1 text-capitalize {{ $badgeClass }}">
                                                {{ $user->status ?? 'Unknown' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection