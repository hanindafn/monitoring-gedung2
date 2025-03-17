<?php

namespace App\Filament\Pengguna\Resources;

use App\Filament\Pengguna\Resources\LaporanResource\Pages;
use App\Models\Laporan;
use App\Models\Gedung;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use App\Models\Foto;


use Filament\Forms\Components\Select;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;

    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // protected static ?string $navigationGroup = 'Pelaporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Lapor')
                    ->default(now())
                    ->required(),

                    Select::make('id_gedung')
                    ->relationship('gedung', 'nama_gedung') // Menghubungkan dengan model Instansi
                    ->required()
                    ->label('Gedung'),

                Forms\Components\Textarea::make('deskripsi_kerusakan')
                    ->label('Deskripsi Kerusakan')
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

                    // Forms\Components\FileUpload::make('foto')
                    // ->label('Foto Kerusakan')
                    // ->multiple() // Mengizinkan upload banyak foto
                    // ->image()
                    // ->directory('uploads/foto_laporan') // Direktori penyimpanan
                    // ->preserveFilenames()
                    // ->required(),
                

                // Forms\Components\Select::make('status')
                //     ->label('Status')
                //     ->options([
                //         'menunggu' => 'Menunggu',
                //         'survei lapangan' => 'Survei Lapangan',
                //         'ditugaskan' => 'Ditugaskan',
                //         'dalam antrean' => 'Dalam Antrean',
                //         'diproses' => 'Diproses',
                //         'selesai' => 'Selesai',
                //         'ditolak' => 'Ditolak',
                //     ])
                //     ->default('menunggu')
                //     ->required(),

                Forms\Components\Hidden::make('id_user')
                    ->default(auth()->id()), // Auto-fill id_user dari user login
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(
            Laporan::query()->where('id_user', auth()->id()) // Menampilkan hanya laporan user login
        )
        ->columns([
            
            // Tables\Columns\TextColumn::make('id_laporan')
            //     ->label('ID')
            //     ->sortable(),

            // Tables\Columns\TextColumn::make('users.nama_user')
            //     ->label('Pelapor')
            //     ->sortable(),

            Tables\Columns\TextColumn::make('gedung.nama_gedung')
                ->label('Gedung')
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('deskripsi_kerusakan')
                ->label('Deskripsi')
                ->limit(50),

            Tables\Columns\TextColumn::make('tipe_kerusakan')
                ->label('Tipe Kerusakan'),

            // Tables\Columns\ImageColumn::make('foto.url_foto')
            //     ->label('Foto')
            //     ->circular(),
            

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
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
            'create' => Pages\CreateLaporan::route('/create'),
            'edit' => Pages\EditLaporan::route('/{record}/edit'),
        ];
    }
}
