@extends('layout')
@section('content')
    <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <table class="table table-bordered w-50">
        <tr>
            <th>Name</th>
            <td>{{$db_user->name}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$db_user->email}}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{$db_user->phone}}</td>
        </tr>
        <tr>
            <th>Password</th>
            <td>{{$db_user->password}}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{$db_user->role}}</td>
        </tr>
        <tr>
            <th>Avatar</th>
            <td>{{$db_user->avatar}}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{$db_user->status}}</td>
        </tr>
    </table>
@endsection