<?php

namespace App\Helpers;

use App\Models\WebsiteSetting;

class SettingHelper
{
    protected static $settings;
    
    /**
     * Get all settings or specific key
     */
    public static function get($key = null, $default = null)
    {
        // Lazy load settings
        if (!self::$settings) {
            self::$settings = WebsiteSetting::getSettings();
        }
        
        // Jika tidak ada key, return semua settings
        if (is_null($key)) {
            return self::$settings;
        }
        
        // Jika ada key, return value spesifik
        return self::$settings->$key ?? $default;
    }
    
    /**
     * Get all settings as object
     */
    public static function all()
    {
        return self::get();
    }
    
    // public static function siteName()
    // {
    //     return self::get('site_name', 'SMK Wisata Indonesia');
    // }
    
    // public static function siteLogo()
    // {
    //     $logo = self::get('site_logo');
    //     return $logo ? asset($logo) : asset('assets/img/logo-wistek.png');
    // }
    
    public static function contactInfo()
    {
        return [
            'phone' => self::get('site_phone'),
            'email' => self::get('site_email'),
            'address' => self::get('site_address'),
            'whatsapp' => self::get('site_whatsapp'),
        ];
    }
    
    /**
     * Clear cached settings (call after update)
     */
    public static function clearCache()
    {
        self::$settings = null;
        WebsiteSetting::clearCache();
    }
}