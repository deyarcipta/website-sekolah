<?php
// app/Models/GalleryImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image',
        'caption',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Accessor untuk URL gambar lengkap
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}