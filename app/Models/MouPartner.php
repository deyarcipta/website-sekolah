<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MouPartner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'slug',
        'logo',
        'description',
        'website',
        'email',
        'phone',
        'address',
        'contact_person',
        'contact_position',
        'partner_type',
        'status',
        'mou_date',
        'mou_expired_date',
        'sort_order'
    ];

    protected $casts = [
        'mou_date' => 'date',
        'mou_expired_date' => 'date',
    ];

    protected $appends = ['logo_url', 'mou_status'];

    // Accessor for logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('assets/img/default-company.png');
    }

    // Accessor for MOU status
    public function getMouStatusAttribute()
    {
        if (!$this->mou_expired_date) {
            return 'unknown';
        }
        
        if ($this->mou_expired_date->isPast()) {
            return 'expired';
        }
        
        if ($this->mou_expired_date->diffInDays(now()) <= 30) {
            return 'expiring_soon';
        }
        
        return 'active';
    }

    // Scope for active partners
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Generate slug
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Str::slug($model->company_name);
            }
        });
    }
}