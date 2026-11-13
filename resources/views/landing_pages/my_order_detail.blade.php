<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_number }} - KOPIKITA</title>
    
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
                    <span class="text-[10px] uppercase font-bold tracking-widest text-kopi-accent">Detail Pesanan</span>
                </div>
            </a>
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('orders.my_orders') }}" class="text-xs sm:text-sm font-semibold text-kopi-medium hover:text-kopi-accent transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Pesanan Saya
                </a>
                <span class="text-stone-300 hidden sm:inline">|</span>
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-kopi-accent/20 flex items-center justify-center text-kopi-dark font-bold text-xs">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-xs font-bold text-kopi-dark">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded-xl transition-colors flex items-center gap-1.5" title="Logout dari akun">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12">
        
        <!-- Header Pesanan -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs text-stone-500 block">Detail Transaksi</span>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-kopi-dark">
                    Pesanan <span class="font-mono text-kopi-espresso">#{{ $order->order_number }}</span>
                </h1>
                <span class="text-xs text-stone-500">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>

            <div class="flex items-center gap-2">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                        'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $color = $statusColors[strtolower($order->status)] ?? 'bg-stone-100 text-stone-800 border-stone-200';
                @endphp
                <span class="px-3.5 py-1 rounded-full text-xs font-bold border uppercase tracking-wider {{ $color }}">
                    Status: {{ $order->status }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-700' }}">
                    Bayar: {{ strtoupper($order->payment_status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">

            <!-- Banner & Kartu Pembayaran QRIS Dinamis (Langsung Tampil di Layar Tanpa Apps DOKU) -->
            @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris']) && $order->payment_status !== 'paid')
                <div class="bg-gradient-to-b from-red-50/80 via-white to-stone-50 border-2 border-red-200 rounded-3xl p-6 sm:p-8 shadow-sm" id="qris-payment-section">
                    
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        
                        <!-- Box QRIS Resmi -->
                        <div class="w-full md:w-80 bg-white rounded-2xl border-2 border-stone-300 shadow-md p-5 text-center flex-shrink-0">
                            <!-- Top Banner QRIS -->
                            <div class="flex items-center justify-between pb-2.5 border-b border-stone-100 mb-3">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-black text-xl tracking-tighter text-red-600 font-sans">QRIS</span>
                                    <span class="text-[8px] font-bold text-stone-400 uppercase tracking-widest leading-none block border-l pl-1.5 border-stone-300 text-left">
                                        Quick Response Code<br>Indonesian Standard
                                    </span>
                                </div>
                                <span class="text-[10px] font-bold bg-stone-100 text-stone-600 px-2 py-0.5 rounded border border-stone-200">
                                    GPN
                                </span>
                            </div>

                            <div class="mb-2">
                                <h4 class="font-bold text-sm sm:text-base text-stone-900 leading-tight">KOPIKITA ROASTERY</h4>
                                <span class="text-[10px] font-mono text-stone-400 block mt-0.5">NMID: ID1020261113001</span>
                            </div>

                            <!-- Gambar QR -->
                            @php
                                $detailQrUrl = $qrisImageUrl ?? (app(\App\Services\DokuService::class)->getQrisImageUrl($order));
                            @endphp
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200 inline-block shadow-inner my-1">
                                <img src="{{ $detailQrUrl }}" alt="QRIS Code" class="w-52 h-52 object-contain mx-auto">
                            </div>

                            <div class="mt-3 pt-2.5 border-t border-dashed border-stone-200">
                                <span class="text-[11px] text-stone-500 block">Total Pembayaran:</span>
                                <div class="font-serif font-extrabold text-xl text-red-600">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ $detailQrUrl }}" download="QRIS-KOPIKITA-{{ $order->order_number }}.png" target="_blank"
                                   class="w-full bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold py-2 px-3 rounded-xl transition-colors inline-flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-download"></i> Unduh Gambar QRIS
                                </a>
                            </div>
                        </div>

                        <!-- Instruksi & Live Status -->
                        <div class="flex-1 text-left space-y-4">
                            <div>
                                <div class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                                    <i class="fa-solid fa-bolt"></i> Menunggu Pembayaran QRIS
                                </div>
                                <h3 class="font-serif font-bold text-2xl text-stone-900">Scan QR Code Langsung Dari HP Anda</h3>
                                <p class="text-xs sm:text-sm text-stone-600 mt-1 leading-relaxed">
                                    Buka aplikasi m-Banking (<strong>BCA Mobile, Livin' Mandiri, BRImo, BNI</strong>) atau E-Wallet (<strong>GoPay, OVO, DANA, ShopeePay, LinkAja</strong>), pilih menu <strong>Scan / QRIS</strong>, dan arahkan ke kode di samping.
                                </p>
                            </div>

                            <div class="bg-white rounded-xl p-4 border border-stone-200 shadow-xs space-y-2 text-xs text-stone-600">
                                <div class="flex items-center gap-2 text-kopi-dark font-bold">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i> Tidak Perlu Masuk ke Aplikasi DOKU
                                </div>
                                <p class="text-[11px] text-stone-500">
                                    Pembayaran langsung tersinkronisasi otomatis dengan server DOKU. Saat Anda selesai scan dan bayar di aplikasi bank/e-wallet Anda, status halaman ini akan langsung berubah menjadi lunas!
                                </p>
                            </div>

                            <!-- Live Polling Badge -->
                            <div class="pt-2">
                                <div id="polling-badge" class="inline-flex items-center gap-2.5 text-xs font-semibold text-stone-700 bg-white px-4 py-2 rounded-xl border border-stone-200 shadow-xs">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                                    <span>Menunggu pembayaran Anda...</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endif

            <!-- Banner Virtual Account jika doku_va -->
            @if($order->payment_method === 'doku_va' && $order->payment_status !== 'paid')
                <div class="bg-red-50/90 border border-red-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-sm mt-0.5 sm:mt-0">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-sm sm:text-base text-stone-900">Virtual Account DOKU</h4>
                                <span class="text-[10px] font-bold bg-red-600 text-white px-2 py-0.5 rounded tracking-wider uppercase">DOKU</span>
                            </div>
                            <p class="text-xs sm:text-sm text-stone-600 mt-0.5">
                                Total tagihan: <strong class="text-stone-900 font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>. Silakan bayar melalui Virtual Account BCA, Mandiri, BRI, atau BNI.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('doku.pay', $order->order_number) }}" 
                       class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-xl shadow transition-all flex-shrink-0">
                        <i class="fa-solid fa-bolt"></i> Buka Nomor Virtual Account
                    </a>
                </div>
            @endif
            
            <!-- Riwayat / Timeline Pelacakan Status -->
            <div class="bg-white rounded-2xl border border-kopi-border p-6 shadow-sm">
                <h3 class="font-serif font-bold text-lg text-kopi-dark mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-truck-ramp-box text-kopi-accent"></i> Riwayat & Pelacakan Status
                </h3>

                @if($order->statusHistories->isNotEmpty())
                    <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-stone-200">
                        @foreach($order->statusHistories as $history)
                            <div class="relative">
                                <span class="absolute -left-6 top-1 w-4 h-4 rounded-full bg-kopi-accent border-2 border-white ring-2 ring-stone-200"></span>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="font-bold text-xs sm:text-sm text-kopi-dark uppercase">{{ $history->status }}</span>
                                    <span class="text-[11px] text-stone-400">{{ $history->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-xs text-stone-600 mt-1">{{ $history->description ?? 'Status pesanan diperbarui.' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-xs text-stone-500 py-3">
                        <i class="fa-solid fa-clock-rotate-left mr-1 text-kopi-accent"></i> Menunggu proses awal dari tim roastery KopiKita.
                    </div>
                @endif

                @if($order->tracking_number)
                    <div class="mt-5 p-4 rounded-xl bg-kopi-cream/70 border border-kopi-border flex items-center justify-between">
                        <div>
                            <span class="text-xs text-stone-500 block">Nomor Resi Pengiriman ({{ $order->shipping_method }}):</span>
                            <span class="font-mono font-bold text-sm text-kopi-dark">{{ $order->tracking_number }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Produk & Rincian Pembayaran -->
            <div class="bg-white rounded-2xl border border-kopi-border p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="font-serif font-bold text-lg text-kopi-dark mb-4">Rincian Produk Dipesan</h3>
                    <div class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <div class="py-3.5 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-14 h-14 rounded-xl bg-stone-100 flex-shrink-0 overflow-hidden border border-stone-200">
                                        <img src="{{ $item->product_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuATGtbnSxfLsQln4wTvabPloC7dU1Bc1O_IANC7MWZnp9-1Z3_8yopNzeVZ0sgW56Zqv3-OHcYNFEKMkGeUClH913mWlxXJSV0ZQZ3VV_8nZvQXKptBJ-LBWpiBwdHvkGEauWcBI4EIIFuW4cjxMwII3XAwdh6RY4UC17VpEHvxHDv9696BYENyyklBZTmHVZ5PyqYQUw-ScymAazPoj925z6vgpyUEdqkWstnS2dT8x4xevbqTNH8' }}" 
                                             alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="font-bold text-sm text-kopi-dark block">{{ $item->product_name }}</span>
                                        <span class="text-xs text-stone-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <span class="font-bold text-sm text-kopi-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Informasi Penerima -->
                <div class="pt-6 border-t border-stone-100 grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs sm:text-sm">
                    <div>
                        <span class="font-bold text-stone-400 uppercase tracking-wider block text-xs mb-1">Penerima & Alamat</span>
                        <span class="font-bold text-kopi-dark block">{{ $order->recipient_name }} ({{ $order->recipient_phone }})</span>
                        <p class="text-stone-600 mt-1 leading-relaxed">
                            {{ $order->shipping_address }}<br>
                            {{ $order->village ? $order->village . ', ' : '' }}{{ $order->district }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                        </p>
                    </div>

                    <div>
                        <span class="font-bold text-stone-400 uppercase tracking-wider block text-xs mb-1">Pengiriman & Pembayaran</span>
                        <div class="space-y-1 text-stone-600">
                            <div><strong class="text-kopi-dark">Layanan:</strong> {{ $order->shipping_method ?? '-' }}</div>
                            <div><strong class="text-kopi-dark">Metode:</strong> {{ str_replace('_', ' ', strtoupper($order->payment_method)) }}</div>
                            @if($order->notes)
                                <div class="mt-2 text-xs italic bg-stone-50 p-2 rounded border border-stone-100">"{{ $order->notes }}"</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kalkulasi -->
                <div class="pt-4 border-t border-stone-100 space-y-2 text-xs sm:text-sm">
                    <div class="flex justify-between text-stone-600">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Ongkos Kirim</span>
                        <span>{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon</span>
                            <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-bold text-kopi-dark pt-2 border-t border-stone-200">
                        <span>Total Tagihan</span>
                        <span class="text-kopi-espresso font-serif text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Tombol WhatsApp & Bayar -->
                <div class="pt-4 border-t border-stone-100 flex flex-wrap items-center justify-between gap-3">
                    @php
                        $waNumber = $storeSetting->whatsapp ?? $storeSetting->phone ?? '6281234567890';
                        $waNumberClean = preg_replace('/[^0-9]/', '', $waNumber);
                        if (str_starts_with($waNumberClean, '0')) {
                            $waNumberClean = '62' . substr($waNumberClean, 1);
                        }
                        $waText = urlencode("Halo KOPIKITA, saya ingin menanyakan pesanan saya #{$order->order_number} atas nama {$order->recipient_name}.");
                    @endphp

                    <a href="https://wa.me/{{ $waNumberClean }}?text={{ $waText }}" target="_blank"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors inline-flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Chat CS mengenai Pesanan ini
                    </a>

                    @if($order->payment_status !== 'paid')
                        @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris']))
                            <a href="#qris-payment-section" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-qrcode"></i> Lihat QRIS Pembayaran
                            </a>
                        @elseif($order->payment_method === 'doku_va')
                            <a href="{{ route('doku.pay', $order->order_number) }}" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-bolt"></i> Buka Virtual Account
                            </a>
                        @else
                            <a href="{{ route('checkout.success', $order->order_number) }}" class="bg-kopi-accent hover:bg-kopi-accent-light text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors">
                                Lihat Rekening Pembayaran
                            </a>
                        @endif
                    @endif
                </div>

            </div>

        </div>

    </main>

    @include('landing_pages.partials.footer')

    @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris', 'doku_va']) && $order->payment_status !== 'paid')
        <script>
            // Live Polling Pengecekan Status Pembayaran DOKU / QRIS
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
                            const badge = document.getElementById('polling-badge');
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
            }, 4000);
        </script>
    @endif

</body>
</html>
