<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Throwable;

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

            try {
                if (Schema::hasTable('site_settings')) {
                    $storefrontLogoUrl = \App\Models\SiteSetting::publicUrl('storefront_logo');
                }
            } catch (Throwable) {
                // Silently fail if table not ready
            }

            // Share search products (Cached for 1 hour)
            $searchProducts = cache()->remember('store_search_products', 3600, function() {
                try {
                    if (!Schema::hasTable('products')) return collect();
                    
                    return \App\Models\Product::select(['id', 'name', 'retail_price', 'image'])
                        ->with('variants:id,product_id,retail_price')
                        ->get()
                        ->map(fn($p) => [
                            'name' => $p->name,
                            'price' => number_format($p->displayRetailPrice(), 2),
                            'url' => route('products.show', $p->id),
                            'image' => '/media/' . ltrim($p->displayImage(), '/'),
                            'search' => strtolower($p->name),
                        ]);
                } catch (Throwable) {
                    return collect();
                }
            });

            $view->with([
                'storefrontLogoUrl' => $storefrontLogoUrl,
                'searchProducts'    => $searchProducts
            ]);
        });
    }
}
