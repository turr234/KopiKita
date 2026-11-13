<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pemesanan - KOPIKITA</title>
    
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
</head>
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col selection:bg-kopi-accent selection:text-white">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-kopi-border sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shadow-md">
                    <i class="fa-solid fa-mug-hot text-xl"></i>
                </div>
                <div>
                    <span class="font-serif font-bold text-2xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-kopi-accent">Checkout Pemesanan</span>
                </div>
            </a>
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('landing_pages.index') }}" class="text-xs sm:text-sm font-semibold text-kopi-medium hover:text-kopi-accent transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali Belanja
                </a>
                <a href="{{ route('orders.my_orders') }}" class="text-xs sm:text-sm font-semibold bg-kopi-cream hover:bg-stone-200/70 border border-kopi-border px-3.5 py-2 rounded-xl text-kopi-dark transition-colors">
                    <i class="fa-solid fa-receipt mr-1 text-kopi-accent"></i> Pesanan Saya
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

    <!-- Main Checkout Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Breadcrumb & Header Title -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-2">
                <a href="{{ route('landing_pages.index') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-stone-400">Keranjang</span>
                <span>/</span>
                <span class="text-kopi-accent font-semibold">Formulir Pemesanan</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-kopi-dark">Penyelesaian Pemesanan</h1>
            <p class="text-stone-600 text-sm mt-1">Lengkapi alamat pengiriman dan pilih metode pembayaran untuk memproses pesanan Anda.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation"></i> Harap periksa kolom yang belum lengkap:
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Form Pengiriman & Pembayaran (8 cols) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                    
                    <!-- Card 1: Informasi Penerima & Alamat Kirim -->
                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-kopi-border shadow-sm">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100 mb-5">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-kopi-accent/20 text-kopi-espresso flex items-center justify-center font-bold text-sm">1</span>
                                <h2 class="font-serif font-bold text-xl text-kopi-dark">Alamat & Data Penerima</h2>
                            </div>
                            @if($addresses->isNotEmpty())
                                <span class="text-xs text-stone-500 font-medium">Tersedia {{ $addresses->count() }} alamat tersimpan</span>
                            @endif
                        </div>

                        <!-- Opsi Pilih Alamat Tersimpan (Jika ada) -->
                        @if($addresses->isNotEmpty())
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Pilih dari Buku Alamat</label>
                                <select id="saved-address-selector" onchange="applySavedAddress(this)" class="w-full bg-stone-50 border border-kopi-border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                                    <option value="" data-empty="true">-- Input Alamat Baru / Kustom --</option>
                                    @foreach($addresses as $addr)
                                        <option value="{{ $addr->id }}"
                                            data-name="{{ $addr->recipient_name }}"
                                            data-phone="{{ $addr->phone }}"
                                            data-province="{{ $addr->province }}"
                                            data-city="{{ $addr->city }}"
                                            data-district="{{ $addr->district }}"
                                            data-village="{{ $addr->village }}"
                                            data-postal="{{ $addr->postal_code }}"
                                            data-address="{{ $addr->full_address }}"
                                            {{ (old('address_id', $primaryAddress->id ?? '') == $addr->id) ? 'selected' : '' }}>
                                            {{ $addr->label ? '[' . $addr->label . '] ' : '' }}{{ $addr->recipient_name }} - {{ $addr->city }}, {{ $addr->province }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <input type="hidden" name="address_id" id="address_id" value="{{ old('address_id', $primaryAddress->id ?? '') }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="recipient_name" class="block text-xs font-semibold text-stone-700 mb-1.5">Nama Lengkap Penerima <span class="text-red-500">*</span></label>
                                <input type="text" name="recipient_name" id="recipient_name" required
                                    value="{{ old('recipient_name', $primaryAddress->recipient_name ?? Auth::user()->name) }}"
                                    placeholder="Contoh: Budi Santoso"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                            <div>
                                <label for="recipient_phone" class="block text-xs font-semibold text-stone-700 mb-1.5">Nomor WhatsApp / Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="recipient_phone" id="recipient_phone" required
                                    value="{{ old('recipient_phone', $primaryAddress->phone ?? Auth::user()->phone) }}"
                                    placeholder="Contoh: 081234567890"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="province" class="block text-xs font-semibold text-stone-700 mb-1.5">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" name="province" id="province" required
                                    value="{{ old('province', $primaryAddress->province ?? 'Jawa Barat') }}"
                                    placeholder="Jawa Barat"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                            <div>
                                <label for="city" class="block text-xs font-semibold text-stone-700 mb-1.5">Kota / Kabupaten <span class="text-red-500">*</span></label>
                                <input type="text" name="city" id="city" required
                                    value="{{ old('city', $primaryAddress->city ?? 'Bandung') }}"
                                    placeholder="Bandung"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                            <div>
                                <label for="district" class="block text-xs font-semibold text-stone-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" name="district" id="district" required
                                    value="{{ old('district', $primaryAddress->district ?? 'Coblong') }}"
                                    placeholder="Coblong"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="village" class="block text-xs font-semibold text-stone-700 mb-1.5">Kelurahan / Desa</label>
                                <input type="text" name="village" id="village"
                                    value="{{ old('village', $primaryAddress->village ?? 'Dago') }}"
                                    placeholder="Dago"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-xs font-semibold text-stone-700 mb-1.5">Kode Pos</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    value="{{ old('postal_code', $primaryAddress->postal_code ?? '40135') }}"
                                    placeholder="40135"
                                    class="w-full bg-white border border-kopi-border rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="shipping_address" class="block text-xs font-semibold text-stone-700 mb-1.5">Alamat Lengkap Pengiriman <span class="text-red-500">*</span></label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" required
                                placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, atau patokan lokasi..."
                                class="w-full bg-white border border-kopi-border rounded-xl p-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">{{ old('shipping_address', $primaryAddress->full_address ?? '') }}</textarea>
                        </div>

                        @if($addresses->isEmpty())
                            <div class="flex items-center gap-2.5 mt-3">
                                <input type="checkbox" name="save_address" id="save_address" value="1" checked class="w-4 h-4 text-kopi-accent rounded border-stone-300 focus:ring-kopi-accent">
                                <label for="save_address" class="text-xs text-stone-600">Simpan alamat ini ke buku alamat saya untuk pemesanan berikutnya</label>
                            </div>
                        @endif
                    </div>

                    <!-- Card 2: Metode Pengiriman / Kurir -->
                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-kopi-border shadow-sm">
                        <div class="flex items-center gap-3 pb-4 border-b border-stone-100 mb-5">
                            <span class="w-8 h-8 rounded-full bg-kopi-accent/20 text-kopi-espresso flex items-center justify-center font-bold text-sm">2</span>
                            <div>
                                <h2 class="font-serif font-bold text-xl text-kopi-dark">Opsi Pengiriman Kurir</h2>
                                <p class="text-xs text-stone-500">Pilih layanan ekspedisi atau jemput pesanan langsung</p>
                            </div>
                        </div>

                        <div class="space-y-3" id="shipping-options-container">
                            
                            <!-- Reguler Delivery -->
                            <label class="shipping-card block border-2 border-kopi-accent bg-kopi-cream/40 rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all relative">
                                <input type="radio" name="shipping_method" value="Reguler (JNE / J&T Express)" 
                                    data-cost="{{ ($subtotal >= 150000) ? 0 : 15000 }}"
                                    checked onchange="handleShippingChange(this)"
                                    class="sr-only">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm text-kopi-dark block">Reguler (JNE / J&T Express)</span>
                                            <span class="text-xs text-stone-500">Estimasi tiba 2-4 hari kerja</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($subtotal >= 150000)
                                            <span class="text-xs line-through text-stone-400 block">Rp 15.000</span>
                                            <span class="font-bold text-sm text-emerald-600">GRATIS</span>
                                        @else
                                            <span class="font-bold text-sm text-kopi-dark">Rp 15.000</span>
                                        @endif
                                    </div>
                                </div>
                            </label>

                            <!-- Express Delivery -->
                            <label class="shipping-card block border-2 border-kopi-border rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all relative">
                                <input type="radio" name="shipping_method" value="Express Same-Day / Next-Day" 
                                    data-cost="25000"
                                    onchange="handleShippingChange(this)"
                                    class="sr-only">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg">
                                            <i class="fa-solid fa-bolt"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm text-kopi-dark block">Express Same-Day / Next-Day</span>
                                            <span class="text-xs text-stone-500">Estimasi tiba 24 jam setelah roasting</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-sm text-kopi-dark">Rp 25.000</span>
                                    </div>
                                </div>
                            </label>

                            <!-- Self Pickup -->
                            <label class="shipping-card block border-2 border-kopi-border rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all relative">
                                <input type="radio" name="shipping_method" value="Ambil di Toko (Outlet KOPIKITA)" 
                                    data-cost="0"
                                    onchange="handleShippingChange(this)"
                                    class="sr-only">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg">
                                            <i class="fa-solid fa-shop"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm text-kopi-dark block">Ambil di Outlet KOPIKITA</span>
                                            <span class="text-xs text-stone-500">Ambil langsung pesanan di roastery kami</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-sm text-emerald-600">Rp 0 (Gratis)</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Card 3: Metode Pembayaran -->
                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-kopi-border shadow-sm">
                        <div class="flex items-center gap-3 pb-4 border-b border-stone-100 mb-5">
                            <span class="w-8 h-8 rounded-full bg-kopi-accent/20 text-kopi-espresso flex items-center justify-center font-bold text-sm">3</span>
                            <div>
                                <h2 class="font-serif font-bold text-xl text-kopi-dark">Metode Pembayaran</h2>
                                <p class="text-xs text-stone-500">Pilih saluran pembayaran resmi dan terpercaya</p>
                            </div>
                        </div>

                        <div class="space-y-3" id="payment-options-container">
                            
                            <!-- QRIS DOKU Payment Gateway (Otomatis & Langsung Muncul QR) -->
                            <label class="payment-card block border-2 border-kopi-accent bg-kopi-cream/40 rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all">
                                <input type="radio" name="payment_method" value="qris" checked onchange="handlePaymentChange(this)" class="sr-only">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-red-600 text-white flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                                        <i class="fa-solid fa-qrcode"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-sm text-kopi-dark">QRIS (DOKU Payment Gateway)</span>
                                                <span class="text-[10px] font-bold bg-red-600 text-white px-2 py-0.5 rounded tracking-wider">QRIS</span>
                                            </div>
                                            <span class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                                <i class="fa-solid fa-bolt text-[10px]"></i> QR Langsung Muncul
                                            </span>
                                        </div>
                                        <p class="text-xs text-stone-600 mt-1">
                                            Scan langsung dari <strong>BCA Mobile, Livin' Mandiri, BRImo, BNI, GoPay, OVO, DANA, ShopeePay</strong>. Kode QRIS langsung tampil di layar pesanan Anda <em>(tanpa perlu buka/install aplikasi DOKU)</em>.
                                        </p>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-2.5 pt-2 border-t border-stone-200/60 text-[11px] text-stone-600">
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">BCA Mobile</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">Livin Mandiri</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">BRImo</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">BNI Mobile</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">GoPay</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">OVO</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">DANA</span>
                                            <span class="bg-white px-2 py-0.5 rounded border border-stone-200 font-medium">ShopeePay</span>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Virtual Account DOKU -->
                            <label class="payment-card block border-2 border-kopi-border rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all">
                                <input type="radio" name="payment_method" value="doku_va" onchange="handlePaymentChange(this)" class="sr-only">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg flex-shrink-0">
                                        <i class="fa-solid fa-credit-card"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-sm text-kopi-dark">Virtual Account Bank (DOKU)</span>
                                            <span class="text-xs font-semibold bg-stone-100 text-stone-700 px-2 py-0.5 rounded-full">Otomatis</span>
                                        </div>
                                        <p class="text-xs text-stone-500 mt-0.5">BCA Virtual Account, Mandiri, BRI, BNI, Permata.</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Transfer Bank Manual -->
                            <label class="payment-card block border-2 border-kopi-border rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all">
                                <input type="radio" name="payment_method" value="bank_transfer" onchange="handlePaymentChange(this)" class="sr-only">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg flex-shrink-0">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-sm text-kopi-dark">Transfer Rekening KOPIKITA (Manual)</span>
                                            <span class="text-xs font-semibold bg-stone-100 text-stone-700 px-2 py-0.5 rounded-full">Manual</span>
                                        </div>
                                        <p class="text-xs text-stone-500 mt-0.5">BCA, Mandiri (Rekening ditampilkan setelah checkout).</p>
                                        
                                        @if($bankAccounts->isNotEmpty())
                                            <div class="mt-3 pt-3 border-t border-stone-200/60 grid grid-cols-2 gap-2 text-xs">
                                                @foreach($bankAccounts as $bank)
                                                    <div class="bg-white p-2 rounded-lg border border-stone-200">
                                                        <span class="font-bold text-kopi-espresso uppercase">{{ $bank->bank_name }}</span>: 
                                                        <span class="font-mono">{{ $bank->account_number }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </label>

                            <!-- Cash On Delivery (COD) -->
                            <label class="payment-card block border-2 border-kopi-border rounded-xl p-4 cursor-pointer hover:border-kopi-accent transition-all">
                                <input type="radio" name="payment_method" value="cod" onchange="handlePaymentChange(this)" class="sr-only">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-white border border-kopi-border flex items-center justify-center text-kopi-accent text-lg flex-shrink-0">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="font-bold text-sm text-kopi-dark block">Cash On Delivery (COD / Bayar di Tempat)</span>
                                        <p class="text-xs text-stone-500 mt-0.5">Bayar tunai langsung kepada kurir saat pesanan sampai di alamat Anda.</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Card 4: Catatan Pesanan -->
                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-kopi-border shadow-sm">
                        <label for="notes" class="block font-serif font-bold text-base text-kopi-dark mb-1">
                            <i class="fa-regular fa-comment-dots text-kopi-accent mr-1.5"></i> Catatan Khusus Pesanan (Opsional)
                        </label>
                        <p class="text-xs text-stone-500 mb-3">Misal: Tingkat kehalusan gilingan tertentu, pesan ucapan kartu, atau instruksi kurir.</p>
                        <textarea name="notes" id="notes" rows="2" placeholder="Contoh: Tolong kirim yang roasting date terbaru atau tambahkan kartu ucapan selamat ulang tahun..."
                            class="w-full bg-white border border-kopi-border rounded-xl p-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-kopi-accent">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <!-- Right Column: Ringkasan Pesanan & Tombol Submit (4 cols) -->
                <div class="lg:col-span-5 xl:col-span-4 sticky top-28 space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 border border-kopi-border shadow-md">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100 mb-4">
                            <h3 class="font-serif font-bold text-lg text-kopi-dark">Ringkasan Pesanan</h3>
                            <span class="text-xs font-bold bg-kopi-cream text-kopi-accent border border-kopi-border px-2.5 py-1 rounded-full">
                                {{ $cart->items->sum('quantity') }} Item
                            </span>
                        </div>

                        <!-- Item Keranjang List -->
                        <div class="divide-y divide-stone-100 max-h-72 overflow-y-auto pr-1 mb-5 space-y-3">
                            @foreach($cart->items as $item)
                                <div class="pt-3 flex gap-3 items-center">
                                    <div class="w-14 h-14 rounded-xl bg-stone-100 flex-shrink-0 overflow-hidden border border-stone-200">
                                        <img src="{{ $item->product->main_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuATGtbnSxfLsQln4wTvabPloC7dU1Bc1O_IANC7MWZnp9-1Z3_8yopNzeVZ0sgW56Zqv3-OHcYNFEKMkGeUClH913mWlxXJSV0ZQZ3VV_8nZvQXKptBJ-LBWpiBwdHvkGEauWcBI4EIIFuW4cjxMwII3XAwdh6RY4UC17VpEHvxHDv9696BYENyyklBZTmHVZ5PyqYQUw-ScymAazPoj925z6vgpyUEdqkWstnS2dT8x4xevbqTNH8' }}" 
                                             alt="{{ $item->product->name ?? 'Produk' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-bold text-kopi-dark truncate leading-tight">
                                            {{ $item->product->name ?? 'Kopi Nusantara' }}
                                        </h4>
                                        <p class="text-[11px] text-stone-500 mt-0.5">
                                            Varian: <span class="font-semibold text-kopi-accent">{{ $item->jenisProduct->name ?? 'Original' }}</span>
                                        </p>
                                        <div class="flex justify-between items-center mt-1">
                                            <span class="text-xs text-stone-600 font-medium">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            <span class="text-xs font-bold text-kopi-dark">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Kalkulasi Harga -->
                        <div class="space-y-2.5 pt-4 border-t border-kopi-border text-xs sm:text-sm">
                            <div class="flex justify-between text-stone-600">
                                <span>Subtotal Belanja</span>
                                <span class="font-semibold text-kopi-dark" id="display-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-stone-600">
                                <span>Biaya Pengiriman</span>
                                <span class="font-semibold" id="display-shipping">
                                    @if($shippingCost === 0)
                                        <span class="text-emerald-600 font-bold">GRATIS</span>
                                    @else
                                        Rp {{ number_format($shippingCost, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            @if($subtotal >= 150000)
                                <div class="p-2 rounded-lg bg-emerald-50 text-[11px] text-emerald-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Selamat! Anda mendapatkan promo <strong>Gratis Ongkir</strong> se-Indonesia.</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-base sm:text-lg font-bold text-kopi-dark pt-3 border-t border-kopi-border">
                                <span>Total Tagihan</span>
                                <span class="text-kopi-espresso font-serif" id="display-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Tombol Submit Pemesanan -->
                        <button type="submit" id="submit-order-btn"
                            class="w-full mt-6 bg-gradient-to-r from-kopi-accent to-[#b47743] hover:from-[#d99863] hover:to-kopi-accent text-white py-4 rounded-xl font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:scale-98 flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-bag-shopping"></i> Konfirmasi & Pesan Sekarang
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-[11px] text-stone-400">
                            <i class="fa-solid fa-lock text-stone-400"></i>
                            <span>Transaksi Terenkripsi & Dijamin 100% Aman</span>
                        </div>
                    </div>

                    <!-- Bantuan Order -->
                    <div class="bg-kopi-cream/70 rounded-xl p-4 border border-kopi-border text-xs text-stone-600 flex items-start gap-3">
                        <i class="fa-solid fa-circle-question text-kopi-accent text-base mt-0.5"></i>
                        <div>
                            <span class="font-bold text-kopi-dark block">Butuh bantuan saat memesan?</span>
                            <span>Hubungi Barista & Customer Support kami melalui WhatsApp jika mengalami kendala.</span>
                        </div>
                    </div>

                </div>

            </div>
        </form>

    </main>

    <!-- Footer KopiKita -->
    @include('landing_pages.partials.footer')

    <!-- Interactive JS for Shipping & Saved Addresses -->
    <script>
        const initialSubtotal = {{ $subtotal }};
        let currentShippingCost = {{ $shippingCost }};

        // 1. Pilih Alamat Tersimpan
        function applySavedAddress(select) {
            const selectedOpt = select.options[select.selectedIndex];
            if (selectedOpt.dataset.empty === "true") {
                document.getElementById('address_id').value = '';
                return;
            }

            document.getElementById('address_id').value = select.value;
            document.getElementById('recipient_name').value = selectedOpt.dataset.name || '';
            document.getElementById('recipient_phone').value = selectedOpt.dataset.phone || '';
            document.getElementById('province').value = selectedOpt.dataset.province || '';
            document.getElementById('city').value = selectedOpt.dataset.city || '';
            document.getElementById('district').value = selectedOpt.dataset.district || '';
            document.getElementById('village').value = selectedOpt.dataset.village || '';
            document.getElementById('postal_code').value = selectedOpt.dataset.postal || '';
            document.getElementById('shipping_address').value = selectedOpt.dataset.address || '';
        }

        // 2. Ubah Metode Pengiriman & Update Total
        function handleShippingChange(radio) {
            // Update styling radio cards
            document.querySelectorAll('.shipping-card').forEach(card => {
                card.classList.remove('border-kopi-accent', 'bg-kopi-cream/40');
                card.classList.add('border-kopi-border');
            });
            const parentCard = radio.closest('.shipping-card');
            if (parentCard) {
                parentCard.classList.remove('border-kopi-border');
                parentCard.classList.add('border-kopi-accent', 'bg-kopi-cream/40');
            }

            currentShippingCost = parseInt(radio.dataset.cost) || 0;
            updateTotals();
        }

        // 3. Ubah Metode Pembayaran Styling
        function handlePaymentChange(radio) {
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('border-kopi-accent', 'bg-kopi-cream/40');
                card.classList.add('border-kopi-border');
            });
            const parentCard = radio.closest('.payment-card');
            if (parentCard) {
                parentCard.classList.remove('border-kopi-border');
                parentCard.classList.add('border-kopi-accent', 'bg-kopi-cream/40');
            }
        }

        function updateTotals() {
            const shippingDisplay = document.getElementById('display-shipping');
            const totalDisplay = document.getElementById('display-total');

            if (currentShippingCost === 0) {
                shippingDisplay.innerHTML = '<span class="text-emerald-600 font-bold">GRATIS</span>';
            } else {
                shippingDisplay.innerText = 'Rp ' + currentShippingCost.toLocaleString('id-ID');
            }

            const newTotal = initialSubtotal + currentShippingCost;
            totalDisplay.innerText = 'Rp ' + newTotal.toLocaleString('id-ID');
        }

        // Cegah double submit
        document.getElementById('checkout-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-order-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses Pesanan...';
        });
    </script>
</body>
</html>
