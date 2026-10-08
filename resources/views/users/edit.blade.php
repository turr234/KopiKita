@extends('layout')
@section('content')
    <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="{{ $user->email }}">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="text" name="password" class="form-control" value="{{ $user->password }}">
    </div>
    <div class="mb-3">
        <label>Role</label>
        <input type="text" name="role" class="form-control" value="{{ $user->role }}">
    </div>
    <div class="mb-3">
        <label>Avatar</label>
        <input type="text" name="avatar" class="form-control" value="{{ $user->avatar }}">
    </div>
    <div class="mb-3">
        <label>Status</label>
        <input type="text" name="status" class="form-control" value="{{ $user->status }}">
    </div>
    <button type="submit" class="btn btn-secondary">Update</button>
    </form>
@endsection