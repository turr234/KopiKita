<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - KOPIKITA</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'kopi-dark': '#2B1A14',
                        'kopi-espresso': '#3E2723',
                        'kopi-medium': '#5D4037',
                        'kopi-light': '#8D6E63',
                        'kopi-accent': '#C68B59',
                        'kopi-accent-light': '#DFB087',
                        'kopi-cream': '#FAF6F0',
                        'kopi-border': '#EADBCE',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <!-- DOKU Jokul Checkout JS Library -->
    <script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
</head>
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col selection:bg-kopi-accent selection:text-white">

    <!-- Top Header -->
    <header class="bg-white border-b border-kopi-border sticky top-0 z-30 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shadow-md">
                    <i class="fa-solid fa-mug-hot text-xl"></i>
                </div>
                <div>
                    <span class="font-serif font-bold text-2xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-kopi-accent">Roastery & Store</span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('orders.my_orders') }}" class="text-xs sm:text-sm font-semibold bg-kopi-cream hover:bg-stone-200/70 border border-kopi-border px-3.5 py-2 rounded-xl text-kopi-dark transition-colors">
                    <i class="fa-solid fa-receipt mr-1 text-kopi-accent"></i> Pesanan Saya
                </a>
                <a href="{{ route('landing_pages.index') }}" class="text-xs sm:text-sm font-semibold text-kopi-medium hover:text-kopi-accent transition-colors">
                    Beranda
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-2 rounded-xl transition-colors flex items-center gap-1.5" title="Logout dari akun">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12">
        
        <!-- Status Banner Sukses -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mb-4 shadow-sm animate-bounce">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Pemesanan Berhasil
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-kopi-dark mt-3">Terima Kasih Atas Pesanan Anda!</h1>
            <p class="text-stone-600 text-sm max-w-lg mx-auto mt-2">
                Pesanan Anda telah kami terima dan segera disiapkan oleh barista kami. Simpan nomor pesanan di bawah ini untuk pelacakan.
            </p>
        </div>

        <!-- Kartu Rincian Pesanan & Pembayaran -->
        <div class="bg-white rounded-2xl border border-kopi-border shadow-sm overflow-hidden mb-6">
            
            <!-- Header Kartu -->
            <div class="p-5 sm:p-6 bg-stone-50 border-b border-kopi-border flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-stone-500 block">Nomor Pesanan</span>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="font-mono font-bold text-lg sm:text-xl text-kopi-espresso">{{ $order->order_number }}</span>
                        <button onclick="copyToClipboard('{{ $order->order_number }}', 'Nomor pesanan disalin!')" 
                                class="text-xs text-kopi-accent hover:text-kopi-dark p-1" title="Salin nomor pesanan">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div>
                        <span class="text-xs text-stone-500 block">Status Pembayaran</span>
                        <span class="inline-block mt-0.5 px-3 py-1 text-xs font-bold rounded-full {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-stone-500 block">Status Pesanan</span>
                        <span class="inline-block mt-0.5 px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- KARTU PEMBAYARAN QRIS RESMI (LANGSUNG MUNCUL DI LAYAR - TANPA APPS DOKU) -->
            @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris']) && $order->payment_status !== 'paid')
                <div class="p-6 sm:p-8 bg-gradient-to-b from-red-50/70 via-white to-stone-50 border-b border-stone-200" id="qris-payment-section">
                    
                    <!-- Header QRIS -->
                    <div class="text-center max-w-lg mx-auto mb-6">
                        <div class="inline-flex items-center gap-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase mb-2 shadow-sm">
                            <i class="fa-solid fa-qrcode"></i> Pembayaran QRIS Dinamis
                        </div>
                        <h2 class="font-serif font-bold text-2xl sm:text-3xl text-stone-900">Scan QRIS Untuk Bayar</h2>
                        <p class="text-xs sm:text-sm text-stone-600 mt-1">
                            Bisa di-scan menggunakan <strong>BCA Mobile, Livin' Mandiri, BRImo, BNI, GoPay, OVO, DANA, ShopeePay</strong> atau aplikasi pembayaran lainnya.
                        </p>
                    </div>

                    <!-- Kotak Cetak QRIS Resmi Indonesia -->
                    <div class="max-w-xs sm:max-w-sm mx-auto bg-white rounded-3xl border-2 border-stone-300 shadow-xl overflow-hidden p-5 sm:p-6 text-center relative">
                        
                        <!-- Top Banner QRIS -->
                        <div class="flex items-center justify-between pb-3 border-b border-stone-100 mb-4">
                            <div class="flex items-center gap-1.5">
                                <span class="font-black text-xl tracking-tighter text-red-600 font-sans">QRIS</span>
                                <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest leading-none block border-l pl-1.5 border-stone-300 text-left">
                                    Quick Response Code<br>Indonesian Standard
                                </span>
                            </div>
                            <span class="text-[10px] font-bold bg-stone-100 text-stone-600 px-2 py-0.5 rounded border border-stone-200">
                                GPN
                            </span>
                        </div>

                        <!-- Merchant Information -->
                        <div class="mb-3">
                            <h3 class="font-bold text-base sm:text-lg text-stone-900 leading-tight">KOPIKITA ROASTERY</h3>
                            <span class="text-[11px] font-mono text-stone-400 block mt-0.5">NMID: ID1020261113001</span>
                            <span class="text-[11px] font-mono text-stone-500 block">Inv: #{{ $order->order_number }}</span>
                        </div>

                        <!-- Tampilan Gambar QR Code -->
                        <div class="bg-white p-3 rounded-2xl border border-stone-200 shadow-inner inline-block my-2 relative group">
                            @php
                                $qrUrl = $qrisImageUrl ?? (app(\App\Services\DokuService::class)->getQrisImageUrl($order));
                            @endphp
                            <img src="{{ $qrUrl }}" 
                                 alt="QRIS Pembayaran Pesanan #{{ $order->order_number }}" 
                                 id="qris-image"
                                 class="w-56 h-56 sm:w-64 sm:h-64 object-contain mx-auto transition-transform group-hover:scale-105 duration-200">
                        </div>

                        <!-- Nominal Tagihan -->
                        <div class="mt-4 pt-3 border-t border-dashed border-stone-200">
                            <span class="text-xs text-stone-500 block font-medium">Total Nominal Tagihan:</span>
                            <div class="font-serif font-extrabold text-2xl sm:text-3xl text-red-600 mt-0.5">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full mt-1.5 border border-emerald-200">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Nominal Otomatis & Pas
                            </span>
                        </div>

                        <!-- Countdown Timer -->
                        <div class="mt-4 bg-amber-50 rounded-xl p-2.5 border border-amber-200 text-xs text-amber-900 flex items-center justify-center gap-2">
                            <i class="fa-regular fa-clock text-amber-600 animate-spin" style="animation-duration: 4s;"></i>
                            <span>Batas Waktu Bayar: <strong id="qris-timer" class="font-mono font-bold">15:00</strong></span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <a href="{{ $qrUrl }}" download="QRIS-KOPIKITA-{{ $order->order_number }}.png" target="_blank"
                               class="bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold py-2 px-3 rounded-xl transition-colors flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-download"></i> Unduh QR
                            </a>
                            <button onclick="toggleFullscreenQR()" type="button"
                               class="bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold py-2 px-3 rounded-xl transition-colors flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-expand"></i> Perbesar
                            </button>
                        </div>

                        @if(!empty($order->payment_url))
                            <button onclick="openDokuCheckoutPopup('{{ $order->payment_url }}')" type="button"
                                    class="mt-2.5 w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2.5 px-3 rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-bolt"></i> Buka Layar QRIS Resmi DOKU
                            </button>
                        @endif

                    </div>

                    <!-- Panduan Cara Bayar 5 Langkah -->
                    <div class="max-w-xl mx-auto mt-6 bg-white rounded-2xl p-4 sm:p-5 border border-stone-200 shadow-xs">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-stone-500 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-kopi-accent"></i> Cara Mudah Membayar via QRIS (Semua Aplikasi):
                        </h4>
                        <ol class="text-xs text-stone-600 space-y-2 list-decimal list-inside leading-relaxed">
                            <li>Buka aplikasi m-Banking (<strong>BCA, Mandiri, BRI, BNI</strong>) atau E-Wallet (<strong>GoPay, OVO, DANA, ShopeePay, LinkAja</strong>).</li>
                            <li>Pilih menu <strong>Bayar</strong> atau ikon <strong>QRIS / Scan</strong>.</li>
                            <li>Arahkan kamera ke kode QR di atas (atau unggah tangkapan layar QR jika menggunakan 1 HP).</li>
                            <li>Pastikan nominal pembayaran adalah <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>, lalu konfirmasi pembayaran.</li>
                            <li>Sistem KOPIKITA akan <strong>otomatis memverifikasi pembayaran</strong> Anda secara instan tanpa perlu konfirmasi manual atau install aplikasi DOKU!</li>
                        </ol>
                    </div>

                    <!-- Live Polling Status Indicator -->
                    <div class="max-w-xs mx-auto text-center mt-5">
                        <div id="payment-status-badge" class="inline-flex items-center gap-2 text-xs font-semibold text-stone-600 bg-white px-3.5 py-1.5 rounded-full border border-stone-200 shadow-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                            <span>Menunggu Pembayaran Anda...</span>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Virtual Account DOKU jika memilih doku_va -->
            @if($order->payment_method === 'doku_va' && $order->payment_status !== 'paid')
                <div class="p-5 sm:p-6 bg-red-50/80 border-b border-red-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-red-600 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-sm mt-0.5 sm:mt-0">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-base sm:text-lg text-stone-900">Virtual Account DOKU</h3>
                                    <span class="text-[10px] font-bold bg-red-600 text-white px-2 py-0.5 rounded uppercase tracking-wider">DOKU</span>
                                </div>
                                <p class="text-xs sm:text-sm text-stone-600 mt-1 max-w-xl">
                                    Selesaikan tagihan sebesar <strong class="text-stone-900 font-mono text-sm sm:text-base">Rp {{ number_format($order->total, 0, ',', '.') }}</strong> via Virtual Account BCA, Mandiri, BRI, atau BNI.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('doku.pay', $order->order_number) }}" 
                           class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all flex-shrink-0">
                            <i class="fa-solid fa-bolt"></i> Buka Nomor Virtual Account
                        </a>
                    </div>
                </div>
            @endif

            <!-- Petunjuk Pembayaran Transfer Bank (Jika metode transfer) -->
            @if($order->payment_method === 'bank_transfer')
                <div class="p-5 sm:p-6 bg-amber-50/60 border-b border-amber-200/70">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-sm sm:text-base text-stone-800">Petunjuk Pembayaran Transfer Bank</h3>
                            <p class="text-xs text-stone-600 mt-1">
                                Silakan transfer tepat sejumlah <strong class="text-kopi-espresso font-mono text-sm">Rp {{ number_format($order->total, 0, ',', '.') }}</strong> ke salah satu rekening resmi KOPIKITA berikut:
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                @forelse($bankAccounts as $bank)
                                    <div class="bg-white p-3.5 rounded-xl border border-amber-200/80 shadow-xs flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-500 block">{{ $bank->bank_name }}</span>
                                            <span class="font-mono font-bold text-base text-kopi-dark block mt-0.5">{{ $bank->account_number }}</span>
                                            <span class="text-xs text-stone-500">a.n. {{ $bank->account_holder }}</span>
                                        </div>
                                        <button onclick="copyToClipboard('{{ $bank->account_number }}', 'Nomor rekening {{ $bank->bank_name }} disalin!')"
                                                class="bg-stone-100 hover:bg-kopi-accent hover:text-white text-stone-700 text-xs px-2.5 py-1.5 rounded-lg font-medium transition-colors">
                                            Salin
                                        </button>
                                    </div>
                                @empty
                                    <div class="bg-white p-3.5 rounded-xl border border-amber-200/80 shadow-xs flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-500 block">BCA (Bank Central Asia)</span>
                                            <span class="font-mono font-bold text-base text-kopi-dark block mt-0.5">8045 2819 001</span>
                                            <span class="text-xs text-stone-500">a.n. KOPIKITA INDONESIA</span>
                                        </div>
                                        <button onclick="copyToClipboard('80452819001', 'Nomor rekening BCA disalin!')"
                                                class="bg-stone-100 hover:bg-kopi-accent hover:text-white text-stone-700 text-xs px-2.5 py-1.5 rounded-lg font-medium transition-colors">
                                            Salin
                                        </button>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Body Detail Pesanan -->
            <div class="p-5 sm:p-6 space-y-6">
                
                <!-- Data Penerima & Pengiriman -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-stone-100">
                    <div>
                        <h4 class="text-xs font-bold uppercase text-stone-400 tracking-wider mb-2">Tujuan Pengiriman</h4>
                        <div class="text-sm">
                            <span class="font-bold text-kopi-dark block">{{ $order->recipient_name }}</span>
                            <span class="text-stone-600 block mt-0.5">{{ $order->recipient_phone }}</span>
                            <p class="text-stone-600 mt-1 leading-relaxed">
                                {{ $order->shipping_address }}<br>
                                {{ $order->village ? $order->village . ', ' : '' }}{{ $order->district }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase text-stone-400 tracking-wider mb-2">Metode & Catatan</h4>
                        <div class="text-sm space-y-2">
                            <div>
                                <span class="text-xs text-stone-500">Ekspedisi / Pengiriman:</span>
                                <span class="font-semibold text-kopi-dark block">{{ $order->shipping_method ?? 'Reguler' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-stone-500">Metode Bayar:</span>
                                <span class="font-semibold text-kopi-dark block text-capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                            @if($order->notes)
                                <div>
                                    <span class="text-xs text-stone-500">Catatan Pesanan:</span>
                                    <p class="text-xs italic text-stone-600 bg-stone-50 p-2.5 rounded-lg border border-stone-100 mt-1">"{{ $order->notes }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Daftar Produk Dipesan -->
                <div>
                    <h4 class="text-xs font-bold uppercase text-stone-400 tracking-wider mb-3">Item Kopi Dipesan</h4>
                    <div class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <div class="py-3 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-stone-100 flex-shrink-0 overflow-hidden border border-stone-200">
                                        <img src="{{ $item->product_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuATGtbnSxfLsQln4wTvabPloC7dU1Bc1O_IANC7MWZnp9-1Z3_8yopNzeVZ0sgW56Zqv3-OHcYNFEKMkGeUClH913mWlxXJSV0ZQZ3VV_8nZvQXKptBJ-LBWpiBwdHvkGEauWcBI4EIIFuW4cjxMwII3XAwdh6RY4UC17VpEHvxHDv9696BYENyyklBZTmHVZ5PyqYQUw-ScymAazPoj925z6vgpyUEdqkWstnS2dT8x4xevbqTNH8' }}" 
                                             alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="font-bold text-sm text-kopi-dark block">{{ $item->product_name }}</span>
                                        <span class="text-xs text-stone-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <span class="font-bold text-sm text-kopi-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total Pembayaran -->
                <div class="pt-4 border-t border-kopi-border space-y-2 text-sm">
                    <div class="flex justify-between text-stone-600 text-xs sm:text-sm">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600 text-xs sm:text-sm">
                        <span>Ongkos Kirim</span>
                        <span>{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-emerald-600 text-xs sm:text-sm">
                            <span>Diskon</span>
                            <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base sm:text-lg font-bold text-kopi-dark pt-2 border-t border-stone-200">
                        <span>Total Pembayaran</span>
                        <span class="text-kopi-espresso font-serif">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            <!-- Footer Aksi -->
            <div class="p-5 sm:p-6 bg-stone-50 border-t border-kopi-border flex flex-col sm:flex-row items-center justify-between gap-4">
                
                @php
                    $waNumber = $storeSetting->whatsapp ?? $storeSetting->phone ?? '6281234567890';
                    $waNumberClean = preg_replace('/[^0-9]/', '', $waNumber);
                    if (str_starts_with($waNumberClean, '0')) {
                        $waNumberClean = '62' . substr($waNumberClean, 1);
                    }
                    $waText = urlencode("Halo KOPIKITA, saya ingin konfirmasi pesanan dengan Nomor: *" . $order->order_number . "* atas nama *" . $order->recipient_name . "* dengan total tagihan *Rp " . number_format($order->total, 0, ',', '.') . "*. Mohon segera diproses. Terima kasih!");
                @endphp

                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    @if($order->payment_method === 'doku' && $order->payment_status !== 'paid')
                        <a href="{{ route('doku.pay', $order->order_number) }}" 
                           class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bolt"></i> Bayar Sekarang via DOKU
                        </a>
                    @endif
                    <a href="https://wa.me/{{ $waNumberClean }}?text={{ $waText }}" target="_blank"
                       class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
                    </a>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('orders.my_orders') }}" class="flex-1 sm:flex-initial text-center bg-white border border-kopi-border hover:bg-stone-100 text-kopi-dark text-xs sm:text-sm font-semibold px-5 py-3 rounded-xl transition-colors">
                        <i class="fa-solid fa-list-check mr-1.5 text-kopi-accent"></i> Daftar Pesanan Saya
                    </a>
                    <a href="{{ route('landing_pages.index') }}" class="flex-1 sm:flex-initial text-center bg-kopi-espresso hover:bg-kopi-dark text-white text-xs sm:text-sm font-semibold px-5 py-3 rounded-xl transition-colors">
                        Belanja Lagi
                    </a>
                </div>

            </div>

        </div>

    </main>

    @include('landing_pages.partials.footer')

    <!-- Simple Toast Salin -->
    <div id="copy-toast" class="fixed bottom-6 right-6 z-50 bg-stone-900 text-white px-4 py-2.5 rounded-xl shadow-xl text-xs font-semibold transform translate-y-20 opacity-0 transition-all duration-300">
        Tersalin ke clipboard!
    </div>

    <!-- Fullscreen QR Modal -->
    <div id="qr-modal" class="fixed inset-0 z-50 bg-black/80 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full text-center relative shadow-2xl animate-scale-up">
            <button onclick="toggleFullscreenQR()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="flex items-center justify-center gap-2 mb-3">
                <span class="font-black text-xl text-red-600">QRIS</span>
                <span class="text-xs font-bold text-stone-500">KOPIKITA</span>
            </div>
            <div class="bg-stone-50 p-2 rounded-2xl border border-stone-200 inline-block">
                @php
                    $modalQr = $qrisImageUrl ?? (app(\App\Services\DokuService::class)->getQrisImageUrl($order));
                @endphp
                <img src="{{ $modalQr }}" alt="QRIS Fullscreen" class="w-72 h-72 object-contain mx-auto">
            </div>
            <div class="mt-4 font-serif font-extrabold text-2xl text-red-600">
                Rp {{ number_format($order->total, 0, ',', '.') }}
            </div>
            <p class="text-xs text-stone-500 mt-1">Arahkan kamera aplikasi m-Banking atau E-Wallet Anda ke kode di atas</p>
            <button onclick="toggleFullscreenQR()" class="mt-4 w-full bg-stone-900 hover:bg-black text-white text-xs font-bold py-2.5 rounded-xl">
                Tutup
            </button>
        </div>
    </div>

    <script>
        function copyToClipboard(text, msg) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copy-toast');
                toast.innerText = msg || 'Tersalin!';
                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 2500);
            });
        }

        function toggleFullscreenQR() {
            const modal = document.getElementById('qr-modal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function openDokuCheckoutPopup(url) {
            if (typeof loadJokulCheckout === 'function') {
                loadJokulCheckout(url);
            } else {
                window.open(url, '_blank');
            }
        }

        // Countdown Timer 15 menit
        @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris']) && $order->payment_status !== 'paid')
            let timeLeft = 15 * 60; // 15 menit dalam detik
            const timerEl = document.getElementById('qris-timer');
            if (timerEl) {
                const countdownInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        timerEl.innerText = "Kadaluarsa";
                    } else {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        timerEl.innerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                }, 1000);
            }

            // Live Polling Pengecekan Status Pembayaran DOKU / QRIS
            const orderNumber = "{{ $order->order_number }}";
            const checkUrl = "{{ route('doku.check_status', $order->order_number) }}";
            let pollAttempts = 0;

            const pollInterval = setInterval(() => {
                pollAttempts++;
                if (pollAttempts > 180) { // Berhenti polling setelah 15 menit
                    clearInterval(pollInterval);
                    return;
                }

                fetch(checkUrl)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.is_paid) {
                            clearInterval(pollInterval);
                            const badge = document.getElementById('payment-status-badge');
                            if (badge) {
                                badge.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-600 text-base"></i> <span class="text-emerald-700 font-bold">Pembayaran Berhasil Diverifikasi! Memuat...</span>';
                                badge.classList.remove('border-stone-200');
                                badge.classList.add('border-emerald-300', 'bg-emerald-50');
                            }
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(() => {});
            }, 4000); // Cek tiap 4 detik
        @endif
    </script>
</body>
</html>
