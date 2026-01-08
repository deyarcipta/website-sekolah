<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\WebsiteSetting;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share settings ke SEMUA view (frontend & backend)
        View::composer('*', function ($view) {
            try {
                // Coba load via Helper class
                if (class_exists(\App\Helpers\SettingHelper::class)) {
                    $settings = \App\Helpers\SettingHelper::get();
                } else {
                    // Fallback langsung ke model
                    $settings = WebsiteSetting::getSettings();
                }
                
                $view->with('setting', $settings);
                
                // Untuk kompatibilitas, juga set sebagai $settings di backend
                if (str_starts_with($view->name(), 'backend.')) {
                    $view->with('settings', $settings);
                }
            } catch (\Exception $e) {
                // Log error dan set default
                \Log::error('ViewComposer Error: ' . $e->getMessage());
                $view->with('setting', new WebsiteSetting());
                $view->with('settings', new WebsiteSetting());
            }
        });
    }
    
    public function register()
    {
        //
    }
}