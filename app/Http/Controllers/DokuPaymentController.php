<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DokuPaymentController extends Controller
{
    protected DokuService $dokuService;

    public function __construct(DokuService $dokuService)
    {
        $this->dokuService = $dokuService;
    }

    /**
     * Inisiasi atau Lanjutkan Pembayaran DOKU Checkout untuk Pesanan
     *
     * @param string $order_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pay($order_number)
    {
        $userId = Auth::id();

        $order = order::where('order_number', $order_number)
            ->where('user_id', $userId)
            ->with(['items.product', 'user'])
            ->firstOrFail();

        // Jika pesanan sudah lunas, arahkan langsung ke halaman sukses
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Pesanan ini telah lunas dibayar.');
        }

        // Jika sudah memiliki payment_url aktif yang tersimpan, langsung redirect ke DOKU
        if (!empty($order->payment_url)) {
            return redirect()->away($order->payment_url);
        }

        // Buat sesi pembayaran baru ke DOKU API
        $result = $this->dokuService->createCheckout($order, [
            'name' => $order->recipient_name,
            'email' => $order->user->email ?? 'pembeli@kopikita.id',
            'phone' => $order->recipient_phone,
            'address' => $order->shipping_address,
        ]);

        if ($result['success'] && !empty($result['payment_url'])) {
            return redirect()->away($result['payment_url']);
        }

        // Jika DOKU API mengembalikan pesan gagal, catat dan arahkan ke detail pesanan dengan pesan
        Log::warning("Gagal mendapatkan link DOKU Checkout untuk #{$order_number}", $result);

        return redirect()->route('checkout.success', $order->order_number)
            ->with('warning', 'Sistem pembayaran online DOKU sedang memproses. Anda juga dapat melakukan transfer bank manual atau mencoba lagi dalam beberapa saat.');
    }

    /**
     * Webhook / HTTP Notification Endpoint dari DOKU
     * DOKU mengirimkan POST ke URL ini saat pelanggan menyelesaikan transaksi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notification(Request $request)
    {
        Log::info("Menerima Webhook HTTP Notification dari DOKU", [
            'headers' => $request->headers->all(),
            'body' => $request->all()
        ]);

        // 1. Verifikasi Signature DOKU
        $isValid = $this->dokuService->verifyNotification($request);

        if (!$isValid) {
            Log::warning("Signature webhook DOKU tidak valid!", [
                'received_signature' => $request->header('Signature'),
                'request_id' => $request->header('Request-Id')
            ]);
            // Catatan: Tetap izinkan pemrosesan jika di sandbox dan hash signature opsional untuk kemudahan dev
            if (app()->environment('production')) {
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        // 2. Proses update data pesanan
        $payload = $request->all();
        $processResult = $this->dokuService->processNotification($payload);

        return response()->json($processResult, 200);
    }

    /**
     * Cek Status Pembayaran Pesanan via AJAX / JSON
     *
     * @param string $order_number
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus($order_number)
    {
        $userId = Auth::id();

        $order = order::where('order_number', $order_number)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return response()->json(['status' => 'not_found'], 404);
        }

        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'is_paid' => ($order->payment_status === 'paid'),
            'payment_url' => $order->payment_url
        ]);
    }
}
