<?php
// app/Models/AgendaSekolah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaSekolah extends Model
{
    use HasFactory;

    protected $table = 'agenda_sekolah';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'bulan',
        'hari',
        'waktu',
        'lokasi',
        'warna',
        'urutan',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'published_at' => 'datetime',
        'is_published' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->bulan) && $model->tanggal) {
                $model->bulan = $model->tanggal->format('M Y');
                $model->hari = $model->tanggal->format('d');
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('tanggal')) {
                $model->bulan = $model->tanggal->format('M Y');
                $model->hari = $model->tanggal->format('d');
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('tanggal')->orderBy('waktu');
    }

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal->format('d F Y');
    }

    public function getWaktuFormatAttribute()
    {
        return $this->waktu ? date('H:i', strtotime($this->waktu)) : null;
    }
}