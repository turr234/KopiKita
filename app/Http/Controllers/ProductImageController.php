<?php

namespace App\Http\Controllers;

use App\Models\db_product_image;
use App\Models\product;
use App\Models\product_image;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_image = product_image::latest()->paginate(10);
        return view('product_images.index', compact('product_image'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('product_images.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_primary' => 'required|boolean',
            'sort_order' => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('images', 'public');
            $input = $request->all();
            $input['image'] = $filePath;
        }
        product_image::create($request->all());
        return redirect()->route('product_images.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(product_image $product_image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product_image = product_image::findOrFail($id);
        return view('product_images.edit', compact('product_image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_image $id)
    {
        $request->validate([
            'product_id' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_primary' => 'required|boolean',
            'sort_order' => 'required|string'
        ]);
        $product_image = product_image::findOrFail($id);
        $product_image->update($request->all());

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('images', 'public');
            $input = $request->all();
            $input['image'] = $filePath;
        }
        return redirect()->route('product_images.index')->with('success', 'Data Produk Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_image $product_image)
    {
        //
    }
}
