<?php

namespace App\Filament\Resources;

// use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\LaporanMasukResource\Pages;
use App\Models\Laporan;
use App\Models\Perbaikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action as ButtonAction;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;


class LaporanMasukResource extends Resource
{
    protected static ?string $model = Laporan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('tanggal_lapor')
                ->label('Tanggal Lapor')
                ->default(now())
                ->required(),

            Select::make('id_gedung')
                ->relationship('gedung', 'nama_gedung')
                ->required()
                ->label('Gedung'),

            Forms\Components\Textarea::make('deskripsi_kerusakan')
                ->label('Deskripsi Kerusakan')
                ->maxLength(500)
                ->required(),

            Forms\Components\TextInput::make('tipe_kerusakan')
                ->label('Tipe Kerusakan')
                ->required(),

            Forms\Components\Select::make('tingkat_kepentingan')
                ->label('Tingkat Kepentingan')
                ->options([
                    'urgent' => 'Urgent',
                    'tidak urgent' => 'Tidak Urgent',
                ])
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'survei lapangan' => 'Survei Lapangan',
                    'ditugaskan' => 'Ditugaskan',
                    'dalam antrean' => 'Dalam Antrean',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak',
                ])
                ->default('menunggu')
                ->required(),

            Forms\Components\Hidden::make('id_user')
                ->default(fn () => auth()->id()),

        //     Section::make('Aksi')
        //         ->schema([
        //             ButtonAction::make('tindak_lanjut')
        //                 ->label('Tindak Lanjut')
        //                 ->color('primary')
        //                 ->icon('heroicon-o-arrow-right')
        //                 ->action(fn ($livewire) => static::tindakLanjut($livewire->record))
        //                 ->visible(fn ($livewire) => $livewire->record && $livewire->record->status !== 'selesai'),
        //         ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('gedung.nama_gedung')
                ->label('Gedung')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('deskripsi_kerusakan')
                ->label('Deskripsi')
                ->limit(50),

            Tables\Columns\TextColumn::make('tipe_kerusakan')
                ->label('Tipe Kerusakan'),

            Tables\Columns\TextColumn::make('tingkat_kepentingan')
                ->label('Tingkat Kepentingan')
                ->badge()
                ->sortable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->label('Filter Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'survei lapangan' => 'Survei Lapangan',
                    'ditugaskan' => 'Ditugaskan',
                    'dalam antrean' => 'Dalam Antrean',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak',
                ]),
        ])
        ->actions([
            
            // Tables\Actions\EditAction::make(),
            // Tables\Actions\DeleteAction::make(),
            Action::make('tindakLanjut')
                ->label('Tindak Lanjut')
                ->color('primary')
                ->icon('heroicon-o-arrow-right')
                ->action(fn (Laporan $record) => self::tindakLanjut($record))
                ->visible(fn (Laporan $record) => $record->status !== 'selesai'),
            Tables\Actions\ViewAction::make()
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function tindakLanjut(Laporan $laporan)
    {
        $perbaikan = DB::transaction(function () use ($laporan) {
            $perbaikan = Perbaikan::create([
                'id_laporan' => $laporan->id_laporan, // Sesuaikan dengan primary key
                'status' => 'survei lapangan',
                'deskripsi_perbaikan' => '',
            ]);
    
            $laporan->update(['status' => 'survei lapangan']);
    
            return $perbaikan;
        });
    
        Notification::make()
            ->title('Tindak Lanjut Berhasil')
            ->body('Laporan telah diteruskan ke tahap perbaikan.')
            ->success()
            ->send();
        
        return redirect()->to(PerbaikanResource::getUrl('edit', ['record' => $perbaikan->getKey()]));

    }
    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanMasuks::route('/'),
            'create' => Pages\CreateLaporanMasuk::route('/create'),
            'edit' => Pages\EditLaporanMasuk::route('/{record}/edit'),

        ];
    }
}
