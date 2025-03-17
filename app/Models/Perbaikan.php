<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;


class Perbaikan extends Model
{
    use HasFactory;

    protected $table = 'perbaikan';
    protected $primaryKey = 'id_perbaikan';
    protected $fillable = [
        'id_laporan',
        'id_teknisi',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi_perbaikan',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'id_teknisi');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_perbaikan');
    }

    public static function boot()
    {
        parent::boot();

        // Event ketika status perbaikan diperbarui
        static::updating(function ($perbaikan) {
            if ($perbaikan->isDirty('status')) { // Cek apakah status berubah
                $laporan = $perbaikan->laporan;
                if ($laporan) {
                    $laporan->update(['status' => $perbaikan->status]);
                }
            }
        });
    }
}
