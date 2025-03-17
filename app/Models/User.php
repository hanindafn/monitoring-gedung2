<?php

namespace App\Models;

use AshAllenDesign\ShortURL\Models\ShortURL;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'nama_user', // Menggunakan 'nama_user' sesuai dengan migration
        'email',
        'password',
        'nip',
        'no_hp',
        'id_instansi',
        'is_admin',
    ];

    // protected $hidden = ['password'];

    // protected $attributes = ['role' => 'pelapor']; // Default role

    public function laporan()
    {
        return $this->hasMany(Pelaporan::class, 'id_laporan');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Pastikan is_admin dikonversi sebagai boolean
        ];
    }

    /**
     * Get the Filament username.
     */
    public function getFilamentName(): string
    {
        return $this->nama_user ?? 'User'; // Gunakan 'nama_user' sesuai migration
    }

    /**
     * Check if user can access Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Jika panel adalah 'admin', hanya admin yang bisa akses
        if ($panel->getId() === 'admin') {
            return $this->is_admin == 1; // Pastikan nilai yang dikembalikan adalah boolean
        }
    
        // Jika panel adalah 'pengguna', hanya pelapor yang bisa akses
        if ($panel->getId() === 'pengguna') {
            return !$this->is_admin; // Jika bukan admin, berarti pelapor
        }
    
        // Default: jika tidak cocok dengan kondisi di atas, tolak akses
        return false;
    }

    /**
     * Relasi ke tabel instansi.
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi', 'id_instansi');
    }

    /**
     * Relasi ke tabel ShortURL.
     */
    public function short_urls()
    {
        return $this->hasMany(ShortURL::class);
    }
}
