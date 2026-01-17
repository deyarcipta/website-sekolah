<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'description',
        'logo',
        'hero_image',
        'hero_title',
        'hero_subtitle',
        'overview_title',
        'overview_content',
        'overview_image',
        'vision',
        'mission',
        'vision_mission_title',
        'vision_mission_content',
        'vision_mission_image',
        'quote',
        'quote_author',
        'quote_position',
        'learning_title',
        'learning_content',
        'learning_items',
        'learning_image',
        'teachers_title',
        'teachers_content',
        'achievements_title',
        'achievements_content',
        'achievement_items',
        'accordion_items',
        'accordion_image', 
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'order'
    ];

    protected $casts = [
        'learning_items' => 'array',
        'achievement_items' => 'array',
        'accordion_items' => 'array',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function teachers()
    {
        return $this->hasMany(MajorTeacher::class)->orderBy('order');
    }

    public function achievements()
    {
        return $this->hasMany(MajorAchievement::class)->orderBy('year', 'desc')->orderBy('order');
    }

    // URL Helpers
    public function getHeroImageUrl()
    {
        return $this->hero_image ? asset('storage/' . $this->hero_image) : asset('assets/img/default-hero.jpg');
    }

    public function getLogoUrl()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('assets/img/default-logo.png');
    }

    public function getOverviewImageUrl()
    {
        return $this->overview_image ? asset('storage/' . $this->overview_image) : asset('assets/img/default-overview.jpg');
    }

    public function getVisionMissionImageUrl()
    {
        return $this->vision_mission_image ? asset('storage/' . $this->vision_mission_image) : asset('assets/img/default-vision-mission.jpg');
    }

    public function getLearningImageUrl()
    {
        return $this->learning_image ? asset('storage/' . $this->learning_image) : asset('assets/img/default-learning.jpg');
    }

    // Get active majors for frontend
    public static function getActiveMajors()
    {
        return self::where('is_active', true)->orderBy('order')->get();
    }

    // Get major by slug
    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    // Generate slug
    public static function generateSlug($name)
    {
        $slug = str()->slug($name);
        $count = self::where('slug', 'LIKE', $slug . '%')->count();
        
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}