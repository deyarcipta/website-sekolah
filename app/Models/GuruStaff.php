<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruStaff extends Model
{
    use HasFactory;

    protected $table = 'guru_staff';

    protected $fillable = [
        'tipe',
        'nama',
        'jabatan',
        'bidang',
        'jurusan',
        'deskripsi',
        'pendidikan',
        'email',
        'telepon',
        'tahun_masuk',
        'urutan',
        'foto',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tahun_masuk' => 'integer',
        'urutan' => 'integer'
    ];

    // Accessor untuk foto URL
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/guru-staff/' . $this->foto);
        }
        return asset('assets/img/foto-guru.png');
    }

    // Scope aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk tipe tertentu
    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // Getter untuk label tipe
    public function getTipeLabelAttribute()
    {
        $labels = [
            'kepala_sekolah' => 'Kepala Sekolah',
            'wakil_kepala_sekolah' => 'Wakil Kepala Sekolah',
            'kepala_jurusan' => 'Kepala Jurusan',
            'guru' => 'Guru',
            'staff' => 'Staff'
        ];
        
        return $labels[$this->tipe] ?? $this->tipe;
    }

    // Getter untuk warna badge berdasarkan tipe
    public function getTipeBadgeClassAttribute()
    {
        $classes = [
            'kepala_sekolah' => 'danger',
            'wakil_kepala_sekolah' => 'warning',
            'kepala_jurusan' => 'info',
            'guru' => 'primary',
            'staff' => 'secondary'
        ];
        
        return $classes[$this->tipe] ?? 'secondary';
    }
}