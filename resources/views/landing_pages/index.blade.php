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
        /* Mencegah scroll-x liar pada seluruh halaman */
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
            width: 100%;
            position: relative;
        }

        /* Utility Scroll-X Halus Tanpa Scrollbar Kasar */
        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
            -webkit-overflow-scrolling: touch;
        }

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
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.35s ease;
        }
    </style>
</head>
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col selection:bg-kopi-accent selection:text-white overflow-x-hidden w-full relative">
@php
    $store = $storeSetting ?? \App\Models\store_setting::first();
    $rawStoreName = !empty($store->store_name) ? $store->store_name : 'KOPIKITA';
    // Bersihkan nama brand dari imbuhan cabang seperti "- Toko A (Group Bandung)"
    $brandParts = explode('-', $rawStoreName);
    $cleanBrand = trim($brandParts[0]);
    $storeName = (!empty($cleanBrand) && strtolower($cleanBrand) !== 'kopikita') ? $cleanBrand : 'KOPIKITA';
    $rawTagline = !empty($store->tagline) ? $store->tagline : 'Roastery & Store';
    $tagline = str_contains(strtolower($rawTagline), 'bandung') ? 'Roastery & Store' : $rawTagline;
    $rawWa = !empty($store->whatsapp) ? $store->whatsapp : '6283803943909';
    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    if (empty($cleanWa)) {
        $cleanWa = '6283803943909';
    }
@endphp

    <!-- Top Announcement Bar -->
    <div class="bg-[#1c120c] text-stone-300 py-2 px-4 text-xs font-medium border-b border-white/5">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-4">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <span class="bg-gradient-to-r from-kopi-accent to-[#b57a46] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full tracking-wider uppercase shadow-xs">Promo Spesial</span>
                <span class="text-stone-300">
                    Gratis Ongkir se-Indonesia > Rp 150.000! Gunakan kode: 
                    <button type="button" onclick="copyPromoCode('KOPIASLI')" class="font-bold underline text-kopi-accent-light hover:text-white cursor-pointer ml-1 inline-flex items-center gap-1 group" title="Klik untuk salin kode voucher">
                        <span>KOPIASLI</span>
                        <i class="fa-regular fa-copy text-[10px] group-hover:scale-110 transition-transform"></i>
                    </button>
                </span>
            </div>
            <div class="hidden md:flex items-center gap-4 text-xs text-stone-400">
                <a href="{{ route('orders.my_orders') }}" class="hover:text-kopi-accent-light transition-colors flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-kopi-accent"></i> Lacak Pesanan</a>
                <span class="text-stone-700">|</span>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Admin ' . $storeName . ', saya butuh bantuan seputar pemesanan...') }}" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-400 transition-colors flex items-center gap-1.5"><i class="fa-brands fa-whatsapp text-emerald-400"></i> Bantuan CS</a>
                <span class="text-stone-700">|</span>
                @auth
                <a href="{{ route('orders.my_orders') }}" class="hover:text-white transition-colors flex items-center gap-1.5 text-stone-300">
                    <i class="fa-solid fa-user-check text-kopi-accent"></i> <span>Akun: <strong class="text-white">{{ Auth::user()->name }}</strong></span>
                </a>
                @else
                <a href="{{ route('login') }}" class="hover:text-white transition-colors flex items-center gap-1.5 text-kopi-accent-light font-semibold">
                    <i class="fa-solid fa-arrow-right-to-bracket text-kopi-accent"></i> <span>Login / Masuk</span>
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-kopi-border/70 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-3 sm:gap-6">
                
                <!-- 1. Left: Brand Logo (Bersih & Elegan) -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-2.5 sm:gap-3 group" title="KOPIKITA - Official Roastery & Store">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-br from-kopi-espresso to-[#251510] flex items-center justify-center text-kopi-accent shadow-md shadow-kopi-dark/10 group-hover:scale-105 transition-all border border-kopi-accent/20 shrink-0">
                            <i class="fa-solid fa-mug-hot text-xl sm:text-2xl"></i>
                        </div>
                        <div class="shrink-0 flex flex-col justify-center">
                            <span class="font-serif font-bold text-xl sm:text-2xl lg:text-3xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                            <span class="text-[9px] sm:text-[10px] uppercase font-bold tracking-widest text-kopi-accent block mt-1">ROASTERY & STORE</span>
                        </div>
                    </a>
                </div>

                <!-- 2. Center: Desktop Menu Navigation Links -->
                <div class="hidden lg:flex items-center justify-center gap-1 xl:gap-2">
                    <a href="#katalog" onclick="filterCategory('all', event)" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        Semua Kopi
                    </a>
                    <a href="#katalog" onclick="filterCategory('single-origin', event)" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        Single Origin
                    </a>
                    <a href="#katalog" onclick="filterCategory('house-blend', event)" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        House Blend
                    </a>
                    <a href="#katalog" onclick="filterCategory('cold-brew-rtd', event)" class="hidden xl:inline-flex px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        Siap Minum
                    </a>
                    <a href="{{ route('orders.my_orders') }}" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        Pesanan Saya
                    </a>
                    <a href="#tentang" class="hidden 2xl:inline-flex px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-stone-700 hover:text-kopi-dark hover:bg-stone-100 transition-all whitespace-nowrap">
                        Tentang Kami
                    </a>
                </div>

                <!-- 3. Right: Actions (Wishlist, Cart, Profile/Login, Mobile Menu) -->
                <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                    
                    <!-- Wishlist Button (sm+) -->
                    <button type="button" onclick="toggleWishlistFilter()" id="headerWishlistBtn" class="hidden sm:flex relative h-10 w-10 rounded-full bg-stone-100/80 hover:bg-white border border-kopi-border/70 items-center justify-center text-stone-700 hover:text-red-500 transition-all shadow-sm shrink-0" title="Lihat Wishlist">
                        <i id="headerWishlistIcon" class="fa-regular fa-heart text-sm"></i>
                        <span id="wishlist-counter" class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-xs">0</span>
                    </button>

                    <!-- Shopping Cart Button -->
                    <button onclick="toggleCart()" class="relative h-10 flex items-center gap-2 bg-gradient-to-r from-kopi-espresso to-kopi-dark hover:from-[#2c1813] hover:to-black text-white px-3.5 sm:px-4 rounded-full font-medium shadow-sm hover:shadow transition-all group shrink-0">
                        <i class="fa-solid fa-bag-shopping text-sm text-kopi-accent group-hover:scale-110 transition-transform"></i>
                        <span class="hidden xl:inline text-xs font-semibold">Keranjang</span>
                        <span id="cart-counter" class="bg-kopi-accent text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded-full shadow-xs">0</span>
                    </button>

                    <!-- User Profile Dropdown (Tampil saat sudah Login) -->
                    @auth
                    <div class="relative shrink-0" id="profile-dropdown-container">
                        <button onclick="toggleProfileDropdown(event)" class="h-10 flex items-center gap-1.5 sm:gap-2 pl-1.5 pr-2.5 sm:pr-3 rounded-full border border-kopi-border/70 bg-stone-100/80 hover:bg-white text-kopi-dark transition-all focus:outline-none shadow-sm shrink-0" title="Akun: {{ Auth::user()->name }}">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-tr from-kopi-accent to-[#e2b58d] flex items-center justify-center text-white font-bold text-xs shadow-xs shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="inline-block text-xs font-bold text-kopi-dark max-w-[75px] sm:max-w-[110px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[9px] text-stone-400"></i>
                        </button>

                        <!-- Dropdown Menu Box -->
                        <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-kopi-border py-2 z-50 transform origin-top-right transition-all">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-stone-100 bg-kopi-cream/60 rounded-t-2xl">
                                <p class="text-xs font-bold text-kopi-dark leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-stone-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="text-[9px] font-bold uppercase tracking-wider bg-kopi-espresso text-kopi-cream px-2 py-0.5 rounded-full">
                                        {{ Auth::user()->roles->first()->name ?? 'Pelanggan' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Menu Links -->
                            <div class="py-1.5">
                                <a href="{{ route('orders.my_orders') }}" class="flex items-center justify-between px-4 py-2 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-kopi-accent/15 text-kopi-accent flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-receipt"></i>
                                        </div>
                                        <span>Pesanan Saya</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-stone-400"></i>
                                </a>

                                <button onclick="toggleProfileDropdown(); toggleCart();" class="w-full flex items-center justify-between px-4 py-2 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium text-left">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-kopi-accent/15 text-kopi-accent flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <span>Keranjang Belanja</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-stone-400"></i>
                                </button>

                                @hasanyrole('admin|staff|admin toko|Admin Toko|admin toko a|admin toko b|admin toko c')
                                <a href="{{ route('home') }}" class="flex items-center justify-between px-4 py-2 text-xs text-stone-700 hover:bg-kopi-cream hover:text-kopi-dark transition-colors font-medium">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs">
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
                    <!-- Tombol Login (Tampil Jelas untuk Pengunjung / Tamu di Semua Layar) -->
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 h-10 text-xs font-bold text-white bg-gradient-to-r from-kopi-espresso to-kopi-dark hover:from-[#2c1813] hover:to-black border border-kopi-dark px-3.5 sm:px-4 rounded-full shadow-sm hover:shadow transition-all shrink-0" title="Login ke akun Anda">
                        <i class="fa-solid fa-arrow-right-to-bracket text-kopi-accent text-sm"></i> <span>Login</span>
                    </a>
                    @endauth

                    <!-- Mobile Hamburger Menu Button (lg:hidden) -->
                    <div class="lg:hidden flex items-center shrink-0">
                        <button onclick="toggleMobileMenu()" class="h-10 w-10 rounded-xl bg-stone-100/80 hover:bg-white border border-kopi-border/70 flex items-center justify-center text-kopi-dark hover:text-kopi-accent transition-colors shadow-sm" title="Menu Navigasi">
                            <i class="fa-solid fa-bars text-base"></i>
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown (Drawer) -->
        <div id="mobile-menu-drawer" class="lg:hidden hidden bg-white border-t border-kopi-border/80 px-4 py-5 space-y-4 shadow-xl max-h-[85vh] overflow-y-auto">
            <!-- Mobile Search Bar in Drawer -->
            <div class="relative w-full">
                <input type="text" 
                       id="mobileSearchInput" 
                       oninput="handleSearch(this.value)" 
                       placeholder="Cari kopi Arabica, Robusta, Gayo..." 
                       class="w-full bg-stone-100 border border-kopi-border/70 rounded-xl py-2.5 pl-9 pr-8 text-xs focus:outline-none focus:ring-2 focus:ring-kopi-accent/40 text-kopi-dark placeholder-stone-400">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-stone-400 text-xs"></i>
            </div>

            @auth
            <!-- User Info Card in Mobile Drawer -->
            <div class="flex items-center gap-3 p-3 bg-kopi-cream/70 rounded-2xl border border-kopi-border/60">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-kopi-accent to-[#e2b58d] flex items-center justify-center text-white font-bold shrink-0 shadow-xs">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-bold text-sm text-kopi-dark truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-stone-500 truncate">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wider bg-kopi-espresso text-kopi-cream px-2 py-0.5 rounded-full">
                        {{ Auth::user()->roles->first()->name ?? 'Pelanggan' }}
                    </span>
                </div>
            </div>
            @endauth

            <!-- Mobile Navigation Links Grouped -->
            <div class="space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block px-2 mb-1">Kategori Produk</span>
                <a href="#katalog" onclick="filterCategory('all', event); toggleMobileMenu();" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-mug-hot text-kopi-accent w-5"></i> Semua Kopi
                </a>
                <a href="#katalog" onclick="filterCategory('single-origin', event); toggleMobileMenu();" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-seedling text-kopi-accent w-5"></i> Single Origin
                </a>
                <a href="#katalog" onclick="filterCategory('house-blend', event); toggleMobileMenu();" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-fire text-kopi-accent w-5"></i> House Blend
                </a>
                <a href="#katalog" onclick="filterCategory('cold-brew-rtd', event); toggleMobileMenu();" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-bottle-water text-kopi-accent w-5"></i> Siap Minum
                </a>
            </div>

            <div class="space-y-1 pt-3 border-t border-stone-100">
                <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block px-2 mb-1">Layanan & Akun</span>
                <button type="button" onclick="toggleWishlistFilter(); toggleMobileMenu();" class="w-full flex items-center justify-between text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors text-left">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-heart text-red-500 w-5"></i> Wishlist Saya
                    </div>
                    <span id="mobile-wishlist-counter" class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">0</span>
                </button>
                <a href="{{ route('orders.my_orders') }}" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-receipt text-kopi-accent w-5"></i> Pesanan Saya
                </a>
                <a href="#tentang" onclick="toggleMobileMenu();" class="flex items-center gap-2.5 text-sm font-semibold text-kopi-dark hover:text-kopi-accent hover:bg-stone-50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-circle-info text-kopi-accent w-5"></i> Tentang Kami
                </a>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Admin ' . $storeName . ', saya butuh bantuan seputar pemesanan...') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 text-sm font-semibold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50/50 px-2.5 py-2 rounded-xl transition-colors">
                    <i class="fa-brands fa-whatsapp text-emerald-500 w-5 text-base"></i> Bantuan CS WhatsApp
                </a>
            </div>

            @auth
            <div class="space-y-1 pt-3 border-t border-stone-100">
                @hasanyrole('admin|staff|admin toko|Admin Toko|admin toko a|admin toko b|admin toko c')
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-sm font-semibold text-amber-800 bg-amber-50 px-3 py-2 rounded-xl">
                    <i class="fa-solid fa-gauge text-amber-700 w-5"></i> Masuk Panel Admin
                </a>
                @endhasanyrole
                <form action="{{ route('logout') }}" method="POST" class="pt-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-xl w-full text-left transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar (Logout)
                    </button>
                </form>
            </div>
            @else
            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-stone-100">
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-1.5 bg-kopi-espresso text-white text-xs font-bold py-2.5 rounded-xl shadow-xs hover:bg-kopi-dark transition-colors">
                    <i class="fa-solid fa-arrow-right-to-bracket text-kopi-accent"></i> Login / Masuk
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center gap-1.5 border border-kopi-border text-kopi-dark text-xs font-semibold py-2.5 rounded-xl bg-white hover:bg-stone-50 transition-colors">
                    <i class="fa-solid fa-user-plus text-stone-500"></i> Daftar Akun
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
            
            <!-- Catalog Header & Filter Navigation Bar -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 border-b border-stone-100 pb-6">
                <div>
                    <span class="text-xs uppercase font-bold tracking-widest text-kopi-accent block mb-1">Kurasi Roastery Spesialti</span>
                    <h2 class="font-serif text-3xl font-bold text-kopi-dark">Katalog Produk Kopi</h2>
                    <p class="text-xs text-stone-500 mt-1">Biji kopi terbaik Nusantara, disangrai segar siap kirim ke seluruh Indonesia.</p>
                </div>

                <!-- Category Filter Pills (Smooth Scroll-X on Mobile & Clean Wrap on Desktop) -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1.5 max-w-full sm:flex-wrap">
                    <button type="button" data-filter="all" onclick="filterCategory('all', event)" class="cat-pill-btn px-4 py-2 rounded-full text-xs font-bold transition-all bg-kopi-espresso text-white shadow-sm shrink-0 whitespace-nowrap">
                        Semua Kopi
                    </button>
                    <button type="button" data-filter="single-origin" onclick="filterCategory('single-origin', event)" class="cat-pill-btn px-4 py-2 rounded-full text-xs font-medium transition-all bg-stone-100 hover:bg-stone-200 text-stone-700 shrink-0 whitespace-nowrap">
                        Single Origin
                    </button>
                    <button type="button" data-filter="house-blend" onclick="filterCategory('house-blend', event)" class="cat-pill-btn px-4 py-2 rounded-full text-xs font-medium transition-all bg-stone-100 hover:bg-stone-200 text-stone-700 shrink-0 whitespace-nowrap">
                        House Blend
                    </button>
                    <button type="button" data-filter="cold-brew-rtd" onclick="filterCategory('cold-brew-rtd', event)" class="cat-pill-btn px-4 py-2 rounded-full text-xs font-medium transition-all bg-stone-100 hover:bg-stone-200 text-stone-700 shrink-0 whitespace-nowrap">
                        Siap Minum
                    </button>
                    <button type="button" data-filter="wishlist" onclick="filterCategory('wishlist', event)" class="cat-pill-btn px-4 py-2 rounded-full text-xs font-medium transition-all bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center gap-1.5 shrink-0 whitespace-nowrap">
                        <i class="fa-solid fa-heart text-red-500 text-[11px]"></i> Wishlist
                    </button>
                </div>
            </div>

            <!-- Filter / Search Active Feedback Banner -->
            <div id="catalog-filter-info" class="hidden mb-6 flex items-center justify-between bg-kopi-cream px-4 py-2.5 rounded-xl border border-kopi-border text-xs text-kopi-dark">
                <span id="catalog-filter-text"></span>
                <button type="button" onclick="clearSearch()" class="text-kopi-accent font-bold hover:underline flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset Filter
                </button>
            </div>

            <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">

                @foreach ($products as $product)
                @php
                    $prodNameLower = strtolower($product->name);
                    $isSiapSeduh = str_contains($prodNameLower, 'siap seduh') 
                                || str_contains($prodNameLower, 'drip bag') 
                                || str_contains($prodNameLower, 'cold brew') 
                                || str_contains($prodNameLower, 'siap minum') 
                                || str_contains($prodNameLower, 'rtd');

                    if ($isSiapSeduh) {
                        $prodCat = 'cold-brew-rtd';
                        $catLabel = str_contains($prodNameLower, 'drip bag') ? 'Siap Seduh (Drip Bag)' : 'Siap Minum (RTD)';
                    } elseif (str_contains($prodNameLower, 'blend') || str_contains($prodNameLower, 'espresso')) {
                        $prodCat = 'house-blend';
                        $catLabel = 'House Blend';
                    } else {
                        $prodCat = 'single-origin';
                        $catLabel = 'Single Origin';
                    }
                @endphp
                <div class="product-card bg-kopi-cream rounded-2xl overflow-hidden border border-kopi-border/80 flex flex-col justify-between relative group"
                     data-id="{{ $product->id }}"
                     data-name="{{ strtolower($product->name) }}"
                     data-category="{{ $prodCat }}"
                     data-origin="{{ strtolower($product->origin ?? '') }}"
                     data-notes="{{ strtolower($product->tasting_notes ?? '') }}"
                     data-desc="{{ strtolower($product->description ?? '') }}"
                     data-price="{{ $product->price }}">
                    <div class="relative bg-[#eee6dc] h-72 overflow-hidden">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                            <span class="bg-kopi-espresso text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider shadow">Best Seller</span>
                            <span class="badge-sale text-white text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow">Hemat 15%</span>
                        </div>
                        <button type="button" onclick="toggleWishlist({{ $product->id }}, event)" id="card-wishlist-btn-{{ $product->id }}" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-stone-500 hover:text-red-500 flex items-center justify-center transition-colors shadow" title="Tambah ke Favorit">
                            <i class="fa-regular fa-heart text-sm" id="card-wishlist-icon-{{ $product->id }}"></i>
                        </button>

                        <img src="{{ $product->main_image ?: 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600' }}" alt="{{ $product->name }}" class="img-zoom w-full h-full object-cover">
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-stone-500 mb-1.5">
                                <span class="font-medium text-kopi-accent">{{ $catLabel }} • {{ $product->weight ?? 250 }}gr</span>
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
                                <label class="block text-[11px] font-semibold text-stone-600 mb-1">
                                    <i class="fa-solid fa-sliders text-kopi-accent mr-1"></i> Pilihan Gilingan / Varian:
                                </label>
                                <select id="grind-select-{{ $product->id }}" class="w-full text-xs bg-white border border-kopi-border rounded-lg py-1.5 px-2 text-stone-700 focus:outline-none focus:ring-1 focus:ring-kopi-accent shadow-xs">
                                    @if ($isSiapSeduh)
                                        @php
                                            $siapSeduhOpt = $JenisProducts->firstWhere('id', 5) ?? $JenisProducts->first();
                                        @endphp
                                        <option value="{{ $siapSeduhOpt->id }}" selected>
                                            ☕ Siap Seduh / Siap Minum (Praktis)
                                        </option>
                                    @else
                                        @php
                                            // Urutan sesuai permintaan: Giling Halus, Giling Sedang, Giling Kasar, Biji Utuh, Siap Seduh
                                            $sortedJenis = collect([
                                                $JenisProducts->firstWhere('id', 2), // Giling Halus
                                                $JenisProducts->firstWhere('id', 3), // Giling Sedang
                                                $JenisProducts->firstWhere('id', 4), // Giling Kasar
                                                $JenisProducts->firstWhere('id', 1), // Biji Utuh
                                                $JenisProducts->firstWhere('id', 5), // Siap Seduh
                                            ])->filter();
                                        @endphp
                                        @foreach ($sortedJenis as $jenisProduct)
                                            <option value="{{ $jenisProduct->id }}" {{ $jenisProduct->id == 2 ? 'selected' : '' }}>
                                                {{ $jenisProduct->name }}
                                            </option>
                                        @endforeach
                                    @endif
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

                <!-- Empty State -->
                <div id="no-products-found" class="hidden col-span-full py-16 text-center">
                    <div class="w-16 h-16 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                    <h3 class="font-serif text-lg font-bold text-kopi-dark mb-1">Produk Tidak Ditemukan</h3>
                    <p id="no-products-message" class="text-xs text-stone-500 max-w-md mx-auto mb-5">
                        Tidak ada produk yang cocok dengan pencarian atau filter yang Anda pilih.
                    </p>
                    <button type="button" onclick="clearSearch()" class="inline-flex items-center gap-2 bg-kopi-espresso text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-kopi-dark transition-colors">
                        <i class="fa-solid fa-rotate-left"></i> Lihat Semua Produk
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer KopiKita -->
    @include('landing_pages.partials.footer')

    <!-- Interactive Slide-over Shopping Cart Drawer -->
    <div id="cart-modal-backdrop" onclick="toggleCart()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden transition-opacity"></div>
    
    <div id="cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col translate-x-full pointer-events-none invisible transition-all duration-300">
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
        updateWishlistUI();
    });

    // 1. Toggle Buka/Tutup Cart Drawer (Slide-Over)
    function toggleCart() {
        const drawer = document.getElementById('cart-drawer');
        const backdrop = document.getElementById('cart-modal-backdrop');
        
        if (drawer.classList.contains('translate-x-full')) {
            drawer.classList.remove('translate-x-full', 'pointer-events-none', 'invisible');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.add('translate-x-full', 'pointer-events-none', 'invisible');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
            document.body.style.overflowX = 'hidden';
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

    // 11. Toggle Mobile Menu Drawer & Mobile Search Bar
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-menu-drawer');
        const searchBar = document.getElementById('mobile-search-bar');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
        if (searchBar && !searchBar.classList.contains('hidden')) {
            searchBar.classList.add('hidden');
        }
    }

    function toggleMobileSearch() {
        const searchBar = document.getElementById('mobile-search-bar');
        const drawer = document.getElementById('mobile-menu-drawer');
        if (drawer && !drawer.classList.contains('hidden')) {
            drawer.classList.add('hidden');
        }
        if (searchBar) {
            searchBar.classList.toggle('hidden');
            if (!searchBar.classList.contains('hidden')) {
                const inp = document.getElementById('mobileSearchInputQuick');
                if (inp) {
                    setTimeout(() => inp.focus(), 50);
                }
            }
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

    // 12. Salin Kode Promo Voucher
    function copyPromoCode(code) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(code).then(() => {
                showToast(`Kode voucher "${code}" berhasil disalin!`);
            }).catch(() => {
                showToast(`Kode voucher: ${code}`);
            });
        } else {
            const tempInput = document.createElement('input');
            tempInput.value = code;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showToast(`Kode voucher "${code}" berhasil disalin!`);
        }
    }

    // 13. Fitur Pencarian Produk Real-Time
    function handleSearch(query) {
        const q = (query || '').trim().toLowerCase();
        
        // Sinkronisasi input pencarian desktop dan mobile
        const desktopInput = document.getElementById('headerSearchInput');
        const mobileInput = document.getElementById('mobileSearchInput');
        const quickInput = document.getElementById('mobileSearchInputQuick');
        const clearBtn = document.getElementById('searchClearBtn');
        const clearBtnMobile = document.getElementById('searchClearBtnMobile');
        
        if (desktopInput && desktopInput.value !== query) desktopInput.value = query;
        if (mobileInput && mobileInput.value !== query) mobileInput.value = query;
        if (quickInput && quickInput.value !== query) quickInput.value = query;
        
        if (clearBtn) {
            if (q.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }
        if (clearBtnMobile) {
            if (q.length > 0) {
                clearBtnMobile.classList.remove('hidden');
            } else {
                clearBtnMobile.classList.add('hidden');
            }
        }
        
        const cards = document.querySelectorAll('.product-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            if (!q) {
                card.style.display = '';
                visibleCount++;
                return;
            }
            
            const name = card.dataset.name || '';
            const origin = card.dataset.origin || '';
            const notes = card.dataset.notes || '';
            const desc = card.dataset.desc || '';
            
            if (name.includes(q) || origin.includes(q) || notes.includes(q) || desc.includes(q)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Gulir otomatis ke katalog jika mulai mengetik dari atas
        if (q.length >= 2 && window.scrollY < 250) {
            const katalogSec = document.getElementById('katalog');
            if (katalogSec) {
                katalogSec.scrollIntoView({ behavior: 'smooth' });
            }
        }
        
        // Perbarui info pencarian dan empty state
        const infoBar = document.getElementById('catalog-filter-info');
        const infoText = document.getElementById('catalog-filter-text');
        const noProducts = document.getElementById('no-products-found');
        
        if (q.length > 0) {
            if (infoBar && infoText) {
                infoBar.classList.remove('hidden');
                infoText.innerHTML = `Hasil pencarian untuk "<strong>${escapeHtml(query)}</strong>" (${visibleCount} produk ditemukan)`;
            }
        } else {
            if (infoBar) infoBar.classList.add('hidden');
        }
        
        if (noProducts) {
            if (visibleCount === 0) {
                noProducts.classList.remove('hidden');
                document.getElementById('no-products-message').innerText = `Tidak ada produk kopi yang cocok dengan kata kunci "${query}".`;
            } else {
                noProducts.classList.add('hidden');
            }
        }
    }

    // 14. Reset / Bersihkan Pencarian & Filter
    function clearSearch() {
        const desktopInput = document.getElementById('headerSearchInput');
        const mobileInput = document.getElementById('mobileSearchInput');
        const quickInput = document.getElementById('mobileSearchInputQuick');
        const clearBtn = document.getElementById('searchClearBtn');
        const clearBtnMobile = document.getElementById('searchClearBtnMobile');
        if (desktopInput) desktopInput.value = '';
        if (mobileInput) mobileInput.value = '';
        if (quickInput) quickInput.value = '';
        if (clearBtn) clearBtn.classList.add('hidden');
        if (clearBtnMobile) clearBtnMobile.classList.add('hidden');
        filterCategory('all');
    }

    // 15. Filter Kategori Produk dari Header & Tab Pills
    window.currentCategoryFilter = 'all';
    function filterCategory(category, e) {
        if (e && typeof e.preventDefault === 'function') {
            e.preventDefault();
        }
        
        window.currentCategoryFilter = category;
        
        // Bersihkan input teks pencarian saat berganti kategori
        const desktopInput = document.getElementById('headerSearchInput');
        const mobileInput = document.getElementById('mobileSearchInput');
        const clearBtn = document.getElementById('searchClearBtn');
        if (desktopInput) desktopInput.value = '';
        if (mobileInput) mobileInput.value = '';
        if (clearBtn) clearBtn.classList.add('hidden');
        
        // Perbarui status aktif tab kategori
        document.querySelectorAll('.cat-pill-btn').forEach(btn => {
            if (btn.dataset.filter === category) {
                btn.className = 'cat-pill-btn px-4 py-2 rounded-full text-xs font-bold transition-all bg-kopi-espresso text-white shadow-sm';
            } else {
                btn.className = 'cat-pill-btn px-4 py-2 rounded-full text-xs font-medium transition-all bg-stone-100 hover:bg-stone-200 text-stone-700';
            }
        });
        
        const cards = document.querySelectorAll('.product-card');
        const wishlist = getWishlist();
        let visibleCount = 0;
        
        cards.forEach(card => {
            const cardCat = card.dataset.category;
            const cardId = parseInt(card.dataset.id);
            
            let show = false;
            if (category === 'all') {
                show = true;
            } else if (category === 'wishlist') {
                show = wishlist.includes(cardId);
            } else if (category === cardCat) {
                show = true;
            }
            
            if (show) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Smooth scroll ke bagian katalog jika diklik dari menu navigasi
        const katalogSec = document.getElementById('katalog');
        if (katalogSec && e) {
            katalogSec.scrollIntoView({ behavior: 'smooth' });
        }
        
        const categoryLabels = {
            'all': 'Semua Produk',
            'single-origin': 'Single Origin',
            'house-blend': 'House Blend',
            'cold-brew-rtd': 'Siap Minum (Cold Brew & RTD)',
            'wishlist': 'Wishlist (Produk Favorit Anda)'
        };
        
        const infoBar = document.getElementById('catalog-filter-info');
        const infoText = document.getElementById('catalog-filter-text');
        const noProducts = document.getElementById('no-products-found');
        
        if (category !== 'all') {
            if (infoBar && infoText) {
                infoBar.classList.remove('hidden');
                infoText.innerHTML = `Menampilkan kategori: <strong>${categoryLabels[category] || category}</strong> (${visibleCount} produk)`;
            }
        } else {
            if (infoBar) infoBar.classList.add('hidden');
        }
        
        if (noProducts) {
            if (visibleCount === 0) {
                noProducts.classList.remove('hidden');
                if (category === 'wishlist') {
                    document.getElementById('no-products-message').innerText = 'Belum ada produk di Wishlist Anda. Klik ikon hati pada kartu produk untuk menambahkan!';
                } else {
                    document.getElementById('no-products-message').innerText = `Belum ada produk untuk kategori ${categoryLabels[category] || category}.`;
                }
            } else {
                noProducts.classList.add('hidden');
            }
        }
    }

    // 16. Logika Wishlist Terintegrasi (LocalStorage)
    function getWishlist() {
        try {
            return JSON.parse(localStorage.getItem('kopikita_wishlist') || '[]');
        } catch (e) {
            return [];
        }
    }

    function saveWishlist(list) {
        localStorage.setItem('kopikita_wishlist', JSON.stringify(list));
        updateWishlistUI();
    }

    function updateWishlistUI() {
        const list = getWishlist();
        const count = list.length;
        
        const counterBadge = document.getElementById('wishlist-counter');
        const mobileCounterBadge = document.getElementById('mobile-wishlist-counter');
        const headerIcon = document.getElementById('headerWishlistIcon');
        
        if (counterBadge) counterBadge.innerText = count;
        if (mobileCounterBadge) mobileCounterBadge.innerText = count;
        
        if (headerIcon) {
            if (count > 0) {
                headerIcon.classList.remove('fa-regular');
                headerIcon.classList.add('fa-solid', 'text-red-500');
            } else {
                headerIcon.classList.remove('fa-solid', 'text-red-500');
                headerIcon.classList.add('fa-regular');
            }
        }
        
        document.querySelectorAll('.product-card').forEach(card => {
            const id = parseInt(card.dataset.id);
            const heartIcon = document.getElementById(`card-wishlist-icon-${id}`);
            if (heartIcon) {
                if (list.includes(id)) {
                    heartIcon.classList.remove('fa-regular', 'text-stone-500');
                    heartIcon.classList.add('fa-solid', 'text-red-500');
                } else {
                    heartIcon.classList.remove('fa-solid', 'text-red-500');
                    heartIcon.classList.add('fa-regular', 'text-stone-500');
                }
            }
        });
    }

    function toggleWishlist(productId, e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        let list = getWishlist();
        const idx = list.indexOf(productId);
        
        if (idx > -1) {
            list.splice(idx, 1);
            saveWishlist(list);
            showToast('Produk dihapus dari Wishlist');
        } else {
            list.push(productId);
            saveWishlist(list);
            showToast('Produk ditambahkan ke Wishlist!');
        }
        
        if (window.currentCategoryFilter === 'wishlist') {
            filterCategory('wishlist');
        }
    }

    function toggleWishlistFilter() {
        const katalogSec = document.getElementById('katalog');
        if (katalogSec) {
            katalogSec.scrollIntoView({ behavior: 'smooth' });
        }
        
        const list = getWishlist();
        if (list.length === 0) {
            showToast('Wishlist Anda masih kosong!');
        }
        filterCategory('wishlist');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }
</script>
</body>
</html>