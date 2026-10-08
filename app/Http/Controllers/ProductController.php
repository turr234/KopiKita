<?php

namespace App\Http\Controllers;

use App\Models\db_product;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = product::latest()->paginate(10);
        return view('products.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:180',
            'sku' => 'required|string|max:50',
            'description' => 'required|string',
            'origin' => 'required|string|max:100',
            'tasting_notes' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount_price' => 'required|integer',
            'stock' => 'required|string',
            'weight' => 'required|numeric',
            'main_image' => 'required|file|max:255|mimes:jpeg,gif,png,jpg',
            'is_featured' => 'required|boolean',
            'is_active' => 'required|boolean',
            'sold_count' => 'required|string'
        ]);

        if ($request->hasFile('main_image')) {
            $filepath = $request->file('main_image')->store('main_image', 'public');
            product::create($request->all());
            $input['main_image'] = $filepath;

        }

        
        return redirect()->route('products.index')->with('Success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::where('id', '=', $id)->first();
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:180',
            'sku' => 'required|string|max:50',
            'description' => 'required|string',
            'origin' => 'required|string|max:100',
            'tasting_notes' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount_price' => 'required|integer',
            'stock' => 'required|string',
            'weight' => 'required|string',
            'main_image' => 'required|file|max:255|mimes:jpeg,png,jpg,gif',
            'is_featured' => 'required|boolean',
            'is_active' => 'required|boolean',
            'sold_count' => 'required|string'
        ]);

        

        $product = product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success','Data Berhasil Dihapus');
    }
}
