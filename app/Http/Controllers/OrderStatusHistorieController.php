<?php

namespace App\Http\Controllers;

use App\Models\db_order_status_historie;
use App\Models\order;
use App\Models\order_item;
use App\Models\order_status_historie;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class OrderStatusHistorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_status_historie = order_status_historie::latest()->paginate(10);
        return view('order_status_histories.index', compact('order_status_historie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $orders = order::all();
        return view('order_status_histories.create', compact('orders', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
            'changed_by' => 'required|string'
        ]);
        order_status_historie::create($request->all());
        return redirect()->route('order_status_histories.index')->with('success', 'Data Telah Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(order_status_historie $order_status_historie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order_status_historie $id)
    {
        $order_status_historie = order_status_historie::findOrFail($id);
        return view('order_items.edit', compact($order_status_historie));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order_status_historie $id)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
            'changed_by' => 'required|string'
        ]);
        $order_status_historie = order_status_historie::findOrFail($id);
        $order_status_historie->update($request->all());
        return redirect()->route('order_items.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order_status_historie $order_status_historie)
    {
        //
    }
}
