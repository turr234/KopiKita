<?php

namespace App\Http\Controllers;

use App\Models\db_review;
use App\Models\order_item;
use App\Models\product;
use App\Models\review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = review::latest()->paginate(10);
        return view('reviews.index', compact('review'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = product::all();
        $users = User::all();
        $order_items = order_item::all();
        return view('reviews.create', compact('products', 'users', 'order_items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|string',
            'review' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_visible' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('images', 'public');
            $input = $request->all();
            $validated['image'] = $filePath;
            review::create($input);
        }

        return redirect()->route('reviews.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewController $ReviewController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $review = review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, review $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|string',
            'review' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_visible' => 'required|boolean'
        ]);
        $review = review::findOrFail($id);
        $review->update($request->all());

        return redirect()->route('reviews.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Data Berhasil Dihapus');
    }
}
