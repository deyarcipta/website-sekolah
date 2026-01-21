<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    
    protected $fillable = [
        'nama',
        'slug',
        'warna',
        'icon',
        'deskripsi',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer'
    ];

    public function berita()
    {
        // Tentukan foreign key secara eksplisit untuk konsistensi
        return $this->hasMany(Berita::class, 'kategori_id');
    }

    public function getTotalBeritaAttribute()
    {
        return $this->berita()->count();
    }

    public function getActiveBeritaAttribute()
    {
        return $this->berita()->where('is_active', true)->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }
}