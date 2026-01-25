<?php
// app/Models/WebsiteStatisticLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteStatisticLog extends Model
{
    use HasFactory;

    protected $table = 'website_statistic_logs';
    
    protected $fillable = [
        'statistic_id',
        'old_value',
        'new_value',
        'change_type',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'old_value' => 'integer',
        'new_value' => 'integer'
    ];

    public function statistic(): BelongsTo
    {
        return $this->belongsTo(WebsiteStatistic::class, 'statistic_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk nilai perubahan
    public function getChangeAttribute(): int
    {
        return $this->new_value - ($this->old_value ?? 0);
    }

    public function getFormattedChangeAttribute(): string
    {
        $change = $this->change;
        $prefix = $change >= 0 ? '+' : '';
        
        if (abs($change) >= 1000000) {
            return $prefix . number_format($change / 1000000, 1) . ' jt';
        }
        
        if (abs($change) >= 1000) {
            return $prefix . number_format($change / 1000, 1) . ' rb';
        }
        
        return $prefix . number_format($change);
    }
}