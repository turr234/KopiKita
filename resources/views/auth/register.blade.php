<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - KOPIKITA</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
<body class="font-sans bg-kopi-cream text-kopi-dark antialiased min-h-screen flex flex-col justify-between selection:bg-kopi-accent selection:text-white">

    <!-- Header Sederhana -->
    <header class="p-6">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('landing_pages.index') }}" class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-kopi-espresso flex items-center justify-center text-kopi-accent shadow-md">
                    <i class="fa-solid fa-mug-hot text-lg"></i>
                </div>
                <div>
                    <span class="font-serif font-bold text-xl tracking-wider text-kopi-dark block leading-none">KOPIKITA</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-kopi-accent">Roastery & Store</span>
                </div>
            </a>
            <a href="{{ route('landing_pages.index') }}" class="text-xs sm:text-sm font-semibold text-kopi-medium hover:text-kopi-accent transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Main Register Container -->
    <main class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-3xl border border-kopi-border shadow-xl p-6 sm:p-8">
            
            <div class="text-center mb-6">
                <span class="text-[10px] font-bold uppercase tracking-widest text-kopi-accent bg-kopi-cream px-3 py-1 rounded-full border border-kopi-border">
                    Bergabung Bersama Kami
                </span>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-kopi-dark mt-2">Daftar Akun Baru</h1>
                <p class="text-xs text-stone-500 mt-1">Buat akun untuk memesan kopi Nusantara segar langsung ke meja Anda.</p>
            </div>

            <!-- Error Notification Alert -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
                    <span class="font-bold block mb-1">Pendaftaran Belum Lengkap:</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Contoh: Budi Santoso"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-regular fa-user absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="nama@email.com"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp / Telepon <span class="text-stone-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                            placeholder="081234567890"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-solid fa-phone absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label for="password-confirm" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi kata sandi"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-solid fa-shield-halved absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full mt-3 bg-gradient-to-r from-kopi-accent to-[#b47743] hover:from-[#d99863] hover:to-kopi-accent text-white py-3.5 rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:scale-98 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>

            <!-- Link ke Login -->
            <div class="mt-6 text-center text-xs text-stone-600 pt-4 border-t border-stone-100">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-kopi-accent hover:underline">
                    Masuk di sini
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="p-4 text-center text-xs text-stone-400">
        &copy; {{ date('Y') }} KOPIKITA Roastery & Store.
    </footer>

</body>
</html>
