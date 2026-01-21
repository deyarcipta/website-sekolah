<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'berita';

    protected $fillable = [
        'kategori_id',
        'judul',
        'slug',
        'konten',
        'ringkasan',
        'gambar',
        'gambar_thumbnail',
        'penulis',
        'sumber',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
        'likes',
        'shares',
        'is_featured',
        'is_headline',
        'is_published',
        'published_at',
        'archived_at',
        'urutan'
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_headline' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'archived_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function getGambarThumbnailUrlAttribute()
    {
        return $this->gambar_thumbnail ? asset('storage/' . $this->gambar_thumbnail) : $this->gambar_url;
    }

    public function getTanggalPublishAttribute()
    {
        return $this->published_at ? $this->published_at->format('d F Y') : $this->created_at->format('d F Y');
    }

    public function getStatusAttribute()
    {
        if ($this->archived_at) {
            return 'Diarsipkan';
        }

        if (!$this->is_published) {
            return 'Draft';
        }

        if ($this->is_headline) {
            return 'Headline';
        }

        if ($this->is_featured) {
            return 'Featured';
        }

        return 'Published';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNull('archived_at')
                     ->where(function($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHeadline($query)
    {
        return $query->where('is_headline', true);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('judul', 'like', "%{$search}%")
                     ->orWhere('konten', 'like', "%{$search}%")
                     ->orWhere('ringkasan', 'like', "%{$search}%");
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}