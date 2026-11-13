<?php

namespace App\Http\Controllers;

use App\Models\addresse;
use App\Models\bank_account;
use App\Models\cart;
use App\Models\cart_item;
use App\Models\order;
use App\Models\order_item;
use App\Models\order_status_historie;
use App\Models\product;
use App\Models\store_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Pastikan pengguna harus login untuk melakukan pemesanan
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan Halaman Checkout Pemesanan
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil data keranjang aktif pengguna
        $cart = cart::where('user_id', $userId)
            ->with(['items.product', 'items.jenisProduct'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('landing_pages.index')
                ->with('error', 'Keranjang belanja Anda masih kosong. Silakan pilih kopi favorit Anda terlebih dahulu.');
        }

        // 2. Hitung subtotal produk
        $subtotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // 3. Ketentuan Promo Ongkir: Gratis ongkir jika belanja >= Rp 150.000
        $shippingCost = ($subtotal >= 150000) ? 0 : 15000;
        $total = $subtotal + $shippingCost;

        // 4. Ambil buku alamat tersimpan milik pengguna
        $addresses = addresse::where('user_id', $userId)->get();
        $primaryAddress = $addresses->firstWhere('is_primary', true) ?? $addresses->first();

        // 5. Ambil data rekening bank aktif untuk transfer
        $bankAccounts = bank_account::where('is_active', true)->get();

        // 6. Ambil pengaturan toko
        $storeSetting = store_setting::first();

        return view('landing_pages.checkout', compact(
            'cart',
            'subtotal',
            'shippingCost',
            'total',
            'addresses',
            'primaryAddress',
            'bankAccounts',
            'storeSetting'
        ));
    }

    /**
     * Fitur 'Beli Langsung' / Instant Buy dari katalog produk
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jenis_product_id' => 'nullable|exists:jenis_products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = Auth::id();
        $quantity = $request->quantity ?? 1;

        $userCart = cart::firstOrCreate(['user_id' => $userId]);
        $product = product::findOrFail($request->product_id);

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

        return redirect()->route('checkout.index');
    }

    /**
     * Proses Pembuatan Pesanan (Submit Order)
     */
    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'shipping_address' => 'required|string',
            'shipping_method' => 'required|string|max:100',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500',
            'address_id' => 'nullable|integer',
            'save_address' => 'nullable'
        ]);

        $userId = Auth::id();

        // 1. Ambil Keranjang
        $cart = cart::where('user_id', $userId)
            ->with(['items.product', 'items.jenisProduct'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('landing_pages.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        DB::beginTransaction();
        try {
            // 2. Hitung Rincian Biaya
            $subtotal = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Tentukan ongkir berdasarkan metode pengiriman
            $shippingMethod = $request->shipping_method;
            $shippingCost = 0;

            if (str_contains(strtolower($shippingMethod), 'ambil di toko') || str_contains(strtolower($shippingMethod), 'pickup')) {
                $shippingCost = 0;
            } elseif (str_contains(strtolower($shippingMethod), 'instan') || str_contains(strtolower($shippingMethod), 'express')) {
                $shippingCost = 25000;
            } else {
                // Reguler kurir: Gratis bila subtotal >= Rp 150.000
                $shippingCost = ($subtotal >= 150000) ? 0 : 15000;
            }

            $discount = 0;
            $total = $subtotal + $shippingCost - $discount;

            // 3. Simpan Alamat jika diminta
            $addressId = $request->address_id;
            if ($request->has('save_address') && !$addressId) {
                $savedAddress = addresse::create([
                    'user_id' => $userId,
                    'label' => 'Alamat Utama',
                    'recipient_name' => $request->recipient_name,
                    'phone' => $request->recipient_phone,
                    'province' => $request->province,
                    'city' => $request->city,
                    'district' => $request->district,
                    'village' => $request->village ?? '-',
                    'postal_code' => $request->postal_code ?? '-',
                    'full_address' => $request->shipping_address,
                    'is_primary' => true
                ]);
                $addressId = $savedAddress->id;
            }

            // 4. Generate Nomor Pesanan Unik: KPK-YYYYMMDD-XXXXX
            $orderNumber = 'KPK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 5. Simpan Record Pesanan (orders)
            $order = order::create([
                'user_id' => $userId,
                'address_id' => $addressId,
                'order_number' => $orderNumber,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village ?? '-',
                'postal_code' => $request->postal_code ?? '-',
                'shipping_address' => $request->shipping_address,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'shipping_method' => $request->shipping_method,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => $request->notes,
            ]);

            // 6. Simpan Item Pesanan (order_items) & Kurangi Stok
            foreach ($cart->items as $cartItem) {
                $productName = $cartItem->product ? $cartItem->product->name : 'Kopi Spesial';
                if ($cartItem->jenisProduct) {
                    $productName .= ' (' . $cartItem->jenisProduct->name . ')';
                }

                order_item::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $productName,
                    'product_sku' => $cartItem->product ? $cartItem->product->sku : null,
                    'product_image' => $cartItem->product ? $cartItem->product->main_image : null,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);

                // Kurangi stok jika stok berbentuk angka
                if ($cartItem->product && is_numeric($cartItem->product->stock)) {
                    $newStock = max(0, ((int)$cartItem->product->stock) - $cartItem->quantity);
                    $cartItem->product->update(['stock' => (string)$newStock]);
                }
            }

            // 7. Simpan Riwayat Status Pesanan (order_status_histories)
            order_status_historie::create([
                'order_id' => $order->id,
                'status' => 'waiting_payment',
                'description' => 'Pesanan baru berhasil dibuat oleh pelanggan melalui checkout website. Menunggu pembayaran.',
                'changed_by' => $userId,
            ]);

            // 8. Kosongkan Keranjang Belanja Pengguna
            $cart->items()->delete();

            DB::commit();

            // 9. Jika Metode Pembayaran QRIS atau DOKU Payment Gateway
            $isDokuMethod = in_array($request->payment_method, ['qris', 'doku', 'doku_qris', 'doku_va']);
            if ($isDokuMethod) {
                try {
                    $dokuService = app(\App\Services\DokuService::class);
                    $paymentChannels = ($request->payment_method === 'doku_va')
                        ? ['VIRTUAL_ACCOUNT_BCA', 'VIRTUAL_ACCOUNT_BANK_MANDIRI', 'VIRTUAL_ACCOUNT_BRI', 'VIRTUAL_ACCOUNT_BNI']
                        : ['QRIS'];

                    $dokuResult = $dokuService->createCheckout($order, [
                        'name' => $order->recipient_name,
                        'email' => Auth::user()->email ?? 'pembeli@kopikita.id',
                        'phone' => $order->recipient_phone,
                        'address' => $order->shipping_address,
                    ], $paymentChannels);

                    // Jika metode Virtual Account dan ada link pembayaran, bisa redirect ke payment_url
                    if ($request->payment_method === 'doku_va' && !empty($dokuResult['payment_url'])) {
                        return redirect()->away($dokuResult['payment_url']);
                    }
                } catch (\Throwable $dokuError) {
                    \Illuminate\Support\Facades\Log::warning("Gagal inisiasi DOKU di Checkout: " . $dokuError->getMessage());
                }
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Sukses Pemesanan & Instruksi Pembayaran
     */
    public function success($order_number)
    {
        $userId = Auth::id();

        $order = order::where('order_number', $order_number)
            ->where('user_id', $userId)
            ->with(['items', 'address'])
            ->firstOrFail();

        $bankAccounts = bank_account::where('is_active', true)->get();
        $storeSetting = store_setting::first();
        $dokuService = app(\App\Services\DokuService::class);
        $qrisImageUrl = $dokuService->getQrisImageUrl($order);

        return view('landing_pages.order_success', compact('order', 'bankAccounts', 'storeSetting', 'qrisImageUrl'));
    }

    /**
     * Halaman Riwayat Pesanan Saya untuk Pelanggan
     */
    public function myOrders()
    {
        $userId = Auth::id();

        $orders = order::where('user_id', $userId)
            ->with(['items'])
            ->latest()
            ->paginate(10);

        return view('landing_pages.my_orders', compact('orders'));
    }

    /**
     * Halaman Detail Pesanan Pelanggan
     */
    public function myOrderDetail($order_number)
    {
        $userId = Auth::id();

        $order = order::where('order_number', $order_number)
            ->where('user_id', $userId)
            ->with(['items', 'statusHistories'])
            ->firstOrFail();

        $bankAccounts = bank_account::where('is_active', true)->get();
        $storeSetting = store_setting::first();
        $dokuService = app(\App\Services\DokuService::class);
        $qrisImageUrl = $dokuService->getQrisImageUrl($order);

        return view('landing_pages.my_order_detail', compact('order', 'bankAccounts', 'storeSetting', 'qrisImageUrl'));
    }
}
