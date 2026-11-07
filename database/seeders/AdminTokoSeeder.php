<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\store_setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles & permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Daftar modul dan aksi sistem KopiKita
        $modules = [
            'users',
            'roles',
            'categories',
            'products',
            'product_images',
            'jenis_products',
            'reviews',
            'orders',
            'order_items',
            'order_status_histories',
            'carts',
            'cart_items',
            'payments',
            'store_settings',
            'bank_accounts',
            'addresses',
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'show'];

        // Generate permission standar berbasis module & action
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $variants = [
                    "{$action} {$module}",
                    "{$action} " . str_replace('_', ' ', $module),
                ];

                foreach (array_unique($variants) as $permName) {
                    Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
                }
            }
        }

        // Permission khusus untuk singular 'product' dan rute role
        $productSingularPermissions = [
            'view product',
            'create product',
            'edit product',
            'delete product',
            'show product',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',
        ];

        foreach ($productSingularPermissions as $permName) {
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        }

        // 3. Tentukan hak akses (Permissions) untuk Admin Toko
        $adminTokoPermissions = [
            // Katalog & Produk Kopi
            'view products', 'view product', 'create products', 'create product', 'edit products', 'edit product', 'delete products', 'delete product', 'show products', 'show product',
            'view categories', 'create categories', 'edit categories', 'delete categories', 'show categories',
            'view jenis_products', 'view jenis products', 'create jenis_products', 'create jenis products', 'edit jenis_products', 'edit jenis products', 'delete jenis_products', 'delete jenis products', 'show jenis_products', 'show jenis products',
            'view product_images', 'view product images', 'create product_images', 'create product images', 'edit product_images', 'edit product images', 'delete product_images', 'delete product images', 'show product_images', 'show product images',

            // Transaksi, Pesanan & Pembayaran
            'view orders', 'create orders', 'edit orders', 'show orders',
            'view order_items', 'view order items', 'create order_items', 'create order items', 'edit order_items', 'edit order items', 'show order_items', 'show order items',
            'view order_status_histories', 'view order status histories', 'create order_status_histories', 'create order status histories', 'edit order_status_histories', 'edit order status histories', 'show order_status_histories', 'show order status histories',
            'view payments', 'create payments', 'edit payments', 'show payments',
            'view carts', 'show carts', 'view cart_items', 'view cart items', 'show cart_items', 'show cart items',

            // Ulasan / Review Produk
            'view reviews', 'create reviews', 'edit reviews', 'delete reviews', 'show reviews',

            // Pengaturan Toko & Rekening Pembayaran
            'view store_settings', 'view store settings', 'create store_settings', 'create store settings', 'edit store_settings', 'edit store settings', 'show store_settings', 'show store settings',
            'view bank_accounts', 'view bank accounts', 'create bank_accounts', 'create bank accounts', 'edit bank_accounts', 'edit bank accounts', 'delete bank_accounts', 'delete bank accounts', 'show bank_accounts', 'show bank accounts',
            'view addresses', 'create addresses', 'edit addresses', 'show addresses',

            // Data Pengguna (Kelola akun pembeli & staf, tapi hapus user dibatasi untuk Super Admin)
            'view users', 'show users', 'create users', 'edit users',
        ];

        // 4. Inisialisasi Role:
        // Role Super Admin (Full Access ke semua permission)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // Role Admin Toko Umum
        $adminTokoRole = Role::firstOrCreate(['name' => 'admin toko', 'guard_name' => 'web']);
        $adminTokoRole->syncPermissions($adminTokoPermissions);

        // Role Khusus 3 Group Toko (Toko A, Toko B, Toko C)
        $roleTokoA = Role::firstOrCreate(['name' => 'admin toko a', 'guard_name' => 'web']);
        $roleTokoA->syncPermissions($adminTokoPermissions);

        $roleTokoB = Role::firstOrCreate(['name' => 'admin toko b', 'guard_name' => 'web']);
        $roleTokoB->syncPermissions($adminTokoPermissions);

        $roleTokoC = Role::firstOrCreate(['name' => 'admin toko c', 'guard_name' => 'web']);
        $roleTokoC->syncPermissions($adminTokoPermissions);

        // Role Staff (Akses operasional dasar)
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staffPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', 'view %')
                ->orWhere('name', 'like', '% products')
                ->orWhere('name', 'like', '% orders')
                ->orWhere('name', 'like', '% payments');
        })->where('name', 'not like', '%settings%')
          ->where('name', 'not like', '%roles%')
          ->where('name', 'not like', '%users%')
          ->get();
        $staffRole->syncPermissions($staffPermissions);

        // Role Pembeli
        Role::firstOrCreate(['name' => 'pembeli', 'guard_name' => 'web']);

        // 5. Inisialisasi Data 3 Toko (Toko A, Toko B, Toko C) di store_settings
        $storeA = store_setting::updateOrCreate(
            ['id' => 1],
            [
                'store_name' => 'KopiKita - Toko A (Group Bandung)',
                'tagline' => 'Roastery & Store Kopi Spesialti Bandung',
                'email' => 'toko.a@kopikita.id',
                'phone' => '081122334401',
                'whatsapp' => '6281122334401',
                'address' => 'Jl. Ir. H. Juanda No. 128, Dago, Bandung, Jawa Barat',
                'instagram_url' => 'https://instagram.com/kopikita_tokoa',
                'tiktok_url' => 'https://tiktok.com/@kopikita_tokoa',
                'facebook_url' => 'https://facebook.com/kopikita_tokoa',
                'about' => 'Group Toko A yang melayani roasting, stok inventaris, dan pengiriman kopi area Bandung & Jawa Barat.',
                'minimum_stock_warning' => 5,
            ]
        );

        $storeB = store_setting::updateOrCreate(
            ['id' => 2],
            [
                'store_name' => 'KopiKita - Toko B (Group Jakarta)',
                'tagline' => 'Specialty Coffee Bar & Retail Jakarta',
                'email' => 'toko.b@kopikita.id',
                'phone' => '081122334402',
                'whatsapp' => '6281122334402',
                'address' => 'Jl. Senopati No. 45, Kebayoran Baru, Jakarta Selatan',
                'instagram_url' => 'https://instagram.com/kopikita_tokob',
                'tiktok_url' => 'https://tiktok.com/@kopikita_tokob',
                'facebook_url' => 'https://facebook.com/kopikita_tokob',
                'about' => 'Group Toko B yang melayani pemesanan espresso bar dan distribusi instan area Jabodetabek.',
                'minimum_stock_warning' => 5,
            ]
        );

        $storeC = store_setting::updateOrCreate(
            ['id' => 3],
            [
                'store_name' => 'KopiKita - Toko C (Group Yogyakarta)',
                'tagline' => 'Heritage Coffee Shop & Slow Bar Jogja',
                'email' => 'toko.c@kopikita.id',
                'phone' => '081122334403',
                'whatsapp' => '6281122334403',
                'address' => 'Jl. Malioboro No. 88, Sosromenduran, Gedong Tengen, Kota Yogyakarta',
                'instagram_url' => 'https://instagram.com/kopikita_tokoc',
                'tiktok_url' => 'https://tiktok.com/@kopikita_tokoc',
                'facebook_url' => 'https://facebook.com/kopikita_tokoc',
                'about' => 'Group Toko C dengan konsep heritage nusantara yang melayani penikmat kopi di Yogyakarta & sekitarnya.',
                'minimum_stock_warning' => 5,
            ]
        );

        // 6. Buat Akun 3 Admin Toko (Admin 1 -> Toko A, Admin 2 -> Toko B, Admin 3 -> Toko C)
        // Admin 1 -> Mengelola Toko A
        $admin1 = User::updateOrCreate(
            ['email' => 'admin1.tokoa@kopikita.com'],
            [
                'name' => 'Admin 1 (Group Toko A)',
                'phone' => '081122334401',
                'status' => 'active',
                'password' => Hash::make('AdminTokoA123!'),
            ]
        );
        $admin1->syncRoles([$roleTokoA, $adminTokoRole]);

        // Admin 2 -> Mengelola Toko B
        $admin2 = User::updateOrCreate(
            ['email' => 'admin2.tokob@kopikita.com'],
            [
                'name' => 'Admin 2 (Group Toko B)',
                'phone' => '081122334402',
                'status' => 'active',
                'password' => Hash::make('AdminTokoB123!'),
            ]
        );
        $admin2->syncRoles([$roleTokoB, $adminTokoRole]);

        // Admin 3 -> Mengelola Toko C
        $admin3 = User::updateOrCreate(
            ['email' => 'admin3.tokoc@kopikita.com'],
            [
                'name' => 'Admin 3 (Group Toko C)',
                'phone' => '081122334403',
                'status' => 'active',
                'password' => Hash::make('AdminTokoC123!'),
            ]
        );
        $admin3->syncRoles([$roleTokoC, $adminTokoRole]);

        // Admin Toko Umum
        $adminTokoUser = User::updateOrCreate(
            ['email' => 'admintoko@kopikita.com'],
            [
                'name' => 'Admin Toko KopiKita (General)',
                'phone' => '081234567890',
                'status' => 'active',
                'password' => Hash::make('AdminToko123!'),
            ]
        );
        $adminTokoUser->syncRoles([$adminTokoRole]);
    }
}
