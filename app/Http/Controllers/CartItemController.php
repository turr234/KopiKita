<?php

namespace App\Http\Controllers;

use App\Models\cart_item;
use App\Models\db_cart;
use App\Models\db_cart_item;
use App\Models\User;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart_item = cart_item::latest()->paginate(10);
        return view('cart_items.index', compact('cart_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('cart_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|foreignId',
            'product_id' => 'required|foreignId',
            'quantity' => 'required|unsignedInteger',
            'price' => 'required|decimal:15,2'
        ]);

        cart_item::create($request->all());
        return redirect()->route('cart_items.index')->with('success', 'Data Berhasil Diatambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(cart_item $cart_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cart_item $id)
    {
        $cart_item = cart_item::findOrFail($id);
        return view('cart_items.edit', compact('cart_item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cart_item $id)
    {
        $request->validate([

        ]);
        $cart_item = cart_item::findOrFail($id);
        $cart_item->update($request->all());

        return redirect()->route('cart_items.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cart_item $cart_item)
    {
        //
    }
}
