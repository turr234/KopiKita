<?php

namespace Database\Seeders;

use App\Models\bank_account;
use App\Models\categories;
use App\Models\JenisProducts;
use App\Models\product;
use App\Models\store_setting;
use Illuminate\Database\Seeder;

class CoffeeShopSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jenis Products / Pilihan Grind Size (Gilingan Kopi)
        $jenisList = [
            ['name' => 'Biji Utuh (Whole Beans)', 'keterangan' => 'Cocok untuk digiling sendiri di rumah'],
            ['name' => 'Giling Halus (Espresso / Tubruk)', 'keterangan' => 'Cocok untuk mesin espresso, moka pot, dan kopi tubruk'],
            ['name' => 'Giling Sedang (V60 / Pour Over)', 'keterangan' => 'Cocok untuk filter, V60, Aeropress, Kalita Wave'],
            ['name' => 'Giling Kasar (French Press / Cold Brew)', 'keterangan' => 'Cocok untuk manual brew French press dan cold brew'],
        ];

        foreach ($jenisList as $j) {
            JenisProducts::firstOrCreate(['name' => $j['name']], $j);
        }

        // 2. Kategori Produk
        $categoriesList = [
            ['name' => 'Single Origin', 'slug' => 'single-origin', 'description' => 'Biji kopi murni dari single estate terbaik di Indonesia.'],
            ['name' => 'House Blend', 'slug' => 'house-blend', 'description' => 'Perpaduan biji kopi pilihan dengan racikan rasa khas KopiKita.'],
            ['name' => 'Cold Brew & RTD', 'slug' => 'cold-brew-rtd', 'description' => 'Minuman kopi siap minum yang diseduh dingin selama 18 jam.'],
        ];

        foreach ($categoriesList as $cat) {
            categories::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Produk Kopi
        $sampleProducts = [
            [
                'name' => 'Aceh Gayo Winey Arabica 250g',
                'slug' => 'aceh-gayo-winey-arabica-250g',
                'sku' => 'KPK-GYO-001',
                'description' => 'Kopi Arabica Single Origin dari dataran tinggi Takengon Aceh dengan proses fermentasi khusus winey. Cita rasa fruity berry, anggur manis, dan aroma floral yang kaya.',
                'origin' => 'Takengon, Aceh Tengah',
                'tasting_notes' => 'Red Wine, Blackcurrant, Brown Sugar, Jasmine',
                'price' => 95000,
                'discount_price' => 85000,
                'stock' => 50,
                'weight' => 250,
                'main_image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Toraja Sapan Washed Specialty 250g',
                'slug' => 'toraja-sapan-washed-specialty-250g',
                'sku' => 'KPK-TRJ-002',
                'description' => 'Ditanam di ketinggian 1.700 mdpl lereng Gunung Sesean, Toraja. Memiliki body tebal, keasaman lembut jeruk sitrun dan aftertaste cokelat karamel yang tahan lama.',
                'origin' => 'Sapan, Tana Toraja',
                'tasting_notes' => 'Dark Chocolate, Orange Citrus, Spices, Honey',
                'price' => 88000,
                'discount_price' => 78000,
                'stock' => 45,
                'weight' => 250,
                'main_image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=600',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bali Kintamani Natural Honey 250g',
                'slug' => 'bali-kintamani-natural-honey-250g',
                'sku' => 'KPK-BLI-003',
                'description' => 'Tumbuh berdampingan dengan kebun jeruk Kintamani, menghasilkan cita rasa citrus mandarin segar berpadu dengan manisnya madu alami.',
                'origin' => 'Kintamani, Bangli, Bali',
                'tasting_notes' => 'Mandarin Orange, Honeycomb, Black Tea, Caramel',
                'price' => 85000,
                'discount_price' => 75000,
                'stock' => 60,
                'weight' => 250,
                'main_image' => 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?w=600',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Espresso Blend KopiKita Signature 500g',
                'slug' => 'espresso-blend-kopikita-signature-500g',
                'sku' => 'KPK-BLN-004',
                'description' => 'Formula espresso blend rahasia kami (70% Arabica Gayo + 30% Robusta Dampit). Sangat cocok untuk minuman milk-based seperti Latte, Cappuccino, atau Americano.',
                'origin' => 'Sumatra & Java Blend',
                'tasting_notes' => 'Nutty Roasted Almond, Dark Cocoa, Sweet Molasses',
                'price' => 120000,
                'discount_price' => 110000,
                'stock' => 80,
                'weight' => 500,
                'main_image' => 'https://images.unsplash.com/photo-1610632380989-680fe40816c6?w=600',
                'is_featured' => true,
                'is_active' => true,
            ]
        ];

        foreach ($sampleProducts as $prod) {
            product::firstOrCreate(['sku' => $prod['sku']], $prod);
        }

        // 4. Rekening Bank Toko untuk Pembayaran
        $bankAccounts = [
            [
                'bank_name' => 'BCA (Bank Central Asia)',
                'account_number' => '8045 2819 001',
                'account_holder' => 'PT KOPIKITA NUSANTARA',
                'is_active' => true,
                'intructions' => 'Transfer via ATM, Mobile Banking (m-BCA), atau Internet Banking KlikBCA.'
            ],
            [
                'bank_name' => 'Bank Mandiri',
                'account_number' => '130 00 2938 4811',
                'account_holder' => 'PT KOPIKITA NUSANTARA',
                'is_active' => true,
                'intructions' => 'Transfer via Livin by Mandiri atau ATM Mandiri.'
            ],
            [
                'bank_name' => 'BRI (Bank Rakyat Indonesia)',
                'account_number' => '0206 01 002938 501',
                'account_holder' => 'PT KOPIKITA NUSANTARA',
                'is_active' => true,
                'intructions' => 'Transfer via BRImo atau ATM BRI.'
            ],
        ];

        foreach ($bankAccounts as $bank) {
            bank_account::firstOrCreate(
                ['bank_name' => $bank['bank_name'], 'account_number' => $bank['account_number']],
                $bank
            );
        }

        // 5. Store Settings
        if (store_setting::count() === 0) {
            store_setting::create([
                'store_name' => 'KOPIKITA Roastery & Store',
                'tagline' => 'Cita Rasa Kopi Nusantara Langsung ke Meja Anda',
                'logo' => 'kopikita-logo.png',
                'favicon' => 'favicon.ico',
                'email' => 'halo@kopikita.id',
                'phone' => '081234567890',
                'whatsapp' => '6281234567890',
                'address' => 'Jl. Ir. H. Juanda No. 128, Dago, Bandung, Jawa Barat',
                'instagram_url' => 'https://instagram.com/kopikita',
                'tiktok_url' => 'https://tiktok.com/@kopikita',
                'facebook_url' => 'https://facebook.com/kopikita',
                'about' => 'KOPIKITA adalah roastery kopi artisan nusantara yang menyajikan biji kopi pilihan langsung dari petani lokal.',
                'minimum_stock_warning' => '5'
            ]);
        }
    }
}
