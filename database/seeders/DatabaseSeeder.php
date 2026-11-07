<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Tentukan modul/menu dan aksi standar
        $modules = [
            'users',
            'roles',
            'categories',
            'products',
            'product_images',
            'reviews',
            'orders',
            'order_items',
            'order_status_histories',
            'carts',
            'cart_items',
            'payments',
            'store_settings'
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        // 2. Generate permissions secara otomatis
        $allPermissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = "{$action} {$module}";
                Permission::firstOrCreate(['name' => $permissionName]);
                $allPermissions[] = $permissionName;
            }
        }

        // 3. Setup Roles & Sync Permissions
        // Admin dapat semua permission
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Staff hanya dapat akses tertentu
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', 'view %')
                ->orWhere('name', 'like', '% products')
                ->orWhere('name', 'like', '% orders');
        })->where('name', 'not like', '% settings')->get();

        $staffRole->syncPermissions($staffPermissions);

        // 4. Buat User Admin Baru dan Assign Role
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'phone' => '1234567890',
                'status' => 'active',
                'password' => bcrypt('AkuAdmin123!'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // 5. Buat User Staff Baru
        $staff = User::updateOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff Toko',
                'phone' => '0987654321',
                'status' => 'active',
                'password' => bcrypt('StaffToko123!'),
            ]
        );

        $staff->syncRoles([$staffRole]);

        // 6. Jalankan Seeder Role & User Admin Toko
        $this->call([
            AdminTokoSeeder::class,
        ]);
    }
}
