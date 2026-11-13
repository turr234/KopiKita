<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Login - KOPIKITA</title>
    
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

    <!-- Main Login Container -->
    <main class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-3xl border border-kopi-border shadow-xl p-6 sm:p-8">
            
            <div class="text-center mb-6">
                <span class="text-[10px] font-bold uppercase tracking-widest text-kopi-accent bg-kopi-cream px-3 py-1 rounded-full border border-kopi-border">
                    Selamat Datang Kembali
                </span>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-kopi-dark mt-2">Masuk ke Akun Anda</h1>
                <p class="text-xs text-stone-500 mt-1">Kelola transaksi, keranjang belanja, dan pantau pesanan kopi Anda.</p>
            </div>

            <!-- Error Notification Alert -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-base mt-0.5"></i>
                    <div>
                        <span class="font-bold block">Gagal Masuk:</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="nama@email.com"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-4 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-kopi-accent hover:underline">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full bg-stone-50 border border-kopi-border rounded-xl py-2.5 pl-10 pr-10 text-sm text-kopi-dark focus:outline-none focus:ring-2 focus:ring-kopi-accent focus:bg-white transition-all">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-stone-400 text-xs"></i>
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3 text-stone-400 hover:text-kopi-dark text-xs">
                            <i id="toggle-password-icon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-kopi-accent rounded border-stone-300 focus:ring-kopi-accent">
                        <span class="text-stone-600">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full mt-2 bg-gradient-to-r from-kopi-accent to-[#b47743] hover:from-[#d99863] hover:to-kopi-accent text-white py-3.5 rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:scale-98 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <!-- Link Registrasi -->
            <div class="mt-6 text-center text-xs text-stone-600">
                Belum memiliki akun KopiKita? 
                <a href="{{ route('register') }}" class="font-bold text-kopi-accent hover:underline">
                    Daftar Sekarang
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="p-4 text-center text-xs text-stone-400">
        &copy; {{ date('Y') }} KOPIKITA Roastery & Store.
    </footer>

    <script>
        function togglePasswordVisibility() {
            const pass = document.getElementById('password');
            const icon = document.getElementById('toggle-password-icon');
            if (pass.type === 'password') {
                pass.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pass.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
