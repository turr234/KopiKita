<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'KopiKita Admin - Dashboard')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

  <!-- Local Third-Party Libraries (Spark Admin) -->
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

  <style>
    /* Custom adjustments for KopiKita & nested Bootstrap tables/cards */
    .sidebar-brand i {
      color: #B4F105;
      font-size: 1.5rem;
    }
    .badge-pending-count {
      background-color: #B4F105;
      color: #072F1F;
      font-weight: 700;
      font-size: 0.72rem;
      border-radius: 50rem;
      padding: 0.15rem 0.55rem;
      margin-left: auto;
    }
    .badge-subtle-processing {
      background: rgba(13, 110, 253, 0.15);
      color: #0d6efd;
    }
    .badge-subtle-shipped {
      background: rgba(13, 202, 240, 0.18);
      color: #055160;
    }
    .table td, .table th {
      vertical-align: middle;
    }

    /* Cegah Scroll-X Tidak Diinginkan */
    html, body {
      overflow-x: hidden !important;
      max-width: 100vw;
    }
    .main-wrapper {
      overflow-x: hidden !important;
      max-width: 100%;
    }

    /* Navbar Anti-Collision & Fluid Responsive Flow */
    @media (min-width: 992px) and (max-width: 1400px) {
      .navbar-custom {
        grid-template-columns: auto 1fr auto !important;
        gap: 1rem !important;
      }
      .navbar-search-wrapper {
        max-width: 320px;
        margin: 0 auto;
      }
    }
    @media (max-width: 991px) {
      .navbar-custom {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
      }
      .navbar-search-wrapper {
        order: 3;
        width: 100%;
        max-width: 100%;
      }
    }
  </style>

  @stack('styles')
</head>

<body>
  @auth
    @php
      $globalPendingOrders = \App\Models\order::where('status', 'pending')->latest()->take(5)->get();
      $globalPendingCount = \App\Models\order::where('status', 'pending')->count();
    @endphp

    <!-- ==========================================
           START: Sidebar Component (Spark Admin)
           ========================================== -->
    <aside class="sidebar-wrapper" id="sidebar">
      <!-- Brand Logo / Identity -->
      <a href="{{ route('home') }}" class="sidebar-brand text-decoration-none">
        <i class="bi bi-cup-hot-fill"></i>
        <span>KopiKita Admin</span>
      </a>

      <!-- Navigation Menu -->
      <div class="flex-grow-1 overflow-y-auto">
        <!-- Group: Menu Utama -->
        <div class="sidebar-menu-section">
          <div class="sidebar-menu-title">Menu Utama</div>
          <ul class="sidebar-menu-list">
            <li class="sidebar-menu-item">
              <a href="{{ route('home') }}" class="sidebar-menu-link {{ request()->routeIs('home') ? 'active' : '' }}" title="Dashboard">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="sidebar-menu-item">
              <a href="{{ route('landing_pages.index') }}" class="sidebar-menu-link" target="_blank" title="Lihat Toko">
                <i class="bi bi-shop-window"></i>
                <span>Lihat Toko Web</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Group: Penjualan & Pesanan -->
        <div class="sidebar-menu-section">
          <div class="sidebar-menu-title">Penjualan & Pesanan</div>
          <ul class="sidebar-menu-list">
            @can('view orders')
            <li class="sidebar-menu-item">
              <a href="{{ route('orders.index') }}" class="sidebar-menu-link {{ request()->is('orders*') ? 'active' : '' }}" title="Daftar Pesanan">
                <i class="bi bi-cart-check-fill"></i>
                <span>Pesanan Masuk</span>
                @if($globalPendingCount > 0)
                  <span class="badge-pending-count" title="{{ $globalPendingCount }} pesanan pending">{{ $globalPendingCount }}</span>
                @endif
              </a>
            </li>
            @endcan

            @can('view order items')
            <li class="sidebar-menu-item">
              <a href="{{ route('order_items.index') }}" class="sidebar-menu-link {{ request()->is('order_items*') ? 'active' : '' }}" title="Item Pesanan">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Item Pesanan</span>
              </a>
            </li>
            @endcan

            @can('view order status histories')
            <li class="sidebar-menu-item">
              <a href="{{ route('order_status_histories.index') }}" class="sidebar-menu-link {{ request()->is('order_status_histories*') ? 'active' : '' }}" title="Riwayat Status">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Status</span>
              </a>
            </li>
            @endcan

            @can('view payments')
            <li class="sidebar-menu-item">
              <a href="{{ route('payments.index') }}" class="sidebar-menu-link {{ request()->is('payments*') ? 'active' : '' }}" title="Pembayaran">
                <i class="bi bi-credit-card-2-front-fill"></i>
                <span>Bukti Pembayaran</span>
              </a>
            </li>
            @endcan

            @can('view carts')
            <li class="sidebar-menu-item">
              <a href="{{ route('carts.index') }}" class="sidebar-menu-link {{ request()->is('carts*') ? 'active' : '' }}" title="Keranjang Pembeli">
                <i class="bi bi-cart3"></i>
                <span>Keranjang Belanja</span>
              </a>
            </li>
            @endcan
          </ul>
        </div>

        <!-- Group: Katalog Kopi -->
        <div class="sidebar-menu-section">
          <div class="sidebar-menu-title">Katalog Produk</div>
          <ul class="sidebar-menu-list">
            @can('view product')
            <li class="sidebar-menu-item">
              <a href="{{ route('products.index') }}" class="sidebar-menu-link {{ request()->is('products*') ? 'active' : '' }}" title="Produk Kopi">
                <i class="bi bi-box-seam"></i>
                <span>Produk Kopi</span>
              </a>
            </li>
            @endcan

            @can('view categories')
            <li class="sidebar-menu-item">
              <a href="{{ route('categories.index') }}" class="sidebar-menu-link {{ request()->is('categories*') ? 'active' : '' }}" title="Kategori">
                <i class="bi bi-tags-fill"></i>
                <span>Kategori Produk</span>
              </a>
            </li>
            @endcan

            @canany(['view jenis_products', 'view jenis products'])
            <li class="sidebar-menu-item">
              <a href="{{ route('jenis_products.index') }}" class="sidebar-menu-link {{ request()->is('jenis_products*') ? 'active' : '' }}" title="Varian Grind Size">
                <i class="bi bi-sliders"></i>
                <span>Varian Grind Size</span>
              </a>
            </li>
            @endcanany

            @can('view product images')
            <li class="sidebar-menu-item">
              <a href="{{ route('product_images.index') }}" class="sidebar-menu-link {{ request()->is('product_images*') ? 'active' : '' }}" title="Foto Produk">
                <i class="bi bi-images"></i>
                <span>Galeri Foto</span>
              </a>
            </li>
            @endcan

            @can('view reviews')
            <li class="sidebar-menu-item">
              <a href="{{ route('reviews.index') }}" class="sidebar-menu-link {{ request()->is('reviews*') ? 'active' : '' }}" title="Ulasan Pembeli">
                <i class="bi bi-chat-heart"></i>
                <span>Ulasan Kopi</span>
              </a>
            </li>
            @endcan
          </ul>
        </div>

        <!-- Group: Pengaturan Toko -->
        <div class="sidebar-menu-section">
          <div class="sidebar-menu-title">Pengaturan & Toko</div>
          <ul class="sidebar-menu-list">
            @canany(['view store_settings', 'view store settings'])
            <li class="sidebar-menu-item">
              <a href="{{ route('store_settings.index') }}" class="sidebar-menu-link {{ request()->is('store_settings*') ? 'active' : '' }}" title="Pengaturan Toko">
                <i class="bi bi-gear-wide-connected"></i>
                <span>Profil & CS Toko</span>
              </a>
            </li>
            @endcanany

            @canany(['view bank_accounts', 'view bank accounts'])
            <li class="sidebar-menu-item">
              <a href="{{ route('bank_accounts.index') }}" class="sidebar-menu-link {{ request()->is('bank_accounts*') ? 'active' : '' }}" title="Rekening Bank">
                <i class="bi bi-bank"></i>
                <span>Rekening Bank</span>
              </a>
            </li>
            @endcanany

            @can('view addresses')
            <li class="sidebar-menu-item">
              <a href="{{ route('addresses.index') }}" class="sidebar-menu-link {{ request()->is('addresses*') ? 'active' : '' }}" title="Buku Alamat">
                <i class="bi bi-geo-alt"></i>
                <span>Buku Alamat</span>
              </a>
            </li>
            @endcan
          </ul>
        </div>

        <!-- Group: Pengguna & Hak Akses -->
        <div class="sidebar-menu-section">
          <div class="sidebar-menu-title">Pengguna & Akses</div>
          <ul class="sidebar-menu-list">
            @can('view users')
            <li class="sidebar-menu-item">
              <a href="{{ route('users.index') }}" class="sidebar-menu-link {{ request()->is('users*') ? 'active' : '' }}" title="Manajemen Pengguna">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen User</span>
              </a>
            </li>
            @endcan

            @can('view roles')
            <li class="sidebar-menu-item">
              <a href="{{ route('roles.index') }}" class="sidebar-menu-link {{ request()->is('roles*') ? 'active' : '' }}" title="Role & Permission">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Role & Hak Akses</span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </div>

      <!-- Sidebar Profile Card (Dynamic Footer) -->
      <div class="sidebar-profile">
        <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ Auth::user()->name }}" class="sidebar-profile-img"
             onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
        <div class="sidebar-profile-info">
          <div class="sidebar-profile-name text-truncate" style="max-width: 140px;">{{ Auth::user()->name }}</div>
          @php
            $specialRole = Auth::user()->roles->pluck('name')->first(function($r) {
                return in_array($r, ['admin toko a', 'admin toko b', 'admin toko c', 'admin', 'super admin', 'staff', 'admin toko', 'karyawan']);
            }) ?? Auth::user()->roles->first()?->name ?? 'User';

            $badgeClass = match($specialRole) {
                'admin toko a' => 'badge bg-success',
                'admin toko b' => 'badge bg-primary',
                'admin toko c' => 'badge bg-warning text-dark',
                'admin', 'super admin' => 'badge bg-danger',
                'admin toko'   => 'badge bg-info text-dark',
                'staff', 'karyawan' => 'badge bg-secondary',
                default        => 'badge bg-light text-dark border'
            };

            $labelRole = match($specialRole) {
                'admin toko a' => 'Admin Toko A',
                'admin toko b' => 'Admin Toko B',
                'admin toko c' => 'Admin Toko C',
                'admin', 'super admin' => 'Super Admin',
                'admin toko'   => 'Admin Toko',
                'staff', 'karyawan' => 'Staff Toko',
                default        => ucwords($specialRole)
            };
          @endphp
          <div class="d-flex align-items-center gap-1 mt-1">
            <span class="{{ $badgeClass }}" style="font-size: 0.65rem; padding: 2px 6px;">{{ $labelRole }}</span>
          </div>
        </div>
      </div>
    </aside>
    <!-- ==========================================
           END: Sidebar Component
           ========================================== -->

    <!-- ==========================================
           START: Main Content Area
           ========================================== -->
    <div class="main-wrapper">
      <!-- Top Navbar Component -->
      <header class="navbar-custom">
        <div class="navbar-left">
          <!-- Desktop sidebar toggle -->
          <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
                  id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
            <i class="bi bi-chevron-bar-left"></i>
          </button>
          <!-- Mobile sidebar toggle -->
          <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
            <i class="bi bi-list"></i>
          </button>

          <!-- Quick Actions Dropdown -->
          <div class="dropdown ms-2">
            <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    id="quick-actions-dropdown">
              <i class="bi bi-plus-lg"></i>
              <span>Tambah Cepat</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
              <li class="dropdown-header">Pintasan Tindakan</li>
              @can('create orders')
              <li><a class="dropdown-item" href="{{ route('orders.create') }}"><i class="bi bi-cart-plus me-2 text-primary"></i> Buat Pesanan Baru</a></li>
              @endcan
              @can('create product')
              <li><a class="dropdown-item" href="{{ route('products.create') }}"><i class="bi bi-box-seam me-2 text-success"></i> Tambah Produk Kopi</a></li>
              @endcan
              @can('create categories')
              <li><a class="dropdown-item" href="{{ route('categories.create') }}"><i class="bi bi-tags me-2 text-warning"></i> Tambah Kategori</a></li>
              @endcan
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('store_settings.index') }}"><i class="bi bi-gear me-2 text-secondary"></i> Pengaturan Toko</a></li>
            </ul>
          </div>
        </div>

        <!-- Mid navbar: search pill -->
        <div class="navbar-search-wrapper">
          <input type="text" class="navbar-search-input" placeholder="Cari data di KopiKita..." id="main-search">
          <button class="navbar-search-btn" aria-label="Search">
            <i class="bi bi-search"></i>
          </button>
        </div>

        <!-- Right actions -->
        <div class="navbar-actions">
          <!-- Fullscreen Toggle -->
          <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
            <i class="bi bi-arrows-fullscreen"></i>
          </button>

          <!-- Notification Dropdown: Pending Orders Alert -->
          <div class="dropdown">
            <button class="navbar-action-btn dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
              <i class="bi bi-bell"></i>
              @if($globalPendingCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.65rem;">
                  {{ $globalPendingCount }}
                </span>
              @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0"
                 aria-labelledby="btn-notifications">
              <div class="notification-header d-flex justify-content-between align-items-center">
                <h6 class="notification-title mb-0">Notifikasi Pesanan</h6>
                <span class="badge bg-warning text-dark">{{ $globalPendingCount }} Menunggu Konfirmasi</span>
              </div>
              <div class="notification-list">
                @forelse($globalPendingOrders as $pOrder)
                  <a href="{{ route('orders.show', $pOrder->id) }}" class="notification-item text-decoration-none">
                    <div class="notification-icon bg-warning text-dark">
                      <i class="bi bi-cart-fill"></i>
                    </div>
                    <div class="notification-content">
                      <p class="notification-text mb-0">Pesanan <strong>#{{ $pOrder->order_number }}</strong> dari {{ $pOrder->recipient_name }}</p>
                      <span class="notification-time text-muted small">Rp {{ number_format($pOrder->total, 0, ',', '.') }} • {{ $pOrder->created_at ? $pOrder->created_at->diffForHumans() : '' }}</span>
                    </div>
                    <span class="notification-unread-dot"></span>
                  </a>
                @empty
                  <div class="p-4 text-center text-muted small">
                    <i class="bi bi-check2-circle fs-3 text-success d-block mb-1"></i>
                    Semua pesanan sudah dikonfirmasi!
                  </div>
                @endforelse
              </div>
              <a href="{{ route('orders.index') }}" class="notification-footer">Lihat Semua Pesanan &rarr;</a>
            </div>
          </div>

          <!-- Profile Dropdown -->
          <div class="dropdown ms-2">
            <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" id="profile-dropdown">
              <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ Auth::user()->name }}" class="navbar-profile-img">
              <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->name }}</span>
              <i class="bi bi-chevron-down navbar-profile-caret"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile shadow-sm" aria-labelledby="profile-dropdown">
              <li class="dropdown-header">
                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                <small class="text-muted">{{ Auth::user()->email }}</small>
              </li>
              <li><a class="dropdown-item" href="{{ route('orders.my_orders') }}"><i class="bi bi-receipt me-2 text-primary"></i> Pesanan Saya</a></li>
              <li><a class="dropdown-item" href="{{ route('landing_pages.index') }}" target="_blank"><i class="bi bi-shop me-2 text-success"></i> Halaman Toko Web</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Main Flash Message Container -->
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mx-4 mt-3 mb-0" role="alert">
          <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mx-4 mt-3 mb-0" role="alert">
          <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <!-- Yield Content -->
      <main class="flex-grow-1 mb-4">
        @yield('content')
      </main>

      <!-- Footer Component -->
      <footer class="footer-custom">
        <div class="footer-left">
          <span class="footer-logo">
            <i class="bi bi-cup-hot-fill text-lime"></i> KopiKita Roastery
          </span>
          <span class="footer-separator">|</span>
          <span class="footer-copy">&copy; {{ date('Y') }} KopiKita Admin • Sistem Manajemen Pemesanan Kopi Premium</span>
        </div>
        <div class="footer-right">
          <ul class="footer-links">
            <li><a href="{{ route('home') }}" class="footer-link">Dashboard</a></li>
            <li><a href="{{ route('orders.index') }}" class="footer-link">Pesanan</a></li>
            <li><a href="{{ route('landing_pages.index') }}" class="footer-link" target="_blank">Toko Web <span class="status-dot"></span></a></li>
          </ul>
        </div>
      </footer>
    </div>
    <!-- ==========================================
           END: Main Content Area
           ========================================== -->

  @else
    {{-- Guest View (Login / Register fallback) --}}
    <div class="container py-5">
      @yield('content')
    </div>
  @endauth

  <!-- Scripts -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>

  @stack('scripts')
</body>

</html>
