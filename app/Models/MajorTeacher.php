<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajorTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'name',
        'position',
        'image',
        'bio',
        'education',
        'expertise',
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
        return $this->image ? asset('storage/' . $this->image) : asset('assets/img/default-teacher.png');
    }

    public static function getActiveTeachers($majorId)
    {
        return self::where('major_id', $majorId)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}