@extends('layout')
@section('content')
    <a href="{{ route('store_settings.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- PERBAIKAN: Menghapus </form> di baris ini agar form membungkus semua input -->
    <form action="{{ route('store_settings.update', $store_setting->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Store Nama</label>
            <!-- PERBAIKAN: Mengubah $store_settings menjadi $store_setting -->
            <input type="text" name="store_name" class="form-control" value="{{ $store_setting->store_name }}">
        </div>
        <div class="mb-3">
            <label>Tagline</label>
            <input type="text" name="tagline" class="form-control" value="{{ $store_setting->tagline }}">
        </div>
        <div class="mb-3">
            <label>Logo</label>
            <input type="text" name="logo" class="form-control" value="{{ $store_setting->logo }}">
        </div>
        <div class="mb-3">
            <label>Favicon</label>
            <input type="text" name="favicon" class="form-control" value="{{ $store_setting->favicon }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $store_setting->email }}">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $store_setting->phone }}">
        </div>
        <div class="mb-3">
            <label>Whatsapp</label>
            <input type="text" name="whatsapp" class="form-control" value="{{ $store_setting->whatsapp }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ $store_setting->address }}">
        </div>
        <div class="mb-3">
            <label>Instagram URL</label>
            <input type="text" name="instagram_url" class="form-control" value="{{ $store_setting->instagram_url }}">
        </div>
        <div class="mb-3">
            <label>Tiktok URL</label>
            <input type="text" name="tiktok_url" class="form-control" value="{{ $store_setting->tiktok_url }}">
        </div>
        <div class="mb-3">
            <label>Facebook URL</label>
            <input type="text" name="facebook_url" class="form-control" value="{{ $store_setting->facebook_url }}">
        </div>
        <div class="mb-3">
            <label>About</label>
            <textarea name="about" class="form-control">{{ $store_setting->about }}</textarea>
        </div>
        <div class="mb-3">
            <label>Minimum Stock Warning</label>
            <input type="number" name="minimum_stock_warning" class="form-control" value="{{ $store_setting->minimum_stock_warning }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Data</button>
    </form> <!-- PERBAIKAN: Tag penutup form dipindah ke paling bawah -->
@endsection
