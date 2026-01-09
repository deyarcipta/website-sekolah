<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\WebsiteSetting;

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
        // ✅ Pastikan variabel selalu ada
        $settings = null;

        if (Schema::hasTable('website_settings')) {
            $settings = WebsiteSetting::first();
        }

        // ✅ Share ke SEMUA view
        view()->share('settings', $settings);

        // ❗ OPTIONAL (sebenarnya sudah cukup dengan view()->share)
        View::composer('backend.*', function ($view) use ($settings) {
            $view->with('settings', $settings);
        });

        View::composer('frontend.*', function ($view) use ($settings) {
            $view->with('settings', $settings);
        });
    }
}
