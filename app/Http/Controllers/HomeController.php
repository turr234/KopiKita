<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\product;
use App\Models\User;
use App\Models\categories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Proteksi: Jika akun pembeli biasa mencoba mengakses dashboard backend, arahkan ke beranda toko
        if (auth()->user()->hasRole('pembeli') && !auth()->user()->hasAnyRole(['admin', 'admin toko', 'Admin Toko', 'admin toko a', 'admin toko b', 'admin toko c', 'staff', 'super admin'])) {
            return redirect()->route('landing_pages.index');
        }

        $totalOrders = order::count();
        $totalRevenue = order::where('payment_status', 'paid')->sum('total');
        if ($totalRevenue == 0) {
            $totalRevenue = order::where('status', '!=', 'cancelled')->sum('total');
        }

        $pendingOrders = order::where('status', 'pending')->count();
        $processingOrders = order::where('status', 'processing')->count();
        $shippedOrders = order::where('status', 'shipped')->count();
        $completedOrders = order::where('status', 'completed')->count();
        $cancelledOrders = order::where('status', 'cancelled')->count();

        $totalProducts = product::count();
        $totalStock = product::sum('stock') ?? 0;
        $totalUsers = User::count();
        $recentOrders = order::with(['user', 'items.product'])->latest()->take(6)->get();

        // 1. Data Grafik Tren Penjualan Bulanan (6 Bulan Terakhir) dari Database
        $chartMonths = [];
        $chartRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartMonths[] = $date->translatedFormat('M Y');

            $rev = order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', '!=', 'cancelled')
                ->sum('total');

            $chartRevenue[] = (int) $rev;
        }

        // 2. Data Grafik Komposisi Status Pesanan (Donut Chart) dari Database
        $chartOrderStatusSeries = [(int)$completedOrders, (int)$processingOrders, (int)$pendingOrders];

        return view('home', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'completedOrders',
            'cancelledOrders',
            'totalProducts',
            'totalStock',
            'totalUsers',
            'recentOrders',
            'chartMonths',
            'chartRevenue',
            'chartOrderStatusSeries'
        ));
    }
}
