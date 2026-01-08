<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
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
        // Method 1: Share dengan SEMUA view (paling sederhana)
        $settings = WebsiteSetting::getSettings();
        View::share('setting', $settings);
        
        // Untuk kompatibilitas: juga share sebagai $settings untuk backend
        View::composer('backend.*', function ($view) use ($settings) {
            $view->with('settings', $settings);
        });
        
        // Untuk frontend yang perlu $settings juga (jika ada)
        View::composer('frontend.*', function ($view) use ($settings) {
            $view->with('settings', $settings);
        });
    }
}