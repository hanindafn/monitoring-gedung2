<?php

namespace App\Filament\Pengguna\Resources\LaporanResource\Pages;

use App\Filament\Pengguna\Resources\LaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLaporan extends CreateRecord
{
    protected static string $resource = LaporanResource::class;

    // protected function afterCreate(): void
    // {
    //     $laporan = $this->record; // Ambil laporan yang baru dibuat

    //     // Simpan foto ke tabel foto
    //     if ($this->form->getState()['foto']) {
    //         foreach ($this->form->getState()['foto'] as $file) {
    //             Foto::create([
    //                 'id_laporan' => $laporan->id_laporan,
    //                 'url_foto' => $file, // Simpan path foto
    //             ]);
    //         }
    //     }
    // }
}
