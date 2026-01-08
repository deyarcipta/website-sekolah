<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    protected $table = 'website_settings';
    
    protected $fillable = [
        'site_name',
        'site_tagline',
        'site_description',
        'site_logo',
        'site_favicon',
        'site_email',
        'site_phone',
        'site_whatsapp',
        'site_address',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'google_analytics',
        'timezone',
        'date_format',
        'time_format',
        'maintenance_mode',
        'maintenance_message',
        'headmaster_name',
        'headmaster_nip',
        'headmaster_photo',
        'headmaster_message',
        'school_npsn',
        'school_nss',
        'school_akreditation',
        'school_operator_name',
        'school_operator_email'
    ];
    
    protected $casts = [
        'maintenance_mode' => 'boolean'
    ];
    
    /**
     * Get single setting instance (Singleton Pattern)
     */
    public static function getSettings()
    {
        return Cache::remember('website_settings', 3600, function () {
            return self::first() ?? new self();
        });
    }
    
    /**
     * Clear cache when settings are updated
     */
    public static function clearCache()
    {
        Cache::forget('website_settings');
    }
    
    /**
     * Save settings
     */
    public static function saveSettings($data)
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = new self();
        }
        
        $settings->fill($data);
        $settings->save();
        
        self::clearCache();
        
        return $settings;
    }
    
    /**
     * Get social media links
     */
    public function getSocialMediaAttribute()
    {
        return [
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'tiktok' => $this->tiktok
        ];
    }
    
    /**
     * Check if social media exists
     */
    public function hasSocialMedia()
    {
        return !empty(array_filter($this->social_media));
    }
}