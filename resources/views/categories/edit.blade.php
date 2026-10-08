@extends('layout')
@section('content')
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('categories.update', $categories->id) }}" method="post"></form>
    @csrf
    @method('PUT')
    <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form_control" value="{{ $categories->name }}">
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form_control" value="{{ $categories->slug }}">
        </div>
        <div class="mb-3">
            <label>Desctiption</label>
            <input type="text" name="description" class="form_control" value="{{ $categories->description }}">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="text" name="image" class="form_control" value="{{ $categories->image }}">
        </div>
        <div class="mb-3">
            <label>Is_active</label>
            <input type="text" name="is_active" class="form_control" value="{{ $categories->is_active }}">
        </div>
    <button type="submit" class="btn btn-secondary">Update</button>
@endsection