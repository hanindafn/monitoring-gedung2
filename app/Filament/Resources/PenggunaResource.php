<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaResource\Pages;
use App\Models\User;
use App\Models\Instansi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BooleanColumn; 
use Filament\Tables\Columns\TextColumn;


class PenggunaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_user')
                    ->label('Nama')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->unique()
                    ->maxLength(20),

                // Forms\Components\TextInput::make('email')
                //     ->label('Email')
                //     ->email()
                //     ->required()
                //     ->unique()
                //     ->maxLength(50),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true) // Ini akan mengabaikan email yang sedang diedit
                    ->required(),
                

                Forms\Components\TextInput::make('no_hp')
                    ->label('No HP')
                    ->tel()
                    ->maxLength(15),

                    Select::make('is_admin')
                    ->label('Peran')
                    ->options([
                        1 => 'Admin',
                        0 => 'Pengguna',
                    ])
                    ->default(0) // Set default ke Pengguna (0)
                    ->required(),

                Select::make('id_instansi')
                    ->relationship('instansi', 'nama_instansi') // Menghubungkan dengan model Instansi
                    ->required()
                    ->label('Instansi'),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->with(['instansi']) // Tambahkan ini
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_user')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('no_hp')->label('No HP'),
                
                // Tables\Columns\BadgeColumn::make('role')
                //     ->label('Role')
                //     ->formatStateUsing(fn ($state) => ucfirst($state))
                //     ->colors([
                //         'admin' => 'success',
                //         'pelapor' => 'warning',
                //     ]),

                TextColumn::make('is_admin')
                    ->label('Peran') // Ganti label menjadi "Peran"
                    ->formatStateUsing(fn ($state) => $state ? 'Admin' : 'Pelapor') // Menampilkan teks Admin/Pelapor
                    ->sortable(),

                Tables\Columns\TextColumn::make('instansi.nama_instansi')
                    ->label('Instansi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenggunas::route('/'),
            'create' => Pages\CreatePengguna::route('/create'),
            'edit' => Pages\EditPengguna::route('/{record}/edit'),
        ];
    }

    public static function query(EloquentBuilder $query): EloquentBuilder
    {
        if (auth()->user()->is_admin) {
            return $query; // Admin bisa melihat semua pengguna
        }

        return $query->where('id_user', auth()->id()); // Pengguna hanya bisa melihat dirinya sendiri
    }

}
