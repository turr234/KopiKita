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

                <a href="https://wa.me/{{ $waNumberClean }}?text={{ $waText }}" target="_blank"
                   class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
                </a>

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

    <!-- Simple Toast Salin -->
    <div id="copy-toast" class="fixed bottom-6 right-6 z-50 bg-stone-900 text-white px-4 py-2.5 rounded-xl shadow-xl text-xs font-semibold transform translate-y-20 opacity-0 transition-all duration-300">
        Tersalin ke clipboard!
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
    </script>
</body>
</html>
