<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPIKITA - Official Online Store & Roastery</title>
    
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
                        'kopi-dark': '#2B1A14',      /* Deep Roast */
                        'kopi-espresso': '#3E2723',  /* Rich Espresso */
                        'kopi-medium': '#5D4037',    /* Mocha */
                        'kopi-light': '#8D6E63',     /* Warm Latte */
                        'kopi-accent': '#C68B59',    /* Warm Caramel Gold */
                        'kopi-accent-light': '#DFB087',
                        'kopi-cream': '#FAF6F0',     /* Soft Warm Cream */
                        'kopi-surface': '#FFFFFF',
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

    <style>
        .glass-nav {
            background: rgba(250, 246, 240, 0.94);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(198, 139, 89, 0.2);
        }

        .product-card {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px rgba(43, 26, 20, 0.12), 0 8px 12px -6px rgba(43, 26, 20, 0.08);
        }

        .product-card .img-zoom {
            transition: transform 0.5s ease;
        }

        .product-card:hover .img-zoom {
            transform: scale(1.06);
        }

        .hero-overlay {
            background: linear-gradient(90deg, rgba(35, 20, 15, 0.92) 0%, rgba(43, 26, 20, 0.78) 55%, rgba(62, 39, 35, 0.45) 100%);
        }

        .badge-sale {
            background: linear-gradient(135deg, #B91C1C, #DC2626);
        }

        /* Cart drawer transition simulation */
        #cart-drawer {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</head>
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col selection:bg-kopi-accent selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-kopi-dark text-kopi-cream py-2 px-4 text-xs md:text-sm font-medium border-b border-kopi-medium/30">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="bg-kopi-accent text-white text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider uppercase">Promo</span>
                <span>Gratis Ongkir se-Indonesia untuk pembelian di atas Rp 150.000! Gunakan kode: <strong>KOPIASLI</strong></span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-xs text-kopi-cream/80">
                <a href="{{ route('orders.my_orders') }}" class="hover:text-kopi-accent transition-colors"><i class="fa-solid fa-truck-fast mr-1"></i> Lacak Pesanan</a>
                <a href="#bantuan" class="hover:text-kopi-accent transition-colors"><i class="fa-solid fa-headset mr-1"></i> Bantuan</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <nav class="sticky top-0 z-40 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="w-11 h-11 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shadow-md">
                        <i class="fa-solid fa-mug-hot text-2xl"></i>
                    </div>
                    <div>
                        <span class="font-serif font-bold text-2xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-kopi-accent">Roastery & Store</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari biji kopi Arabica, Robusta, Cold Brew, Drip Bag..." 
                               class="w-full bg-white/90 border border-kopi-border rounded-full py-2.5 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:border-transparent text-kopi-dark placeholder-stone-400 shadow-inner">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-stone-400"></i>
                    </div>
                </div>

                <!-- Desktop Menu Links -->
                <div class="hidden md:flex space-x-7 items-center">
                    <a href="#katalog" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Semua Produk</a>
                    <a href="#biji-kopi" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Biji Kopi</a>
                    <a href="#ready-to-drink" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Siap Minum</a>
                    <a href="#merchandise" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Alat Seduh</a>
                    <a href="{{ route('orders.my_orders') }}" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Pesanan Saya</a>
                    <a href="#tentang" class="text-kopi-medium hover:text-kopi-accent font-semibold text-sm transition-colors">Tentang Kami</a>
                </div>

                <!-- E-Commerce Action Icons -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Wishlist -->
                    <button class="relative p-2.5 text-kopi-dark hover:text-kopi-accent hover:bg-stone-200/50 rounded-full transition-colors" title="Wishlist">
                        <i class="fa-regular fa-heart text-xl"></i>
                        <span class="absolute top-1 right-1 bg-kopi-accent text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
                    </button>

                    <!-- User Profile Dropdown -->
                    @auth
                    <div class="relative" id="profile-dropdown-container">
                        <button onclick="toggleProfileDropdown(event)" class="flex items-center gap-2 p-1.5 sm:px-3 sm:py-2 rounded-full border border-kopi-border bg-white hover:bg-stone-50 hover:border-kopi-accent text-kopi-dark transition-all focus:outline-none shadow-xs" title="Menu Akun">
                            <div class="w-8 h-8 rounded-full bg-kopi-accent/20 flex items-center justify-center text-kopi-espresso font-bold text-xs">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="hidden sm:block text-left text-xs leading-tight">
                                <span class="font-bold block truncate max-w-[110px] text-kopi-dark">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-kopi-accent font-semibold uppercase">Akun Saya</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-stone-400 ml-0.5"></i>
                        </button>

                        <!-- Dropdown Menu Box -->
                        <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-kopi-border py-2 z-50 transform origin-top-right transition-all">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-stone-100 bg-kopi-cream/50 rounded-t-2xl">
                                <p class="text-xs font-bold text-kopi-dark leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-stone-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="text-[10px] font-bold uppercase tracking-wider bg-kopi-espresso text-kopi-cream px-2 py-0.5 rounded-full">
                                        {{ Auth::user()->roles->first()->name ?? 'Pelanggan' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Menu Links -->
                            <div class="py-2">
                                <a href="{{ route('orders.my_orders') }}" class="flex items-center justify-between px-4 py-2.5 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-kopi-accent/15 text-kopi-accent flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-receipt"></i>
                                        </div>
                                        <span>Pesanan Saya</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-stone-400"></i>
                                </a>

                                <button onclick="toggleProfileDropdown(); toggleCart();" class="w-full flex items-center justify-between px-4 py-2.5 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium text-left">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-kopi-accent/15 text-kopi-accent flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <span>Keranjang Belanja</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-stone-400"></i>
                                </button>

                                @hasanyrole('admin|staff|admin toko|Admin Toko|admin toko a|admin toko b|admin toko c')
                                <a href="{{ route('home') }}" class="flex items-center justify-between px-4 py-2.5 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-stone-100 text-stone-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-gauge"></i>
                                        </div>
                                        <span>Panel Admin</span>
                                    </div>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-stone-400"></i>
                                </a>
                                @endhasanyrole
                            </div>

                            <!-- Logout Form -->
                            <div class="border-t border-stone-100 pt-1.5 pb-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors font-semibold">
                                        <div class="w-7 h-7 rounded-lg bg-red-100/70 text-red-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        </div>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-kopi-dark hover:text-kopi-accent bg-white border border-kopi-border px-3.5 py-2 rounded-full shadow-xs hover:border-kopi-accent transition-all">
                        <i class="fa-solid fa-arrow-right-to-bracket text-kopi-accent"></i> Masuk
                    </a>
                    @endauth

                    <!-- Shopping Cart CTA -->
                    <button onclick="toggleCart()" class="relative flex items-center gap-2.5 bg-kopi-espresso text-white px-4 py-2.5 rounded-full font-medium shadow-md hover:bg-kopi-dark transition-all transform hover:scale-105 active:scale-95">
                        <i class="fa-solid fa-bag-shopping text-base text-kopi-accent"></i>
                        <span class="text-xs sm:text-sm font-semibold">Keranjang</span>
                        <span id="cart-counter" class="bg-kopi-accent text-white text-xs font-bold px-2 py-0.5 rounded-full">0</span>
                    </button>

                    <!-- Mobile Hamburger -->
                    <div class="md:hidden flex items-center">
                        <button onclick="toggleMobileMenu()" class="text-kopi-dark hover:text-kopi-accent p-2 text-2xl focus:outline-none">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown -->
        <div id="mobile-menu-drawer" class="md:hidden hidden bg-white border-t border-kopi-border px-4 py-4 space-y-3 shadow-lg">
            @auth
            <div class="flex items-center gap-3 pb-3 border-b border-stone-100">
                <div class="w-10 h-10 rounded-full bg-kopi-accent/20 flex items-center justify-center text-kopi-espresso font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <p class="font-bold text-sm text-kopi-dark">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-stone-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1 pt-1">
                <a href="{{ route('orders.my_orders') }}" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent py-2">
                    <i class="fa-solid fa-receipt text-kopi-accent w-5"></i> Pesanan Saya
                </a>
                <a href="#katalog" onclick="toggleMobileMenu()" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent py-2">
                    <i class="fa-solid fa-mug-hot text-kopi-accent w-5"></i> Semua Produk
                </a>
                @hasanyrole('admin|staff|admin toko|Admin Toko|admin toko a|admin toko b|admin toko c')
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent py-2">
                    <i class="fa-solid fa-gauge text-kopi-accent w-5"></i> Panel Admin
                </a>
                @endhasanyrole
                <form action="{{ route('logout') }}" method="POST" class="pt-2 border-t border-stone-100">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 text-sm font-semibold text-red-600 hover:text-red-700 py-2 w-full text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar (Logout)
                    </button>
                </form>
            </div>
            @else
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="block text-center bg-kopi-espresso text-white text-sm font-bold py-2.5 rounded-xl">
                    Masuk / Login
                </a>
                <a href="{{ route('register') }}" class="block text-center border border-kopi-border text-kopi-dark text-sm font-semibold py-2.5 rounded-xl">
                    Daftar Akun Baru
                </a>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Hero E-Commerce Banner -->
    <section class="relative min-h-[560px] lg:h-[620px] flex items-center overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4Tb0rQkJkQjktpqW5gJ3-2bnxDK4xU8_sC_-aydmNj6slpgyKY71fuh5ae99lXsjBD5FAccu5hGAe-C5UmBydTYuvnqPJrAVh5wWRv15eYtxuSDBFz15JGK8JFOLvI6fPkgOrdzJHhmAI-jnPM-BNnmsYIAtin0Lt5X3jFYCf6UfE5PrDHx5Q-f6hRxtzIlXl_HrLrMQD5ZMJY6r9Pgp_ziCibadyloPtepA-qQ0Sv1YCQ1yHk6Q" alt="Proses roasting dan barista KOPIKITA" class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 hero-overlay"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
            <div class="max-w-2xl text-left">
                <div class="inline-flex items-center gap-2 bg-kopi-accent/20 backdrop-blur-md border border-kopi-accent/40 text-kopi-accent-light px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase mb-5">
                    <i class="fa-solid fa-seedling text-sm"></i> Single Origin Freshly Roasted
                </div>
                
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Cita Rasa Kopi Nusantara, <br/>
                    <span class="text-kopi-accent-light italic">Langsung ke Meja Anda.</span>
                </h1>
                
                <p class="text-stone-200 text-base sm:text-lg mb-8 font-light leading-relaxed">
                    Beli biji kopi artisan pilihan dari Sumatra Gayo, Toraja, hingga Bali Kintamani. Di-roasting setiap minggu untuk kesegaran maksimal, siap kirim ke seluruh Indonesia.
                </p>

                <div class="grid grid-cols-3 gap-3 mb-8 text-white/90 text-xs sm:text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-certificate text-kopi-accent text-base"></i>
                        <span>100% Arabica Murni</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-fire text-kopi-accent text-base"></i>
                        <span>Fresh Roasted Weekly</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-box text-kopi-accent text-base"></i>
                        <span>Packaging Kedap Udara</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 items-center">
                    <a href="#katalog" class="bg-gradient-to-r from-kopi-accent to-[#b47743] hover:from-[#d99863] hover:to-kopi-accent text-white px-8 py-3.5 rounded-xl font-bold text-base inline-flex items-center gap-3 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        Belanja Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="#tentang" class="border-2 border-white/60 hover:border-white text-white px-7 py-3 rounded-xl font-semibold text-base inline-flex items-center gap-2 backdrop-blur-sm hover:bg-white/10 transition-all">
                        <i class="fa-regular fa-circle-play text-kopi-accent"></i> Cerita Petani
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Key E-commerce Features Bar -->
    <section class="bg-white border-b border-kopi-border py-6 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-kopi-cream flex items-center justify-center text-kopi-accent text-xl flex-shrink-0">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-kopi-dark">Pengiriman Cepat</h4>
                        <p class="text-xs text-stone-500">Same-day delivery & ekspedisi</p>
                    </div>
                </div>
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-kopi-cream flex items-center justify-center text-kopi-accent text-xl flex-shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-kopi-dark">Garansi Segar</h4>
                        <p class="text-xs text-stone-500">Roast date tertera di kemasan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-kopi-cream flex items-center justify-center text-kopi-accent text-xl flex-shrink-0">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-kopi-dark">Pembayaran Aman</h4>
                        <p class="text-xs text-stone-500">QRIS, Transfer Bank & E-Wallet</p>
                    </div>
                </div>
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-kopi-cream flex items-center justify-center text-kopi-accent text-xl flex-shrink-0">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-kopi-dark">Kualitas Specialty</h4>
                        <p class="text-xs text-stone-500">Score cup 84+ SCA standard</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main E-Commerce Product Catalog Grid -->
    <section id="katalog" class="py-14 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">

                @foreach ($products as $product)
                <div class="product-card bg-kopi-cream rounded-2xl overflow-hidden border border-kopi-border/80 flex flex-col justify-between relative group">
                    <div class="relative bg-[#eee6dc] h-72 overflow-hidden">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                            <span class="bg-kopi-espresso text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider shadow">Best Seller</span>
                            <span class="badge-sale text-white text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow">Hemat 15%</span>
                        </div>
                        <button class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-stone-500 hover:text-red-500 flex items-center justify-center transition-colors shadow">
                            <i class="fa-regular fa-heart text-sm"></i>
                        </button>

                        <img src="{{ $product->main_image ?: 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600' }}" alt="{{ $product->name }}" class="img-zoom w-full h-full object-cover">
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-stone-500 mb-1.5">
                                <span class="font-medium text-kopi-accent">Single Origin • 250gr</span>
                                <span class="flex items-center gap-1 text-amber-500 font-semibold"><i class="fa-solid fa-star text-[11px]"></i> 4.9 (128)</span>
                            </div>
                            <h3 class="font-serif text-lg font-bold text-kopi-dark group-hover:text-kopi-accent transition-colors leading-snug mb-1">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-stone-600 line-clamp-2 mb-3">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div>
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="font-serif font-bold text-xl text-kopi-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>

                            <!-- Grind Option Dropdown Mini -->
                            <div class="mb-3">
                                <select id="grind-select-{{ $product->id }}" class="w-full text-xs bg-white border border-kopi-border rounded-lg py-1.5 px-2 text-stone-700 focus:outline-none focus:ring-1 focus:ring-kopi-accent">
                                    @foreach ($JenisProducts as $jenisProduct)
                                        {{-- DIPERBAIKI: Nilai value menggunakan ID dari jenis_products --}}
                                        <option value="{{ $jenisProduct->id }}">{{ $jenisProduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="handleAddToCart('{{ $product->id }}')" class="bg-stone-200 hover:bg-stone-300 text-kopi-dark text-xs sm:text-sm font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-xs active:scale-98" title="Tambahkan ke Keranjang">
                                    <i class="fa-solid fa-cart-plus text-kopi-accent"></i> + Keranjang
                                </button>
                                <button onclick="handleBuyNow('{{ $product->id }}')" class="bg-kopi-espresso hover:bg-kopi-dark text-white text-xs sm:text-sm font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-sm hover:shadow active:scale-98" title="Langsung Buat Pesanan">
                                    <i class="fa-solid fa-bag-shopping text-kopi-accent"></i> Pesan
                                </button>
                            </div>
                        </div>
                    </div>
                </div> 
                @endforeach 
            </div>
        </div>
    </section>

    <!-- Interactive Slide-over Shopping Cart Drawer -->
    <div id="cart-modal-backdrop" onclick="toggleCart()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden transition-opacity"></div>
    
    <div id="cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col translate-x-full transition-transform duration-300">
        <!-- Cart Header -->
        <div class="p-5 border-b border-kopi-border flex items-center justify-between bg-kopi-cream">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-bag-shopping text-kopi-accent text-lg"></i>
                <h3 class="font-serif font-bold text-lg text-kopi-dark">Keranjang Belanja</h3>
                <span id="cart-header-badge" class="bg-kopi-accent text-white text-xs font-bold px-2 py-0.5 rounded-full">0 Item</span>
            </div>
            <button onclick="toggleCart()" class="text-stone-400 hover:text-kopi-dark p-2 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Cart Items List (Dinamis dari JS) -->
        <div id="cart-items-container" class="flex-1 overflow-y-auto p-5 space-y-4">
            <!-- Item keranjang akan dirender oleh JavaScript di sini -->
        </div>

        <!-- Cart Footer Checkout -->
        <div class="p-5 border-t border-kopi-border bg-kopi-cream/70 space-y-3">
            <div class="flex justify-between text-xs text-stone-500">
                <span>Subtotal Produk</span>
                <span id="cart-subtotal" class="font-medium text-stone-700">Rp 0</span>
            </div>
            <div class="flex justify-between text-xs text-stone-500">
                <span>Estimasi Ongkir</span>
                <span class="text-emerald-600 font-semibold">Tersedia Promo Gratis Ongkir</span>
            </div>
            <div class="flex justify-between text-base font-bold text-kopi-dark pt-2 border-t border-kopi-border">
                <span>Total Pesanan</span>
                <span id="cart-total" class="text-kopi-espresso font-serif text-lg">Rp 0</span>
            </div>

            <button onclick="proceedToCheckout()" class="w-full bg-gradient-to-r from-kopi-accent to-[#b47743] hover:from-[#d99863] hover:to-kopi-accent text-white py-3.5 rounded-xl font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2">
                Pesan Sekarang (Checkout) <i class="fa-solid fa-arrow-right"></i>
            </button>
            <p class="text-[11px] text-center text-stone-400">Garansi 100% aman dan terenkripsi</p>
        </div>
    </div>

    <!-- Toast Notification for Add to Cart -->
    <div id="cart-toast" class="fixed bottom-6 right-6 z-50 bg-kopi-espresso text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-24 opacity-0 transition-all duration-300">
        <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <p id="toast-title" class="text-xs font-bold">Produk ditambahkan!</p>
            <p class="text-[11px] text-stone-300">Silakan cek keranjang belanja Anda.</p>
        </div>
    </div>

    <!-- Script Logika Keranjang Belanja Interaktif Database -->
    <script>
    const csrfToken = '{{ csrf_token() }}';

    document.addEventListener('DOMContentLoaded', () => {
        // Muat data keranjang dari database saat halaman pertama kali dibuka
        loadCartFromDatabase();
    });

    // 1. Toggle Buka/Tutup Cart Drawer (Slide-Over)
    function toggleCart() {
        const drawer = document.getElementById('cart-drawer');
        const backdrop = document.getElementById('cart-modal-backdrop');
        
        if (drawer.classList.contains('translate-x-full')) {
            drawer.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // 2. Ambil Data Keranjang dari Database (AJAX GET)
    function loadCartFromDatabase() {
        @guest
            renderCartUI([]);
            return;
        @endguest

        fetch("{{ route('cart.data') }}", {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => {
                if (!res.ok) {
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success && data.cart) {
                    renderCartUI(data.cart.items || []);
                } else {
                    renderCartUI([]);
                }
            })
            .catch(err => console.error('Error loading cart:', err));
    }

    // 3. Tambahkan Produk ke Keranjang Database (AJAX POST)
    function handleAddToCart(productId) {
        const selectElement = document.getElementById(`grind-select-${productId}`);
        const selectedJenisId = selectElement ? selectElement.value : null;

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                jenis_product_id: selectedJenisId,
                quantity: 1
            })
        })
        .then(res => {
            if (res.status === 401) {
                alert('Silakan login terlebih dahulu untuk menambah produk ke keranjang!');
                window.location.href = "{{ route('login') }}";
                return;
            }
            return res.json();
        })
        .then(data => {
            if (data && data.success) {
                loadCartFromDatabase(); // Reload UI dari database
                showToast('Produk berhasil masuk keranjang!');
            }
        })
        .catch(err => console.error('Error adding to cart:', err));
    }

    // 4. Render Tampilan Elemen Keranjang
    function renderCartUI(items) {
        const container = document.getElementById('cart-items-container');
        const cartCounter = document.getElementById('cart-counter');
        const cartHeaderBadge = document.getElementById('cart-header-badge');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTotal = document.getElementById('cart-total');

        if (!container) return;

        container.innerHTML = '';
        let totalQty = 0;
        let totalPrice = 0;

        if (!items || items.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 text-stone-400">
                    <i class="fa-solid fa-basket-shopping text-4xl mb-3 block"></i>
                    <p class="text-sm">Keranjang Anda masih kosong.</p>
                </div>`;
        } else {
            items.forEach(item => {
                const itemPrice = parseFloat(item.price) || 0;
                const itemSubtotal = itemPrice * item.quantity;
                totalQty += item.quantity;
                totalPrice += itemSubtotal;

                const productName = item.product ? item.product.name : 'Produk Kopi';
                const jenisName = item.jenis_product ? item.jenis_product.name : '-';

                const div = document.createElement('div');
                div.className = 'flex gap-3.5 pb-4 border-b border-stone-100';
                div.innerHTML = `
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="font-serif font-bold text-sm text-kopi-dark leading-tight">${productName}</h4>
                            <button onclick="deleteCartItem(${item.id})" class="text-stone-300 hover:text-red-500 text-xs">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                        <p class="text-xs text-stone-500 mt-0.5">Jenis: <span class="font-semibold text-kopi-accent">${jenisName}</span></p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-sm text-kopi-dark">Rp ${itemPrice.toLocaleString('id-ID')}</span>
                            <div class="flex items-center border border-kopi-border rounded-lg bg-stone-50">
                                <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="px-2.5 py-0.5 text-xs text-stone-600 hover:bg-stone-200 rounded-l-lg">-</button>
                                <span class="px-2 text-xs font-bold">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="px-2.5 py-0.5 text-xs text-stone-600 hover:bg-stone-200 rounded-r-lg">+</button>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        if (cartCounter) cartCounter.innerText = totalQty;
        if (cartHeaderBadge) cartHeaderBadge.innerText = `${totalQty} Item`;
        if (cartSubtotal) cartSubtotal.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        if (cartTotal) cartTotal.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    // 5. Update Kuantitas di Database (AJAX PUT)
    function updateQuantity(cartItemId, newQty) {
        if (newQty <= 0) {
            deleteCartItem(cartItemId);
            return;
        }

        fetch(`/cart-item/${cartItemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadCartFromDatabase();
            }
        });
    }

    // 6. Hapus Item dari Database (AJAX DELETE)
    function deleteCartItem(cartItemId) {
        fetch(`/cart-item/${cartItemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadCartFromDatabase();
            }
        });
    }

    // 7. Notifikasi Toast
    function showToast(message) {
        const toast = document.getElementById('cart-toast');
        const toastTitle = document.getElementById('toast-title');
        
        if (toast && toastTitle) {
            toastTitle.innerText = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }
    }

    // 8. Navigasi ke Halaman Checkout Pemesanan
    function proceedToCheckout() {
        const cartCounter = document.getElementById('cart-counter');
        const count = parseInt(cartCounter ? cartCounter.innerText : '0') || 0;
        if (count <= 0) {
            showToast('Keranjang belanja Anda masih kosong! Pilih produk terlebih dahulu.');
            return;
        }
        window.location.href = "{{ route('checkout.index') }}";
    }

    // 9. Beli Langsung (Instant Order / Pesan Sekarang)
    function handleBuyNow(productId) {
        const selectElement = document.getElementById(`grind-select-${productId}`);
        const selectedJenisId = selectElement ? selectElement.value : null;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('buy.now') }}";

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        form.appendChild(productInput);

        if (selectedJenisId) {
            const jenisInput = document.createElement('input');
            jenisInput.type = 'hidden';
            jenisInput.name = 'jenis_product_id';
            jenisInput.value = selectedJenisId;
            form.appendChild(jenisInput);
        }

        document.body.appendChild(form);
        form.submit();
    }

    // 10. Toggle Profile Dropdown
    function toggleProfileDropdown(e) {
        if (e) e.stopPropagation();
        const menu = document.getElementById('profile-dropdown-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    // 11. Toggle Mobile Menu Drawer
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-menu-drawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
    }

    // Tutup dropdown profil saat klik di luar
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('profile-dropdown-menu');
        const container = document.getElementById('profile-dropdown-container');
        if (menu && !menu.classList.contains('hidden')) {
            if (container && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        }
    });
</script>
</body>
</html>