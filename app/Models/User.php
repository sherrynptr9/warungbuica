<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; <--- SAYA HAPUS INI

// Import untuk Relasi
use Illuminate\Database\Eloquent\Relations\HasMany;

// Import untuk Filament (Wajib agar bisa login ke Admin Panel)
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    // SAYA HAPUS 'HasApiTokens' DARI SINI
    use HasFactory, Notifiable; 

    /**
     * Logika akses panel admin Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true; 
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- RELASI ---

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function financialRecords(): HasMany
    {
        return $this->hasMany(FinancialRecord::class);
    }
}