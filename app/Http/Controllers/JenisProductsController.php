<?php

namespace App\Http\Controllers;

use App\Models\JenisProducts;
use Illuminate\Http\Request;

class JenisProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisProducts = JenisProducts::latest()->paginate(10);

        return view('jenis_products.index', compact('jenisProducts'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_products,name',
            'keterangan' => 'nullable|string',
        ], [
            'name.unique' => 'Nama jenis produk ini sudah ada, gunakan nama lain!'
        ]);

        JenisProducts::create($request->all());

        return redirect()->route('jenis_products.index')->with('success', 'Jenis produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jenisProducts = JenisProducts::findOrFail($id);
        return view('jenis_products.show', compact('jenisProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenisProducts = JenisProducts::findOrFail($id);
        return view('jenis_products.edit', compact('jenisProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'keterangan' => 'required'
        ]);

        $jenisProducts = JenisProducts::findOrFail($id);

        $jenisProducts->update($request->all());

        return redirect()->route('jenis_products.index')
            ->with('success', 'Jenis Produk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenisProducts = JenisProducts::findOrFail($id);

        $jenisProducts->delete();

        return redirect()->route('jenis_products.index')
            ->with('success', 'Jenis Produk deleted successfully.');
    }
}
