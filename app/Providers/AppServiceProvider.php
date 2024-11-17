<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pendaftaran layanan lainnya (jika ada)
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Logika bootstrapping lainnya, jika ada
    }
}
