<?php
// app/Models/WebsiteStatistic.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebsiteStatistic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'website_statistics';
    
    protected $fillable = [
        'name',
        'display_name',
        'category',
        'value',
        'unit',
        'icon',
        'color',
        'sort_order',
        'is_visible',
        'is_editable',
        'is_auto_increment',
        'settings',
        'description'
    ];

    protected $casts = [
        'value' => 'integer',
        'is_visible' => 'boolean',
        'is_editable' => 'boolean',
        'is_auto_increment' => 'boolean',
        'settings' => 'array',
        'sort_order' => 'integer'
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(WebsiteStatisticLog::class, 'statistic_id');
    }

    // Accessor untuk nilai dengan format
    public function getFormattedValueAttribute(): string
    {
        $value = $this->value;
        
        if ($value >= 1000000) {
            return number_format($value / 1000000, 1) . ' jt';
        }
        
        if ($value >= 1000) {
            return number_format($value / 1000, 1) . ' rb';
        }
        
        return number_format($value);
    }

    // Scope untuk statistik yang ditampilkan
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }

    // Method untuk increment otomatis
    public function incrementValue($amount = 1): void
    {
        $oldValue = $this->value;
        $this->increment('value', $amount);
        $this->logChange('auto', $oldValue, $this->value, 'Auto increment');
    }

    // Method untuk log perubahan
    public function logChange($type, $oldValue, $newValue, $notes = null): void
    {
        $this->logs()->create([
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'change_type' => $type,
            'notes' => $notes,
            'user_id' => auth()->id()
        ]);
    }
}