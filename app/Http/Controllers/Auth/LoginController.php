<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Tindakan setelah pengguna berhasil login
     */
    public function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Bersihkan session url.intended jika pernah tersimpan rute internal/AJAX
        $intended = session()->get('url.intended');
        if ($intended && (str_contains($intended, 'cart-data') || str_contains($intended, 'cart-add'))) {
            session()->forget('url.intended');
            $intended = null;
        }

        // Jika admin / staf / admin toko (termasuk Toko A, B, C), arahkan ke Dashboard Admin (/home)
        if ($user && $user->hasAnyRole(['admin', 'staff', 'super admin', 'admin toko', 'Admin Toko', 'admin toko a', 'admin toko b', 'admin toko c', 'karyawan'])) {
            return redirect()->route('home');
        }

        // Jika pembeli memiliki intended url yang valid (misal mau checkout), izinkan
        if ($intended && !str_contains($intended, 'cart-data')) {
            return redirect()->intended('/');
        }

        return redirect('/');
    }

    /**
     * Tentukan pengalihan setelah login berdasarkan peran pengguna
     */
    public function redirectTo()
    {
        $user = auth()->user();
        if ($user && $user->hasAnyRole(['admin', 'staff', 'super admin', 'admin toko', 'Admin Toko', 'admin toko a', 'admin toko b', 'admin toko c', 'karyawan'])) {
            return '/home';
        }
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
