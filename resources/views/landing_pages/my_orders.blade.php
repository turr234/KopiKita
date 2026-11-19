<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - KOPIKITA</title>
    
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
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col selection:bg-kopi-accent selection:text-white overflow-x-hidden w-full relative">

    <!-- Top Header -->
    <header class="bg-white border-b border-kopi-border sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-3">
            <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shadow-md shrink-0">
                    <i class="fa-solid fa-mug-hot text-lg sm:text-xl"></i>
                </div>
                <div class="shrink-0">
                    <span class="font-serif font-bold text-xl sm:text-2xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                    <span class="hidden sm:block text-[10px] uppercase font-bold tracking-widest text-kopi-accent mt-0.5">Roastery & Store</span>
                </div>
            </a>
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <a href="{{ route('landing_pages.index') }}" class="h-9 sm:h-10 text-xs sm:text-sm font-semibold text-kopi-medium hover:text-kopi-accent transition-colors flex items-center gap-1.5 px-3 rounded-xl hover:bg-stone-50" title="Kembali ke Beranda">
                    <i class="fa-solid fa-arrow-left"></i> <span class="hidden sm:inline">Beranda</span>
                </a>
                <span class="text-stone-300 hidden md:inline">|</span>
                <div class="hidden md:flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-kopi-accent/20 flex items-center justify-center text-kopi-dark font-bold text-xs">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-xs font-bold text-kopi-dark max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="h-9 sm:h-10 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-3 rounded-xl transition-colors flex items-center gap-1.5" title="Logout dari akun">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl font-bold text-kopi-dark">Riwayat Pesanan Saya</h1>
                <p class="text-stone-600 text-sm mt-1">Lacak status proses roasting, pengemasan, dan pengiriman pesanan Anda.</p>
            </div>
            <a href="{{ route('landing_pages.index') }}#katalog" class="bg-kopi-espresso hover:bg-kopi-dark text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl transition-all inline-flex items-center gap-2 self-start sm:self-auto shadow-sm">
                <i class="fa-solid fa-plus text-kopi-accent"></i> Pesan Kopi Baru
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-2xl border border-kopi-border p-12 text-center shadow-sm">
                <div class="w-20 h-20 rounded-full bg-stone-100 text-stone-400 mx-auto flex items-center justify-center text-3xl mb-4">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-kopi-dark mb-1">Belum Ada Pesanan</h3>
                <p class="text-xs sm:text-sm text-stone-500 max-w-sm mx-auto mb-6">
                    Anda belum pernah membuat pesanan kopi. Mulai jelajahi katalog artisan coffee kami sekarang!
                </p>
                <a href="{{ route('landing_pages.index') }}#katalog" class="bg-gradient-to-r from-kopi-accent to-[#b47743] text-white px-6 py-3 rounded-xl font-bold text-xs sm:text-sm shadow-md transition-all">
                    Mulai Belanja Kopi
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl border border-kopi-border shadow-sm p-5 sm:p-6 hover:shadow-md transition-shadow">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-stone-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-kopi-cream border border-kopi-border flex items-center justify-center text-kopi-accent">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div>
                                    <span class="font-mono font-bold text-sm sm:text-base text-kopi-dark">#{{ $order->order_number }}</span>
                                    <span class="text-[11px] text-stone-400 block">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Badge Status Pesanan --}}
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
                                <span class="px-3 py-1 rounded-full text-xs font-bold border uppercase tracking-wider {{ $color }}">
                                    {{ $order->status }}
                                </span>

                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-600' }}">
                                    {{ strtoupper($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Ringkasan Produk --}}
                        <div class="py-4 space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center text-xs sm:text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-mug-saucer text-stone-400 text-xs"></i>
                                        <span class="font-medium text-stone-700">{{ $item->product_name }}</span>
                                        <span class="text-stone-400 font-bold">x{{ $item->quantity }}</span>
                                    </div>
                                    <span class="font-semibold text-kopi-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Footer Kartu --}}
                        <div class="pt-4 border-t border-stone-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="text-xs text-stone-500">
                                <span>Total Tagihan: </span>
                                <span class="font-serif font-bold text-base sm:text-lg text-kopi-espresso">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('orders.my_order_detail', $order->order_number) }}" class="bg-stone-100 hover:bg-stone-200 text-kopi-dark text-xs font-semibold px-4 py-2 rounded-xl transition-colors">
                                    Lihat Detail & Lacak
                                </a>
                                @if($order->payment_status !== 'paid')
                                    @if(in_array($order->payment_method, ['qris', 'doku', 'doku_qris']))
                                        <a href="{{ route('orders.my_order_detail', $order->order_number) }}#qris-payment-section" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-xs inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-qrcode"></i> Bayar via QRIS
                                        </a>
                                    @elseif($order->payment_method === 'doku_va')
                                        <a href="{{ route('doku.pay', $order->order_number) }}" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-xs inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-bolt"></i> Buka VA
                                        </a>
                                    @else
                                        <a href="{{ route('checkout.success', $order->order_number) }}" class="bg-kopi-accent hover:bg-kopi-accent-light text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif

    </main>

    @include('landing_pages.partials.footer')

</body>
</html>
