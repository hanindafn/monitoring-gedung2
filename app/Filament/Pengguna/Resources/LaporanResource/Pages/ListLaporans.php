<?php

namespace App\Filament\Pengguna\Resources\LaporanResource\Pages;

use App\Filament\Pengguna\Resources\LaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
