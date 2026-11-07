@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Alert Error Validasi --}}
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                        <strong class="mb-0">Whoops!</strong>&nbsp;There were some problems with your input.
                    </div>
                    <ul class="mb-0 ps-4 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Form --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h5 mb-0 fw-bold text-dark">Edit User</h2>
                        <small class="text-muted">Perbarui informasi data pengguna</small>
                    </div>
                    <a class="btn btn-primary btn-sm px-3" href="{{ route('users.index') }}">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    {{-- enctype="multipart/form-data" wajib ada untuk upload file (Avatar) --}}
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="fw-semibold small text-secondary mb-1"><strong>Name:</strong> <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" placeholder="Name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="fw-semibold small text-secondary mb-1"><strong>Email:</strong> <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" placeholder="Email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="fw-semibold small text-secondary mb-1"><strong>Phone:</strong> <span class="text-danger">*</span></label>
                                    <input type="text" id="phone" name="phone" placeholder="08xxxxxxxxxx" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}" required>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="fw-semibold small text-secondary mb-1"><strong>Status:</strong> <span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="fw-semibold small text-secondary mb-1"><strong>Password:</strong></label>
                                    <input type="password" id="password" name="password" placeholder="Password" 
                                           class="form-control @error('password') is-invalid @enderror">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm-password" class="fw-semibold small text-secondary mb-1"><strong>Confirm Password:</strong></label>
                                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" 
                                           class="form-control">
                                </div>
                            </div>

                            {{-- Role (Multiple) --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roles" class="fw-semibold small text-secondary mb-1"><strong>Role:</strong> <span class="text-danger">*</span></label>
                                    <select name="roles[]" class="form-control @error('roles') is-invalid @enderror" multiple="multiple" required style="height: 100px;">
                                        @foreach ($roles as $value => $label)
                                            <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tahan tombol Ctrl/Cmd untuk memilih lebih dari satu role.</small>
                                </div>
                            </div>

                            {{-- Avatar --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avatar" class="fw-semibold small text-secondary mb-1"><strong>Avatar:</strong></label>
                                    
                                    {{-- Preview Avatar Lama --}}
                                    @if($user->avatar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current Avatar" class="rounded border object-fit-cover" width="60" height="60">
                                        </div>
                                    @endif

                                    <input type="file" id="avatar" name="avatar" 
                                           class="form-control @error('avatar') is-invalid @enderror" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <small class="text-muted">Upload gambar baru untuk mengganti avatar lama.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Footer Credit --}}
            <p class="text-center text-primary mt-3"><small>Tutorial by ItSolutionStuff.com</small></p>

        </div>
    </div>
</div>
@endsection