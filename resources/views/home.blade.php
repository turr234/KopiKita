@extends('layouts.app')

@section('title', 'Dashboard - KopiKita Admin')

@section('content')
<script>
  // Data Real-Time dari Database MySQL untuk Grafik Dashboard
  window.kopiKitaDashboardData = {
    months: {!! json_encode($chartMonths) !!},
    revenue: {!! json_encode($chartRevenue) !!},
    orderStatusSeries: {!! json_encode($chartOrderStatusSeries) !!}
  };
</script>
<div class="container-fluid px-4 py-2">
  <!-- START: Dashboard Header Banner -->
  <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title fw-bold text-dark mb-1">
        <i class="bi bi-grid-fill me-2 text-primary"></i> Dashboard KopiKita
      </h1>
      <p class="page-subtitle text-muted mb-0">
        Ringkasan analitik penjualan biji kopi, verifikasi pembayaran manual, dan operasional pesanan.
      </p>
    </div>
    <button class="btn-date-picker" type="button" id="date-picker-trigger">
      <i class="bi bi-calendar4-event me-2"></i>
      <span id="selected-date-range">{{ date('F 01, Y') }} - {{ date('F d, Y') }}</span>
      <i class="bi bi-chevron-down ms-2"></i>
    </button>
  </div>
  <!-- END: Dashboard Header Banner -->

  @php
    $userRoles = Auth::user()->roles->pluck('name')->toArray();
    $storeInfo = null;
    if (in_array('admin toko a', $userRoles)) {
        $storeInfo = [
            'name' => 'Group Toko A (Cabang Bandung)',
            'address' => 'Jl. Ir. H. Juanda No. 128, Dago, Bandung',
            'badge' => 'Toko A',
            'bg' => '#e8f5e9',
            'color' => '#1b5e20',
            'badge_class' => 'bg-success',
            'icon' => 'bi-shop-window'
        ];
    } elseif (in_array('admin toko b', $userRoles)) {
        $storeInfo = [
            'name' => 'Group Toko B (Cabang Jakarta)',
            'address' => 'Jl. Senopati No. 45, Kebayoran Baru, Jakarta Selatan',
            'badge' => 'Toko B',
            'bg' => '#e3f2fd',
            'color' => '#0d47a1',
            'badge_class' => 'bg-primary',
            'icon' => 'bi-shop-window'
        ];
    } elseif (in_array('admin toko c', $userRoles)) {
        $storeInfo = [
            'name' => 'Group Toko C (Cabang Yogyakarta)',
            'address' => 'Jl. Malioboro No. 88, Sosromenduran, Kota Yogyakarta',
            'badge' => 'Toko C',
            'bg' => '#fff8e1',
            'color' => '#e65100',
            'badge_class' => 'bg-warning text-dark',
            'icon' => 'bi-shop-window'
        ];
    } elseif (in_array('admin', $userRoles)) {
        $storeInfo = [
            'name' => 'Super Admin - Seluruh Toko (Group Toko A, B, C)',
            'address' => 'Akses penuh ke semua cabang toko dan operasional sistem',
            'badge' => 'Semua Toko (A, B, C)',
            'bg' => '#f8f9fa',
            'color' => '#212529',
            'badge_class' => 'bg-dark',
            'icon' => 'bi-shield-check'
        ];
    }
  @endphp

  @if($storeInfo)
  <div class="alert border-0 shadow-sm d-flex flex-wrap align-items-center justify-content-between mb-4 py-2 px-3 rounded-3" style="background-color: {{ $storeInfo['bg'] }}; color: {{ $storeInfo['color'] }};">
    <div class="d-flex align-items-center gap-2">
      <i class="bi {{ $storeInfo['icon'] }} fs-5"></i>
      <div>
        <strong>Cabang Aktif: {{ $storeInfo['name'] }}</strong>
        <span class="ms-2 small text-muted d-none d-md-inline">| {{ $storeInfo['address'] }} &bull; Pengelola: {{ Auth::user()->name }}</span>
      </div>
    </div>
    <span class="badge {{ $storeInfo['badge_class'] }} px-2 py-1">{{ $storeInfo['badge'] }}</span>
  </div>
  @endif

  <!-- START: Main Layout Grid -->
  <div class="row g-4">

    <!-- TOP AREA: Quick Info Stat Cards Row (Full Width) -->
    <div class="col-12">
      <div class="row g-4">
        <!-- Stat Card 1: Alert Green Banner (KopiKita Action Alert) -->
        <div class="col-md-4">
          <div class="card alert-green-card h-100">
            <div class="position-relative z-index-2">
              <span class="alert-green-badge">Status Pesanan</span>
              <div class="alert-green-date">{{ date('d M Y') }}</div>
              <div class="alert-green-text">
                @if($pendingOrders > 0)
                  Ada <strong>{{ $pendingOrders }} pesanan baru</strong> menunggu konfirmasi pembayaran manual!
                @else
                  Semua pesanan saat ini telah terkonfirmasi dan diproses.
                @endif
              </div>
            </div>
            <a href="{{ route('orders.index') }}" class="alert-green-link z-index-2" id="alert-link-statistics">
              <span>Kelola Pesanan Masuk</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <!-- Inline SVG geometric decoration -->
            <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g transform="translate(50,50)">
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
              </g>
            </svg>
          </div>
        </div>

        <!-- Stat Card 2: Net Income / Total Pendapatan -->
        <div class="col-md-4">
          <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="stat-label">Total Omset Penjualan</span>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More Options">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-cart me-2"></i> Lihat Pesanan</a></li>
                    <li><a class="dropdown-item" href="{{ route('payments.index') }}"><i class="bi bi-credit-card me-2"></i> Data Pembayaran</a></li>
                  </ul>
                </div>
              </div>
              <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
              <div class="trend-badge trend-up">
                <i class="bi bi-arrow-up-right"></i>
                <span>{{ $completedOrders }} Pesanan Berhasil</span>
              </div>
            </div>
            <div class="sparkline-container sparkline-card-footer">
              <div id="income-sparkline"></div>
            </div>
          </div>
        </div>

        <!-- Stat Card 3: Total Orders & Customer Count -->
        <div class="col-md-4">
          <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="stat-label">Total Pesanan & Pelanggan</span>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More Options">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i> Kelola Pelanggan</a></li>
                  </ul>
                </div>
              </div>
              <div class="stat-value">{{ $totalOrders }} <span class="fs-6 fw-normal text-muted">Pesanan</span></div>
              <div class="trend-badge {{ $pendingOrders > 0 ? 'trend-down' : 'trend-up' }}">
                <i class="bi bi-person-check-fill"></i>
                <span>{{ $totalUsers }} Total Pengguna Terdaftar</span>
              </div>
            </div>
            <div class="sparkline-container sparkline-card-footer">
              <div id="return-sparkline"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: TOP AREA -->

    <!-- LEFT AREA: Primary Dashboard Stats & Tables -->
    <div class="col-xl-9 col-lg-8">
      <div class="row g-4">
        <!-- Column: Revenue Chart (ApexCharts) -->
        <div class="col-12">
          <div class="card mb-0">
            <div class="card-header mb-2 d-flex justify-content-between align-items-center">
              <h2 class="card-title mb-0">Tren Penjualan Kopi (Revenue)</h2>
              <!-- Custom Static Legends -->
              <div class="d-flex gap-3 align-items-center">
                <div class="chart-legend-item">
                  <span class="legend-dot bg-forest-medium"></span>
                  <span class="chart-legend-label">Total Omset Penjualan (Rp)</span>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-2 mb-3">
              <span class="stat-value-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
              <span class="trend-badge trend-up fs-xs">+{{ $completedOrders }} transaksi selesai</span>
            </div>
            <div id="revenue-chart"></div>
          </div>
        </div>

        <!-- Column: Transaction / Recent Orders List -->
        <div class="col-md-7 d-flex flex-column">
          <div class="card h-100 flex-grow-1">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <h2 class="card-title mb-0">Pesanan Kopi Terbaru</h2>
                <small class="text-muted">Aktivitas pesanan masuk dari pembeli</small>
              </div>
              <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary px-2 py-1">
                Lihat Semua &rarr;
              </a>
            </div>

            <!-- Transaction Items List -->
            <div class="transaction-list">
              @forelse($recentOrders as $rOrder)
                @php
                  $st = strtolower($rOrder->status);
                  $badgeCls = match($st) {
                    'completed', 'selesai' => 'bg-success text-white',
                    'shipped', 'dikirim' => 'bg-info text-dark',
                    'processing', 'diproses' => 'bg-primary text-white',
                    'cancelled', 'batal' => 'bg-danger text-white',
                    default => 'bg-warning text-dark',
                  };
                  $badgeText = match($st) {
                    'completed' => 'Selesai',
                    'shipped' => 'Dikirim',
                    'processing' => 'Diproses',
                    'cancelled' => 'Batal',
                    default => 'Pending',
                  };
                @endphp
                <div class="transaction-item d-flex align-items-center justify-content-between py-2 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <div class="transaction-icon bg-forest-light text-lime d-flex align-items-center justify-content-center rounded-3 p-2" style="width: 42px; height: 42px;">
                      <i class="bi bi-cup-hot fs-5"></i>
                    </div>
                    <div class="transaction-info">
                      <a href="{{ route('orders.show', $rOrder->id) }}" class="transaction-name fw-bold text-dark text-decoration-none d-block">
                        #{{ $rOrder->order_number }}
                      </a>
                      <div class="transaction-date text-muted small">
                        {{ $rOrder->recipient_name }} • {{ $rOrder->created_at ? $rOrder->created_at->format('d M, H:i') : '-' }}
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <div class="transaction-amount fw-bold text-success">
                      Rp {{ number_format($rOrder->total, 0, ',', '.') }}
                    </div>
                    <span class="badge {{ $badgeCls }} mt-1" style="font-size: 0.72rem;">
                      {{ $badgeText }}
                    </span>
                  </div>
                </div>
              @empty
                <div class="p-4 text-center text-muted">
                  <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                  Belum ada pesanan masuk.
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Column: Product & Stock Overview Progress -->
        <div class="col-md-5 d-flex flex-column">
          <div class="card h-100 flex-grow-1">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h2 class="card-title mb-0">Operasional & Stok</h2>
              <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary px-2 py-1">
                Katalog &rarr;
              </a>
            </div>

            <!-- Progress 1: Total Produk Kopi -->
            <div class="progress-container mb-3">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Produk Kopi Aktif</span>
                <span class="progress-value fw-bold text-dark">{{ $totalProducts }} Jenis</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-lime-accent" style="width: {{ min(100, $totalProducts * 20) }}%;"></div>
              </div>
            </div>

            <!-- Progress 2: Stok Biji Kopi Tersedia -->
            <div class="progress-container mb-3">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Total Stok Tersedia</span>
                <span class="progress-value fw-bold text-dark">{{ $totalStock }} Pcs</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-lime-accent" style="width: 80%;"></div>
              </div>
            </div>

            <!-- Progress 3: Pesanan Sedang Diproses -->
            <div class="progress-container mb-3">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Sedang Diproses (Roasting & Pack)</span>
                <span class="progress-value fw-bold text-primary">{{ $processingOrders }} Order</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-primary" style="width: {{ $totalOrders > 0 ? ($processingOrders / $totalOrders) * 100 : 0 }}%;"></div>
              </div>
            </div>

            <!-- Progress 4: Pesanan Dalam Pengiriman -->
            <div class="progress-container mb-3">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Dikirim Kurir (Dalam Jalan)</span>
                <span class="progress-value fw-bold text-info">{{ $shippedOrders }} Order</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-info" style="width: {{ $totalOrders > 0 ? ($shippedOrders / $totalOrders) * 100 : 0 }}%;"></div>
              </div>
            </div>

            <!-- Progress 5: Pesanan Selesai -->
            <div class="progress-container mb-3">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Pesanan Selesai</span>
                <span class="progress-value fw-bold text-success">{{ $completedOrders }} Order</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-success" style="width: {{ $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0 }}%;"></div>
              </div>
            </div>

            <!-- Progress 6: Pending Konfirmasi -->
            <div class="progress-container">
              <div class="progress-label-row d-flex justify-content-between mb-1">
                <span class="progress-label small fw-semibold">Menunggu Konfirmasi Manual</span>
                <span class="progress-value fw-bold text-danger">{{ $pendingOrders }} Order</span>
              </div>
              <div class="progress" role="progressbar" style="height: 7px;">
                <div class="progress-bar bg-warning" style="width: {{ $totalOrders > 0 ? ($pendingOrders / $totalOrders) * 100 : 0 }}%;"></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- END: LEFT AREA -->

    <!-- RIGHT AREA: Performance Details Sidebar Panel -->
    <div class="col-xl-3 col-lg-4">
      <div class="right-panel-wrapper d-flex flex-column gap-4 h-100">

        <!-- Performance Donut Chart card -->
        <div class="card flex-grow-1 d-flex flex-column justify-content-between mb-0">
          <div class="card-header mb-1">
            <h2 class="card-title">Performa Pesanan</h2>
            <small class="text-muted d-block">Komposisi status pesanan masuk</small>
          </div>

          <div id="views-chart"></div>

          <!-- Custom Legends below the chart -->
          <div class="chart-legends-container">
            <div class="chart-legend-item">
              <span class="legend-dot bg-lime-accent"></span>
              <span class="text-muted-green">Selesai ({{ $completedOrders }})</span>
            </div>
            <div class="chart-legend-item">
              <span class="legend-dot bg-forest-medium"></span>
              <span class="text-muted-green">Diproses ({{ $processingOrders }})</span>
            </div>
            <div class="chart-legend-item">
              <span class="legend-dot bg-brand-orange"></span>
              <span class="text-muted-green">Pending ({{ $pendingOrders }})</span>
            </div>
          </div>
        </div>

        <!-- Level Up Promotion CTA banner -->
        <div class="promo-banner-card">
          <!-- Inline SVG geometric decoration -->
          <svg class="promo-banner-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(50,50)">
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
            </g>
          </svg>

          <h3 class="promo-title">Tingkatkan Bisnis Roastery KopiKita!</h3>
          <p class="promo-desc">Kelola varian biji kopi (Fine, Medium, Coarse, Whole Bean) dan pantau kepuasan pelanggan secara cepat.</p>
          <a href="{{ route('products.index') }}" class="btn-promo text-decoration-none d-inline-block text-center" id="btn-promo-action">
            Kelola Produk Sekarang &rarr;
          </a>
        </div>

      </div>
    </div>
    <!-- END: RIGHT AREA -->

  </div>
  <!-- END: Main Layout Grid -->
</div>
@endsection
