<?php

namespace App\Http\Controllers;

use App\Models\bank_account;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Payment;
use App\Models\BankAccount; // Pastikan model BankAccount di-import
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::latest()->paginate(10);
        return view('payments.index', compact('payment'));
    }

    public function create()
    {
        $users = User::all();
        $order = Order::all();
        // Ambil data rekening bank dari database untuk dropdown
        $bank_accounts = bank_account::all();

        return view('payments.create', compact('order', 'bank_accounts', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'         => 'required|string',
            'bank_account_id'  => 'required|string',
            'payment_code'     => 'required|string|max:50',
            'method'           => 'required|string',
            'sender_name'      => 'required|string|max:100',
            'sender_bank'      => 'required|string|max:100',
            'amount'           => 'required|numeric',
            'proof_image'      => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
            'status'           => 'required|string',
            'rejection_reason' => 'nullable|string',
            'verified_by'      => 'nullable|string',
            'verified_at'      => 'nullable|string'
        ]);

        if ($request->hasFile('proof_image')) {
            $validated['proof_image'] = $request->file('proof_image')->store('proof_image', 'public');
        }

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        // Kirim juga data order dan bank account agar dropdown di form edit bisa berfungsi
        $order = Order::all();
        $bank_accounts = bank_account::all();

        return view('payments.edit', compact('payment', 'order', 'bank_accounts'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'order_id'         => 'required|string',
            'bank_account_id'  => 'required|string',
            'payment_code'     => 'required|string|max:50',
            'method'           => 'required|string',
            'sender_name'      => 'required|string|max:100',
            'sender_bank'      => 'required|string|max:100',
            'amount'           => 'required|numeric',
            'proof_image'      => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'status'           => 'required|string',
            'rejection_reason' => 'nullable|string',
            'verified_by'      => 'nullable|string',
            'verified_at'      => 'nullable|string'
        ]);

        if ($request->hasFile('proof_image')) {
            $validated['proof_image'] = $request->file('proof_image')->store('proof_image', 'public');
        }

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Data Berhasil Dihapus');
    }
}
