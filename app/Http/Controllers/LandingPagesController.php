<?php

namespace App\Http\Controllers;

use App\Models\JenisProducts;
use App\Models\product;
use App\Models\store_setting;
use Illuminate\Http\Request;

class LandingPagesController extends Controller
{
    /**
     * Tampilkan halaman utama katalog KopiKita
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $JenisProducts = JenisProducts::all();
        $products = product::all();
        $storeSetting = store_setting::first();
        return view('landing_pages.index', compact('products', 'JenisProducts', 'storeSetting'));
    }
}
