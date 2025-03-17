<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';
    protected $primaryKey = 'id_foto';
    protected $fillable = [
        'id_laporan',
        'id_perbaikan',
        'id_gedung',
        'url_foto'
    ];

    public function laporan()
    {
        return $this->belongsTo(Pelaporan::class, 'id_laporan');
    }

    public function perbaikan()
    {
        return $this->belongsTo(Perbaikan::class, 'id_perbaikan');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }
}
