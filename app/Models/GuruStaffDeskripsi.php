<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruStaffDeskripsi extends Model
{
    protected $table = 'guru_staff_deskripsi';
    protected $fillable = ['deskripsi'];
    
    // Method untuk mendapatkan deskripsi (hanya satu record)
    public static function getDeskripsi()
    {
        return self::first()?->deskripsi ?? '';
    }
    
    // Method untuk update deskripsi
    public static function updateDeskripsi($deskripsi)
    {
        $record = self::first();
        
        if (!$record) {
            $record = new self();
        }
        
        $record->deskripsi = $deskripsi;
        $record->save();
        
        return $record;
    }
}