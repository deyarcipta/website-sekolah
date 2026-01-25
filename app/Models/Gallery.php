<?php
// app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'tanggal',
        'cover_image',
        'is_published',
        'published_at',
        'urutan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'urutan' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->judul);
            }
        });

        static::updating(function ($gallery) {
            if ($gallery->isDirty('judul') && empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->judul);
            }
        });
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    // Relationship dengan images
    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('urutan', 'asc');
    }

    // Accessor untuk tanggal pendek
    public function getTanggalShortAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : '-';
    }
}