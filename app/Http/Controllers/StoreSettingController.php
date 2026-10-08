<?php

namespace App\Http\Controllers;

use App\Models\db_store_setting;
use App\Models\store_setting;
use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store_setting = store_setting::latest()->paginate(10);
        return view('store_settings.index', compact('store_setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:100',
            'tagline' => 'required|string|max:150',
            'logo' => 'required|string',
            'favicon' => 'required|string|max:255',
            'email' => 'required|string',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
            'address' => 'required|string',
            'instagram_url' => 'required|string',
            'tiktok_url' => 'required|string',
            'facebook_url' => 'required|string',
            'about' => 'required|string',
            'minimum_stock_warning' => 'required|string'

        ]);

        store_setting::create($request->all());
        return redirect()->route('store_settings.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(store_setting $store_setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $store_setting = store_setting::findOrFail($id);
        return view('store_settings.edit', compact('store_setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'store_name' => 'required|string|max:100',
            'tagline' => 'required|string|max:150',
            'logo' => 'required|string',
            'favicon' => 'required|string|max:255',
            'email' => 'required|string',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
            'address' => 'required|string',
            'instagram_url' => 'required|string',
            'tiktok_url' => 'required|string',
            'facebook_url' => 'required|string',
            'about' => 'required|string',
            'minimum_stock_warning' => 'required|string'

        ]);

        $store_setting = store_setting::findOrFail($id);
        $store_setting->update($request->all());

        return redirect()->route('store_settings.index')->with('success', 'Data Produk Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(store_setting $store_setting)
    {
        $store_setting->delete();
        return redirect()->route('store_settings.index')->with('success', 'Data Berhasil Dihapus');
    }
}
