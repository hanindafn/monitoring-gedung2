<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporan';
    protected $primaryKey = 'id_laporan';
    protected $fillable = [
        'id_user',
        'id_gedung',
        'tanggal_lapor',
        'deskripsi_kerusakan',
        'tipe_kerusakan',
        'tingkat_kepentingan',
        'status'
    ];

    protected $casts = [
        'tanggal_lapor' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function perbaikan()
    {
        return $this->hasOne(Perbaikan::class, 'id_laporan');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_laporan');
    }
}
