<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view): void {
            $storefrontLogoUrl = null;

            if (Schema::hasTable('site_settings')) {
                $storefrontLogoUrl = SiteSetting::publicUrl('storefront_logo');
            }

            $view->with('storefrontLogoUrl', $storefrontLogoUrl);
        });
    }
}
