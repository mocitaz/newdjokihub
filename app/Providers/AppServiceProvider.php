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
        // Hostinger / cPanel Fix: Bind public path to public_html
        $pathsToTry = [
            base_path('../public_html'), // Sibling directory
            base_path('public_html'),    // Child directory
        ];

        foreach ($pathsToTry as $path) {
            if (file_exists($path) && $this->app->environment('production')) {
                $this->app->usePublicPath($path);
                return;
            }
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
