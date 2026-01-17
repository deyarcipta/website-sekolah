<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajorAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'title',
        'image',
        'year',
        'level',
        'category',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function getImageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/img/default-achievement.jpg');
    }

    public static function getActiveAchievements($majorId)
    {
        return self::where('major_id', $majorId)
            ->where('is_active', true)
            ->orderBy('year', 'desc')
            ->orderBy('order')
            ->limit(6)
            ->get();
    }
}