<?php
// app/Models/WebsiteVisitor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteVisitor extends Model
{
    use HasFactory;

    protected $table = 'website_visitors';
    
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'browser',
        'os',
        'device',
        'country',
        'city',
        'referrer',
        'page',
        'date',
        'is_unique',
        'meta'
    ];

    protected $casts = [
        'is_unique' => 'boolean',
        'meta' => 'array',
        'date' => 'date'
    ];

    // Scope untuk pengunjung hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    // Scope untuk pengunjung bulan ini
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }

    // Scope untuk pengunjung unik
    public function scopeUnique($query)
    {
        return $query->where('is_unique', true);
    }

    // Method untuk mencatat pengunjung
    public static function recordVisit(array $data): self
    {
        $sessionId = $data['session_id'] ?? session()->getId();
        
        // Cek apakah session ini sudah tercatat hari ini
        $existing = self::where('session_id', $sessionId)
                       ->whereDate('date', today())
                       ->first();
        
        if ($existing) {
            return $existing;
        }
        
        // Cek apakah IP sudah tercatat sebagai unique visitor hari ini
        $isUnique = !self::where('ip_address', $data['ip_address'])
                        ->whereDate('date', today())
                        ->where('is_unique', true)
                        ->exists();
        
        return self::create([
            'session_id' => $sessionId,
            'ip_address' => $data['ip_address'] ?? request()->ip(),
            'user_agent' => $data['user_agent'] ?? request()->userAgent(),
            'browser' => $data['browser'] ?? get_browser_name(request()->userAgent()),
            'os' => $data['os'] ?? get_os_name(request()->userAgent()),
            'device' => $data['device'] ?? get_device_type(request()->userAgent()),
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'referrer' => $data['referrer'] ?? request()->header('referer'),
            'page' => $data['page'] ?? request()->path(),
            'date' => today(),
            'is_unique' => $isUnique,
            'meta' => $data['meta'] ?? null
        ]);
    }
}

// Helper functions (bisa diletakkan di helpers.php)
if (!function_exists('get_browser_name')) {
    function get_browser_name($user_agent)
    {
        $browsers = [
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Opera' => 'Opera',
            'MSIE' => 'Internet Explorer',
            'Trident' => 'Internet Explorer',
            'Edge' => 'Edge'
        ];
        
        foreach ($browsers as $key => $browser) {
            if (strpos($user_agent, $key) !== false) {
                return $browser;
            }
        }
        
        return 'Unknown';
    }
}

if (!function_exists('get_os_name')) {
    function get_os_name($user_agent)
    {
        $oses = [
            'Windows' => 'Windows',
            'Mac' => 'Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iPhone' => 'iOS',
            'iPad' => 'iOS'
        ];
        
        foreach ($oses as $key => $os) {
            if (strpos($user_agent, $key) !== false) {
                return $os;
            }
        }
        
        return 'Unknown';
    }
}

if (!function_exists('get_device_type')) {
    function get_device_type($user_agent)
    {
        if (strpos($user_agent, 'Mobile') !== false) {
            return 'Mobile';
        }
        
        if (strpos($user_agent, 'Tablet') !== false) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }
    
}