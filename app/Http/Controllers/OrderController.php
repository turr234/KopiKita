<?php

namespace App\Http\Controllers;

use App\Models\addresse;
use App\Models\db_order;
use App\Models\order;
use App\Models\order_status_historie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = order::with('user')->latest()->paginate(10);
        return view('orders.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $address = addresse::all();
        // dd($address);
        $users = User::all();
        return view('orders.create', compact('users', 'address'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address_id' => 'nullable|integer',
            'order_number' => 'required|string|max:50|unique:orders,order_number',
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'shipping_address' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'shipping_method' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'cancellation_reason' => 'nullable|string',
            'paid_at' => 'nullable|date',
            'shipped_at' => 'nullable|date',
            'cancelled_at' => 'nullable|date',
            'completed_at' => 'nullable|date'
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;

        order::create($validated);
        return redirect()->route('orders.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        $order->load(['user', 'items.product', 'address', 'statusHistories']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        $users = User::all();
        return view('orders.edit', compact('order', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address_id' => 'nullable|integer',
            'order_number' => 'required|string|max:50|unique:orders,order_number,' . $order->id,
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'shipping_address' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'shipping_method' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'cancellation_reason' => 'nullable|string',
            'paid_at' => 'nullable|date',
            'shipped_at' => 'nullable|date',
            'cancelled_at' => 'nullable|date',
            'completed_at' => 'nullable|date'
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;

        $oldStatus = $order->status;
        $order->update($validated);

        if ($oldStatus !== $order->status) {
            order_status_historie::create([
                'order_id' => $order->id,
                'status' => ($order->status === 'pending') ? 'waiting_payment' : $order->status,
                'description' => 'Status pesanan diperbarui oleh admin menjadi ' . strtoupper($order->status) . '.',
                'changed_by' => Auth::id(),
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Aksi Cepat Admin/Staff: Ubah Status Pesanan, Resi Kurir, dan Status Bayar
     */
    public function updateStatus(Request $request, order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,failed',
            'tracking_number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'cancellation_reason' => 'nullable|string|max:255'
        ]);

        $newStatus = $request->status;
        $updates = ['status' => $newStatus];

        if ($request->filled('payment_status')) {
            $updates['payment_status'] = $request->payment_status;
            if ($request->payment_status === 'paid' && !$order->paid_at) {
                $updates['paid_at'] = now();
            }
        }

        if ($request->filled('tracking_number')) {
            $updates['tracking_number'] = $request->tracking_number;
        }

        if ($newStatus === 'shipped') {
            $updates['shipped_at'] = now();
        } elseif ($newStatus === 'completed') {
            $updates['completed_at'] = now();
        } elseif ($newStatus === 'cancelled') {
            $updates['cancelled_at'] = now();
            if ($request->filled('cancellation_reason')) {
                $updates['cancellation_reason'] = $request->cancellation_reason;
            }
        }

        $order->update($updates);

        $statusDescriptions = [
            'pending' => 'Pesanan menunggu pembayaran.',
            'processing' => 'Pesanan diterima & mulai diproses oleh barista (Roasting / Packing).',
            'shipped' => 'Pesanan telah dikirim ke kurir' . ($order->tracking_number ? ' dengan No. Resi: ' . $order->tracking_number : '') . '.',
            'completed' => 'Pesanan telah selesai dan berhasil diterima oleh pelanggan.',
            'cancelled' => 'Pesanan dibatalkan oleh pihak toko.' . ($request->cancellation_reason ? ' Alasan: ' . $request->cancellation_reason : ''),
        ];

        $desc = $request->description ?: ($statusDescriptions[$newStatus] ?? 'Status pesanan diperbarui menjadi ' . $newStatus);

        order_status_historie::create([
            'order_id' => $order->id,
            'status' => ($newStatus === 'pending') ? 'waiting_payment' : $newStatus,
            'description' => $desc,
            'changed_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Status pesanan #' . $order->order_number . ' berhasil diubah menjadi ' . strtoupper($newStatus) . '!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data Berhasil Dihapus');
    }
}
