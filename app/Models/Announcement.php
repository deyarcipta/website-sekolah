<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'status',
        'show_on_frontend',
        'show_as_modal',
        'modal_show_once',
        'modal_width',
        'sort_order',
        'start_date',
        'end_date',
        'modal_settings',
    ];

    protected $casts = [
        'show_on_frontend' => 'boolean',
        'show_as_modal' => 'boolean',
        'modal_show_once' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'modal_settings' => 'array',
    ];

    protected $appends = [
        'type_label',
        'status_label',
        'type_color',
        'modal_settings_array',
    ];

    // Scope untuk pengumuman aktif di frontend - PERBAIKAN
    public function scopeActiveForFrontend($query)
    {
        return $query->where('status', 'active') // Konsisten dengan status_label
                    ->where('show_on_frontend', true)
                    ->where('show_as_modal', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('sort_order')
                    ->orderBy('created_at', 'desc');
    }

    // Accessor untuk label type
    public function getTypeLabelAttribute()
    {
        $labels = [
            'info' => 'Info',
            'warning' => 'Peringatan',
            'danger' => 'Bahaya',
            'success' => 'Sukses',
            'primary' => 'Utama',
        ];

        return $labels[$this->type] ?? 'Info';
    }

    // Accessor untuk label status - PERBAIKAN (status 'active' bukan 'published')
    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'active' => 'Aktif', // Status aktif adalah 'active'
            'inactive' => 'Non-Aktif',
        ];

        return $labels[$this->status] ?? 'Draft';
    }

    // Accessor untuk warna type
    public function getTypeColorAttribute()
    {
        $colors = [
            'info' => 'info',
            'warning' => 'warning',
            'danger' => 'danger',
            'success' => 'success',
            'primary' => 'primary',
        ];

        return $colors[$this->type] ?? 'primary';
    }

    // Accessor untuk modal settings
    public function getModalSettingsArrayAttribute()
    {
        $defaultSettings = [
            'position' => 'center',
            'animation' => 'fade',
            'backdrop' => true,
            'keyboard' => true,
            'close_button' => true,
            'show_once_per_session' => false,
        ];

        if (is_array($this->modal_settings) && !empty($this->modal_settings)) {
            return array_merge($defaultSettings, $this->modal_settings);
        }

        if (is_string($this->modal_settings) && !empty($this->modal_settings)) {
            $settings = json_decode($this->modal_settings, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($settings)) {
                return array_merge($defaultSettings, $settings);
            }
        }

        return $defaultSettings;
    }

    // Method untuk cek apakah pengumuman aktif
    public function isActive()
    {
        if ($this->status !== 'active') return false; // Konsisten
        
        if ($this->start_date && now()->lt($this->start_date)) return false;
        
        if ($this->end_date && now()->gt($this->end_date)) return false;
        
        return true;
    }

    // Mutator untuk modal_settings
    public function setModalSettingsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['modal_settings'] = json_encode($value);
        } elseif (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['modal_settings'] = $value;
            } else {
                $this->attributes['modal_settings'] = json_encode([]);
            }
        } else {
            $this->attributes['modal_settings'] = json_encode([]);
        }
    }

    // Scope untuk modal aktif - PERBAIKAN (ubah 'published' menjadi 'active')
    public function scopeActiveModal($query)
    {
        return $query->where('show_as_modal', true)
            ->where('show_on_frontend', true)
            ->where('status', 'active') // UBAH INI dari 'published' ke 'active'
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc');
    }
    
    /**
     * Static method untuk mendapatkan pengumuman modal aktif - PERBAIKAN
     * Hapus cek cookie di server side, cukup di client side saja
     */
    public static function getActiveModalAnnouncement()
    {
        try {
            // Hapus cek cookie di sini untuk menghindari error
            // Cukup ambil pengumuman aktif saja
            return self::activeModal()->first();
            
        } catch (\Exception $e) {
            \Log::error('Error getting active modal announcement: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Method helper untuk mendapatkan semua pengumuman modal aktif (tanpa filter cookie)
     */
    public static function getAllActiveModalAnnouncements()
    {
        return self::activeModal()->get();
    }
}