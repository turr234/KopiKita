<?php

namespace App\Http\Controllers;

use App\Models\db_order_item;
use App\Models\order;
use App\Models\order_item;
use App\Models\product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_item = order_item::latest()->paginate(10);
        return view('order_items.index', compact('order_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = product::all();
        $product_sku = product::all();
        $orders = order::all();
        return view('order_items.create', compact('products', 'product_sku', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'product_id' => 'required|string',
            'product_name' => 'required|string|max:100',
            'product_sku' => 'required|string|max:50',
            'product_image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'price' => 'required|string',
            'quantity' => 'required|string',
            'subtotal' => 'required|string'
        ]);

        // dd($request->all());

        if ($request->hasFile('product_image')) {
            $filePath = $request->file('product_image')->store('product_image', 'public');
            order_item::create($request->all());
            $input['image'] = $filePath;
        }


        return redirect()->route('order_items.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(order_item $order_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order_item $id)
    {
        $order_item = order_item::findOrFail($id);
        return view('order_items.edit', compact('order_item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order_item $id)
    {
        $request->validate([
            'order_id' => 'required|string',
            'product_id' => 'required|string',
            'product_name' => 'required|string|max:255',
            'product_sku' => 'required|string|max:50',
            'product_image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'price' => 'required|string',
            'quantity' => 'required|string',
            'subtotal' => 'required|string'
        ]);
        $order_item = order_item::findOrFail($id);
        $order_item->update($request->all());
        return redirect()->route('order_items.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order_item $order_item)
    {
        $order_item->delete();
        return redirect()->route('order_items.index')->with('success', 'Data Berhasil Dihapus');
    }
}
