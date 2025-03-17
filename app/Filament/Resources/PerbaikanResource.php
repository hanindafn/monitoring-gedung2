<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerbaikanResource\Pages;
use App\Models\Perbaikan;
use App\Models\Laporan;
use App\Models\Teknisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteAction;


class PerbaikanResource extends Resource
{
    protected static ?string $model = Perbaikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_laporan')
                    ->label('Laporan')
                    ->relationship('Laporan', 'deskripsi_kerusakan')
                    ->required(),
                Forms\Components\Select::make('id_teknisi')
                    ->label('Teknisi')
                    ->relationship('teknisi', 'nama_teknisi')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->nullable(),
                Forms\Components\Textarea::make('deskripsi_perbaikan')
                    ->label('Deskripsi Perbaikan')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'survei lapangan' => 'Survei Lapangan',
                        'ditugaskan' => 'Ditugaskan',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('survei lapangan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_perbaikan')->label('ID')->sortable(),
                TextColumn::make('Laporan.deskripsi_kerusakan')->label('Laporan')->sortable(),
                TextColumn::make('teknisi.nama_teknisi')->label('Teknisi')->sortable()->default('Belum Ditugaskan'),
                TextColumn::make('tanggal_mulai')->label('Mulai')->dateTime('d M Y H:i'),
                TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->formatStateUsing(fn ($state) => $state ? $state->format('d M Y H:i') : 'Belum Selesai'),

                                BadgeColumn::make('status')
                                    ->colors([
                                        'gray' => 'survei lapangan',
                                        'blue' => 'ditugaskan',
                                        'yellow' => 'diproses',
                                        'green' => 'selesai',
                                        'red' => 'ditolak',
                                    ]),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerbaikans::route('/'),
            'create' => Pages\CreatePerbaikan::route('/create'),
            'edit' => Pages\EditPerbaikan::route('/{record}/edit'),
        ];
    }
}
