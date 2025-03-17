<?php

namespace App\Filament\Resources\LaporanMasukResource\Pages;

use App\Filament\Resources\LaporanMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporanMasuks extends ListRecords
{
    protected static string $resource = LaporanMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
