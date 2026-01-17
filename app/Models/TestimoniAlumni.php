<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimoniAlumni extends Model
{
    use HasFactory;

    protected $table = 'testimoni_alumni';
    
    protected $fillable = [
        'nama',
        'program_studi',
        'angkatan',
        'testimoni',
        'foto',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/img/default-alumni.jpg');
    }

    public function getInfoAlumniAttribute()
    {
        $info = $this->nama;
        if ($this->program_studi) {
            $info .= " ({$this->program_studi})";
        }
        if ($this->angkatan) {
            $info .= " - Angkatan {$this->angkatan}";
        }
        return $info;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('created_at', 'desc');
    }
}