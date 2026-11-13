@php
    $store = $storeSetting ?? \App\Models\store_setting::first();
    $storeName = $store->store_name ?? 'KOPIKITA';
    $tagline = $store->tagline ?? 'Roastery & Artisan Specialty Coffee';
    $aboutText = $store->about ?? 'Menghadirkan kurasi biji kopi spesialti terbaik dari lereng pegunungan Nusantara. Di-roasting berkala dengan standar artisan untuk menjamin aroma segar dan cita rasa otentik di setiap cangkir Anda.';
    $address = $store->address ?? 'Jl. Ir. H. Juanda No. 128, Dago, Bandung, Jawa Barat';
    $phone = $store->phone ?? '0811-2233-4401';
    $rawWa = $store->whatsapp ?? '6281122334401';
    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $email = $store->email ?? 'halo@kopikita.id';
    $instagram = $store->instagram_url ?? '#';
    $tiktok = $store->tiktok_url ?? '#';
    $facebook = $store->facebook_url ?? '#';
@endphp

<!-- ========================================================
     FOOTER SECTION - KOPIKITA PREMIUM ROASTERY & STORE
     ======================================================== -->
<footer class="bg-gradient-to-b from-[#241510] via-kopi-dark to-[#180d09] text-stone-300 border-t border-kopi-border/20 pt-16 pb-10 relative overflow-hidden">
    
    <!-- Background Coffee Beans Subtle Glow Watermark -->
    <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-kopi-accent/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-24 top-0 w-80 h-80 bg-kopi-accent/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- 1. Value Proposition Highlights Bar -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pb-12 mb-12 border-b border-white/10">
            <!-- Feature 1 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-kopi-accent/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shrink-0 text-xl shadow-inner border border-kopi-accent/20">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div>
                    <h4 class="font-serif font-bold text-white text-sm">100% Kopi Asli Nusantara</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Dipetik dari perkebunan terbaik Indonesia</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-kopi-accent/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shrink-0 text-xl shadow-inner border border-kopi-accent/20">
                    <i class="fa-solid fa-fire-burner"></i>
                </div>
                <div>
                    <h4 class="font-serif font-bold text-white text-sm">Freshly Roasted Weekly</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Roasting berkala untuk menjaga kesegaran</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-kopi-accent/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shrink-0 text-xl shadow-inner border border-kopi-accent/20">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div>
                    <h4 class="font-serif font-bold text-white text-sm">Pilihan Grind Size Lengkap</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Biji utuh atau giling sesuai alat seduh</p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-kopi-accent/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shrink-0 text-xl shadow-inner border border-kopi-accent/20">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-serif font-bold text-white text-sm">Kemasan One-Way Valve</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Degassing pouch kedap udara dengan zipper</p>
                </div>
            </div>
        </div>

        <!-- 2. Main Footer Grid Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-12 border-b border-white/10">
            
            <!-- Column 1: Brand & Bio (5 cols) -->
            <div class="lg:col-span-5 space-y-5">
                <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-kopi-accent to-[#945f34] flex items-center justify-center text-white shadow-lg shadow-kopi-accent/20">
                        <i class="fa-solid fa-mug-hot text-xl"></i>
                    </div>
                    <div>
                        <span class="font-serif font-bold text-2xl tracking-wider text-white block leading-none">KOPIKITA</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-kopi-accent-light">Roastery & Coffee Store</span>
                    </div>
                </a>

                <p class="text-xs text-stone-400 leading-relaxed pr-2">
                    {{ $aboutText }}
                </p>

                <!-- Status Operasional Roastery Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-500/30 text-[11px] text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Roastery Buka & Melayani Pengiriman ke Seluruh Indonesia</span>
                </div>

                <!-- Social Media Buttons -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-3">Ikuti Komunitas KopiKami:</span>
                    <div class="flex items-center gap-2.5">
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/[0.05] hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] flex items-center justify-center text-stone-300 hover:text-white transition-all transform hover:-translate-y-1 shadow-sm border border-white/10" title="Instagram KopiKita">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/[0.05] hover:bg-black flex items-center justify-center text-stone-300 hover:text-white transition-all transform hover:-translate-y-1 shadow-sm border border-white/10" title="TikTok KopiKita">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </a>
                        <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/[0.05] hover:bg-[#1877F2] flex items-center justify-center text-stone-300 hover:text-white transition-all transform hover:-translate-y-1 shadow-sm border border-white/10" title="Facebook KopiKita">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20KopiKita%2C%20saya%20ingin%20tanya%20seputar%20produk%20kopi..." target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/[0.05] hover:bg-[#25D366] flex items-center justify-center text-stone-300 hover:text-white transition-all transform hover:-translate-y-1 shadow-sm border border-white/10" title="WhatsApp Customer Service">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Navigasi & Layanan Pembeli (3 cols) -->
            <div class="lg:col-span-3 space-y-4">
                <h3 class="font-serif font-bold text-white text-base tracking-wide flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-kopi-accent"></span>
                    Bantuan & Layanan
                </h3>
                <ul class="space-y-2.5 text-xs text-stone-400">
                    <li>
                        <a href="#katalog" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-mug-hot text-[10px] text-kopi-accent"></i>
                            Katalog Semua Produk
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('orders.my_orders') }}" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-[10px] text-kopi-accent"></i>
                            Pesanan Saya
                        </a>
                    </li>
                    @endauth
                    <li>
                        <button type="button" onclick="toggleCart()" class="hover:text-kopi-accent transition-colors flex items-center gap-2 text-left">
                            <i class="fa-solid fa-bag-shopping text-[10px] text-kopi-accent"></i>
                            Keranjang Belanja
                        </button>
                    </li>
                    @guest
                    <li>
                        <a href="{{ route('login') }}" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-right-to-bracket text-[10px] text-kopi-accent"></i>
                            Masuk ke Akun
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-[10px] text-kopi-accent"></i>
                            Daftar Akun Baru
                        </a>
                    </li>
                    @endguest
                    <li>
                        <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20KopiKita%2C%20saya%20butuh%20panduan%20cara%20pemesanan..." target="_blank" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-circle-question text-[10px] text-kopi-accent"></i>
                            Panduan Pesan & Bayar
                        </a>
                    </li>
                    <li>
                        <a href="#tentang" class="hover:text-kopi-accent transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-[10px] text-kopi-accent"></i>
                            Tentang KopiKita
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Kontak & Alamat Roastery (4 cols) -->
            <div class="lg:col-span-4 space-y-4">
                <h3 class="font-serif font-bold text-white text-base tracking-wide flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-kopi-accent"></span>
                    Hubungi Roastery
                </h3>
                
                <div class="space-y-3 text-xs text-stone-400">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-kopi-accent mt-0.5 shrink-0 text-sm"></i>
                        <span>{{ $address }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-kopi-accent shrink-0 text-sm"></i>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition-colors">{{ $phone }}</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-brands fa-whatsapp text-emerald-400 shrink-0 text-sm"></i>
                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="hover:text-emerald-400 transition-colors">
                            +{{ $cleanWa }} (CS Fast Response)
                        </a>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-kopi-accent shrink-0 text-sm"></i>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition-colors">{{ $email }}</a>
                    </div>

                    <div class="flex items-center gap-3 pt-1 border-t border-white/5">
                        <i class="fa-regular fa-clock text-kopi-accent shrink-0 text-sm"></i>
                        <span>Buka Setiap Hari: 08.00 - 21.00 WIB</span>
                    </div>
                </div>
            </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-kopi-accent shrink-0 text-sm"></i>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition-colors">{{ $phone }}</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-brands fa-whatsapp text-emerald-400 shrink-0 text-sm"></i>
                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="hover:text-emerald-400 transition-colors">
                            +{{ $cleanWa }} (CS Fast Response)
                        </a>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-kopi-accent shrink-0 text-sm"></i>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition-colors">{{ $email }}</a>
                    </div>

                    <div class="flex items-center gap-3 pt-1 border-t border-white/5">
                        <i class="fa-regular fa-clock text-kopi-accent shrink-0 text-sm"></i>
                        <span>Buka Setiap Hari: 08.00 - 21.00 WIB</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. Payment Methods & Security Guarantee Row -->
        <div class="py-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-white/10 text-xs">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-stone-400 font-medium">Metode Pembayaran Resmi:</span>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-white font-bold text-[10px] tracking-wider border border-white/10">BCA</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-white font-bold text-[10px] tracking-wider border border-white/10">MANDIRI</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-white font-bold text-[10px] tracking-wider border border-white/10">BRI</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-white font-bold text-[10px] tracking-wider border border-white/10">BNI</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-emerald-400 font-bold text-[10px] tracking-wider border border-white/10 flex items-center gap-1">
                        <i class="fa-solid fa-qrcode"></i> QRIS
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-stone-300 font-medium text-[10px] border border-white/10">Transfer Manual</span>
                </div>
            </div>

            <div class="flex items-center gap-4 text-stone-400">
                <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-lock text-emerald-400"></i>
                    <span>Checkout Terenkripsi</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-award text-kopi-accent"></i>
                    <span>Garansi Kualitas 100%</span>
                </div>
            </div>
        </div>

        <!-- 4. Bottom Copyright & Back to Top Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
            <p>
                &copy; {{ date('Y') }} <span class="text-white font-semibold">{{ $storeName }}</span>. Seluruh Hak Cipta Dilindungi. Dibuat dengan kecintaan pada kopi Nusantara.
            </p>

            <div class="flex items-center gap-6">
                <a href="#katalog-produk" class="hover:text-stone-300 transition-colors">Katalog</a>
                <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="hover:text-stone-300 transition-colors">Bantuan</a>
                <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="flex items-center gap-1.5 text-kopi-accent hover:text-kopi-accent-light transition-colors group">
                    <span>Kembali ke Atas</span>
                    <i class="fa-solid fa-arrow-up text-xs transform group-hover:-translate-y-0.5 transition-transform"></i>
                </button>
            </div>
        </div>

    </div>
</footer>
<!-- ========================================================
     END: FOOTER SECTION
     ======================================================== -->
