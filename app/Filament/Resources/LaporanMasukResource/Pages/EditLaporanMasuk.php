<?php

namespace App\Filament\Resources\LaporanMasukResource\Pages;

use App\Filament\Resources\LaporanMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanMasuk extends EditRecord
{
    protected static string $resource = LaporanMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
