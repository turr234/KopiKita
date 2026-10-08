<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\db_cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = cart::latest()->paginate(10);
        return view('carts.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('carts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string'
        ]);

        cart::create($request->all());
        return redirect()->route('carts.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::all();
        $cart = cart::findOrFail($id);
        return view('carts.edit', compact('cart','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|string'
        ]);
        $cart = cart::findOrFail($id);
        $cart->update($request->all());

        return redirect()->route('carts.index')->with('success', 'Data Berhsil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart_items.index')->with('success',"Data Berhasil Dihapus");
    }
}
