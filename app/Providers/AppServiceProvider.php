<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\WebsiteSetting;
use App\Models\MouPartner;

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

        View::composer('frontend.partials.mou', function ($view) {
            $mouPartners = MouPartner::active()
                ->orderBy('sort_order')
                ->get();

            $view->with('mouPartners', $mouPartners);
        });
    }
}
