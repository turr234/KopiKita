<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\cart_item;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return redirect()->route('carts.index')->with('success',"Data Berhasil Dihapus");
    }

    /* =========================================================================
     *  METHOD TAMBAHAN KEBUTUHAN KERANJANG DI LANDING PAGE (CARTS & CART_ITEMS)
     * ========================================================================= */

    /**
     * Ambil Data Keranjang User (AJAX)
     */
    public function getCartData()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'cart' => null
            ]);
        }

        $userCart = cart::with(['items.product', 'items.jenisProduct'])
            ->where('user_id', Auth::id())
            ->first();

        return response()->json([
            'success' => true,
            'cart' => $userCart
        ]);
    }

    /**
     * Tambah/Simpan Produk ke Carts & CartItems (AJAX)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jenis_product_id' => 'nullable|exists:jenis_products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = Auth::id();
        $quantity = $request->quantity ?? 1;

        // 1. Cek atau buat record Carts untuk user
        $userCart = cart::firstOrCreate(['user_id' => $userId]);

        // 2. Ambil data produk
        $product = Product::findOrFail($request->product_id);

        // 3. Cek apakah kombinasi product & jenis_product sudah ada di cart_items
        $cartItem = cart_item::where('cart_id', $userCart->id)
            ->where('product_id', $product->id)
            ->where('jenis_product_id', $request->jenis_product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            cart_item::create([
                'cart_id' => $userCart->id,
                'product_id' => $product->id,
                'jenis_product_id' => $request->jenis_product_id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil disimpan ke keranjang database!'
        ]);
    }

    /**
     * Update Kuantitas CartItem (AJAX)
     */
    public function updateCartItem(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = cart_item::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus CartItem (AJAX)
     */
    public function removeCartItem($id)
    {
        $cartItem = cart_item::findOrFail($id);
        $cartItem->delete();

        return response()->json(['success' => true]);
    }
}