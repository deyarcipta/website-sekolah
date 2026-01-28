<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'foto_profil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Scope untuk user aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk user berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Attribute untuk warna badge berdasarkan role
     */
    public function getRoleColorAttribute()
    {
        return match($this->role) {
            'superadmin' => 'danger',
            'admin' => 'primary',
            default => 'info',
        };
    }

    /**
     * URL foto profil lengkap
     */
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            // Jika foto profil ada di storage
            if (strpos($this->foto_profil, 'http') === 0) {
                return $this->foto_profil;
            }
            return asset('storage/' . $this->foto_profil);
        }
        
        // Default avatar berdasarkan inisial nama
        return $this->getDefaultAvatarUrl();
    }

    /**
     * Generate default avatar URL dengan inisial
     */
    private function getDefaultAvatarUrl()
    {
        $initials = $this->initials;
        $background = $this->role === 'superadmin' ? 'DC3545' : '6B02B1';
        
        return "https://ui-avatars.com/api/?name={$initials}&background={$background}&color=FFFFFF&size=150&bold=true&format=svg";
    }

    /**
     * Inisial nama untuk avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Cek jika user adalah superadmin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    /**
     * Cek jika user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Update waktu login terakhir
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }
}