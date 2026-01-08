<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeunggulanSekolah extends Model
{
    use HasFactory; // Hapus SoftDeletes

    protected $table = 'keunggulan_sekolah';

    protected $fillable = [
        'judul',
        'deskripsi',
        'icon',
        'warna',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}