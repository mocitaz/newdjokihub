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
        // Hostinger / cPanel Fix: Bind public path to public_html if it exists as a sibling
        // This ensures asset() and public_path() point to the correct web root
        $productionPublicPath = base_path('../public_html');
        
        if (file_exists($productionPublicPath) && $this->app->environment('production')) {
            $this->app->usePublicPath($productionPublicPath);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
