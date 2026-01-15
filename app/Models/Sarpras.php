<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    use HasFactory;

    protected $table = 'sarpras';

    protected $fillable = [
        'hero_title',
        'hero_background',
        'opening_paragraph',
        'learning_title',
        'learning_description',
        'learning_features',
        'learning_image',
        'facilities_title',
        'facilities_items',  // facilities_count dihapus
        'gallery_title',
        'gallery_images',    // gallery_count dihapus
    ];

    protected $casts = [
        'learning_features' => 'array',
        'facilities_items'  => 'array',
        'gallery_images'    => 'array',
        // facilities_count dan gallery_count dihapus dari casts
    ];

    protected $attributes = [
        'hero_title'        => 'Sarana dan Prasarana',
        'learning_title'    => 'Lingkungan Belajar Nyaman & Inspiratif',
        'facilities_title'  => 'Fasilitas Unggulan',
        'gallery_title'     => 'Mengintip Fasilitas Kami',
        // facilities_count dan gallery_count dihapus dari attributes
    ];

    protected static function booted()
    {
        static::creating(function ($model) {

            $model->learning_features ??= [
                'Ruang belajar modern, nyaman, ber-AC, dan mendukung pembelajaran kolaboratif.',
                'Infrastruktur digital: Wi-Fi area kampus, proyektor interaktif, dan perpustakaan digital.',
                'Praktik nyata di fasilitas perhotelan dan tata boga bertaraf profesional.',
            ];

            $model->facilities_items ??= [
                [
                    'title' => 'Ruang Belajar Full AC',
                    'desc'  => 'Kelas yang sudah difasilitasi pendingin ruangan.',
                ],
                [
                    'title' => 'Laboratorium Komputer',
                    'desc'  => 'Laboratorium modern untuk praktik IT.',
                ],
                [
                    'title' => 'Perpustakaan Digital',
                    'desc'  => 'Akses e-book dan referensi digital.',
                ],
            ];

            $model->gallery_images ??= [
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
            ];
        });
    }

    /* ================= HELPERS ================= */

    public function getHeroBackgroundUrl()
    {
        return $this->hero_background
            ? asset('storage/' . $this->hero_background)
            : asset('assets/img/foto-gedung.png');
    }

    public function getLearningImageUrl()
    {
        return $this->learning_image
            ? asset('storage/' . $this->learning_image)
            : asset('assets/img/gedung-sarpras.png');
    }

    public function getFacilitiesItems()
    {
        // Mengembalikan semua item tanpa batasan jumlah
        return $this->facilities_items ?? [];
    }

    public function getGalleryImages()
    {
        // Mengembalikan semua gambar tanpa batasan jumlah
        return $this->gallery_images ?? [];
    }

    /* ================= ATTRIBUTE ACCESSORS ================= */

    /**
     * Get the count of facilities items (read-only attribute)
     */
    public function getFacilitiesCountAttribute()
    {
        return count($this->getFacilitiesItems());
    }

    /**
     * Get the count of gallery images (read-only attribute)
     */
    public function getGalleryCountAttribute()
    {
        return count($this->getGalleryImages());
    }

    /**
     * Get first few facilities items (for cases where you need limited items)
     */
    public function getLimitedFacilitiesItems($limit = 6)
    {
        $items = $this->getFacilitiesItems();
        return array_slice($items, 0, $limit);
    }

    /**
     * Get first few gallery images (for cases where you need limited images)
     */
    public function getLimitedGalleryImages($limit = 6)
    {
        $images = $this->getGalleryImages();
        return array_slice($images, 0, $limit);
    }
}