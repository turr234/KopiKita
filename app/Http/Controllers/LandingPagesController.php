<?php

namespace App\Http\Controllers;

use App\Models\JenisProducts;
use App\Models\product;
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
        return view('landing_pages.index', compact('products', 'JenisProducts'));
    }
}
