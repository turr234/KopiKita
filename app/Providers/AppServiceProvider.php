<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super Admin bypass: user dengan role 'admin' atau email spesifik superadmin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin') || $user->email === 'admin@gmail.com') {
                return true;
            }
            return null;
        });
    }
}
