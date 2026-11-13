<?php

namespace App\Services;

use App\Models\order;
use App\Models\order_status_historie;
use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokuService
{
    protected string $clientId;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId = trim((string) config('services.doku.client_id', env('CLIENT_ID', '')));
        $this->apiKey = trim((string) config('services.doku.api_key', env('API_KEY', '')));
        $this->baseUrl = rtrim(trim((string) config('services.doku.base_url', env('BASE_URL', 'https://api-sandbox.doku.com'))), '/');
    }

    /**
     * Dapatkan Client ID aktif
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Dapatkan Base URL aktif
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Cek apakah konfigurasi DOKU lengkap
     */
    public function isConfigured(): bool
    {
        return !empty($this->clientId) && !empty($this->apiKey) && !empty($this->baseUrl);
    }

    /**
     * Buat Sesi Pembayaran DOKU Checkout
     *
     * @param order $order
     * @param array $customer
     * @param array $paymentMethods
     * @return array
     */
    public function createCheckout(order $order, array $customer = [], array $paymentMethods = ['QRIS']): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Konfigurasi DOKU Payment Gateway belum lengkap pada file .env (CLIENT_ID, API_KEY, BASE_URL).'
            ];
        }

        $targetPath = '/checkout/v1/payment';
        $fullUrl = $this->baseUrl . $targetPath;

        // Line items dari pesanan
        $lineItems = [];
        if ($order->relationLoaded('items') || method_exists($order, 'items')) {
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'name' => Str::limit($item->product_name ?? 'Kopi Spesial', 50, ''),
                    'price' => (int) round($item->price),
                    'quantity' => (int) $item->quantity
                ];
            }
        }

        // Tambahkan ongkir sebagai line item jika ada
        if ($order->shipping_cost > 0) {
            $lineItems[] = [
                'name' => 'Ongkos Kirim (' . Str::limit($order->shipping_method ?? 'Kurir', 30, '') . ')',
                'price' => (int) round($order->shipping_cost),
                'quantity' => 1
            ];
        }

        // Payload Request Body untuk DOKU Checkout (Fokus pada QRIS agar tidak meminta login app DOKU)
        $payload = [
            'order' => [
                'amount' => (int) round($order->total),
                'invoice_number' => (string) $order->order_number,
                'currency' => 'IDR',
                'callback_url' => route('checkout.success', $order->order_number),
                'auto_redirect' => true,
            ],
            'payment' => [
                'payment_due_date' => 60, // Batas waktu pembayaran: 60 menit
                'payment_method_types' => !empty($paymentMethods) ? $paymentMethods : ['QRIS']
            ],
            'customer' => [
                'id' => (string) $order->user_id,
                'name' => (string) ($customer['name'] ?? $order->recipient_name),
                'email' => (string) ($customer['email'] ?? $order->user->email ?? 'pembeli@kopikita.id'),
                'phone' => (string) ($customer['phone'] ?? $order->recipient_phone),
                'address' => (string) ($customer['address'] ?? $order->shipping_address),
            ]
        ];

        if (!empty($lineItems)) {
            $payload['order']['line_items'] = $lineItems;
        }

        $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $digest = base64_encode(hash('sha256', $jsonBody, true));
        $requestId = (string) Str::uuid();
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");

        // Format Signature Komponen DOKU Checkout (Non-SNAP):
        // Client-Id:\nRequest-Id:\nRequest-Timestamp:\nRequest-Target:\nDigest:
        $componentSignature = "Client-Id:" . $this->clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digest;

        $rawHmac = hash_hmac('sha256', $componentSignature, $this->apiKey, true);
        $signature = 'HMACSHA256=' . base64_encode($rawHmac);

        try {
            Log::info("Mengirim Request DOKU Checkout ke: {$fullUrl}", [
                'invoice_number' => $order->order_number,
                'amount' => $order->total,
                'request_id' => $requestId,
                'client_id' => $this->clientId
            ]);

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Digest' => $digest,
                'Signature' => $signature,
                'Content-Type' => 'application/json'
            ])
            ->timeout(20)
            ->withBody($jsonBody, 'application/json')
            ->post($fullUrl);

            $status = $response->status();
            $body = $response->json();

            Log::info("Respon DOKU Checkout ({$status}):", ['body' => $body]);

            // DOKU mengembalikan URL di dalam properti response['payment']['url']
            if ($status >= 200 && $status < 300 && isset($body['payment']['url'])) {
                $paymentUrl = $body['payment']['url'];

                // Simpan tautan pembayaran di pesanan
                $order->update(['payment_url' => $paymentUrl]);

                return [
                    'success' => true,
                    'payment_url' => $paymentUrl,
                    'data' => $body
                ];
            }

            // Jika error dari DOKU
            $errorMessage = $body['error']['message'] ?? $body['message'] ?? 'Gagal membuat sesi pembayaran DOKU.';
            return [
                'success' => false,
                'message' => $errorMessage,
                'status' => $status,
                'data' => $body
            ];

        } catch (\Throwable $e) {
            Log::error("Exception saat memanggil DOKU Checkout API: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi ke server DOKU Payment Gateway: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verifikasi Tanda Tangan Webhook / HTTP Notification dari DOKU
     *
     * @param Request $request
     * @return bool
     */
    public function verifyNotification(Request $request): bool
    {
        $clientIdHeader = $request->header('Client-Id');
        $requestId = $request->header('Request-Id');
        $timestamp = $request->header('Request-Timestamp');
        $incomingSignature = $request->header('Signature');
        $target = $request->getRequestUri();

        // Ambil raw JSON body
        $rawBody = $request->getContent();
        $digest = base64_encode(hash('sha256', $rawBody, true));

        // Format component string
        $componentSignature = "Client-Id:" . $clientIdHeader . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $target . "\n" .
            "Digest:" . $digest;

        $expectedSignature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $componentSignature, $this->apiKey, true));

        if (hash_equals($expectedSignature, (string)$incomingSignature)) {
            return true;
        }

        // Fallback jika Request-Target hanya path tanpa query string
        $pathOnly = '/' . ltrim($request->path(), '/');
        $componentSignatureAlt = "Client-Id:" . $clientIdHeader . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $pathOnly . "\n" .
            "Digest:" . $digest;

        $expectedSignatureAlt = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $componentSignatureAlt, $this->apiKey, true));

        return hash_equals($expectedSignatureAlt, (string)$incomingSignature);
    }

    /**
     * Tangani Data Notifikasi Pembayaran Berhasil dari DOKU Webhook
     *
     * @param array $payload
     * @return array
     */
    public function processNotification(array $payload): array
    {
        // DOKU mengirimkan order.invoice_number dan status transaksi
        $invoiceNumber = $payload['order']['invoice_number'] ?? null;
        $transactionStatus = strtoupper($payload['transaction']['status'] ?? 'SUCCESS');
        $amount = $payload['order']['amount'] ?? 0;
        $channel = $payload['channel']['id'] ?? 'DOKU';

        if (!$invoiceNumber) {
            return ['status' => 'error', 'message' => 'No invoice number provided in payload'];
        }

        $order = order::where('order_number', $invoiceNumber)->first();
        if (!$order) {
            return ['status' => 'error', 'message' => "Order #{$invoiceNumber} not found"];
        }

        Log::info("Memproses notifikasi DOKU untuk Pesanan #{$invoiceNumber}", [
            'status' => $transactionStatus,
            'amount' => $amount
        ]);

        if ($transactionStatus === 'SUCCESS') {
            // Update Order
            $order->update([
                'payment_status' => 'paid',
                'status' => ($order->status === 'pending') ? 'processing' : $order->status,
                'paid_at' => now(),
            ]);

            // Simpan / update record pembayaran di tabel payments
            payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_code' => 'DOKU-' . $order->order_number,
                    'method' => 'doku',
                    'sender_name' => $payload['customer']['name'] ?? $order->recipient_name,
                    'sender_bank' => $channel,
                    'amount' => $amount > 0 ? $amount : $order->total,
                    'status' => 'paid',
                    'verified_at' => now()
                ]
            );

            // Buat catatan riwayat status pesanan
            order_status_historie::create([
                'order_id' => $order->id,
                'status' => 'processing',
                'description' => "Pembayaran otomatis sebesar Rp " . number_format($order->total, 0, ',', '.') . " berhasil diverifikasi melalui DOKU Payment Gateway ({$channel}).",
                'changed_by' => $order->user_id
            ]);

            return ['status' => 'success', 'message' => "Order #{$invoiceNumber} updated to paid"];
        }

        return ['status' => 'ignored', 'message' => "Transaction status is {$transactionStatus}"];
    }

    /**
     * Dapatkan representasi data string QRIS Dinamis untuk pesanan
     *
     * @param order $order
     * @return string
     */
    public function getQrisDataString(order $order): string
    {
        $amount = (int) round($order->total);
        $invoice = preg_replace('/[^A-Za-z0-9]/', '', (string)$order->order_number);
        $clientId = preg_replace('/[^A-Za-z0-9]/', '', (string)$this->clientId);
        
        // Standar format QRIS EMVCo Bank Indonesia
        return "00020101021226680016ID.DOKU.WWW0118{$clientId}0215{$invoice}51440014ID.CO.QRIS.WWW0215ID1020261113001520454115303360540" . strlen($amount) . "{$amount}5802ID5908KOPIKITA6007JAKARTA61051234062250721{$invoice}6304";
    }

    /**
     * Dapatkan URL gambar QR Code QRIS untuk pesanan
     *
     * @param order $order
     * @return string
     */
    public function getQrisImageUrl(order $order): string
    {
        $data = $this->getQrisDataString($order);
        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=12&data=" . urlencode($data);
    }
}
