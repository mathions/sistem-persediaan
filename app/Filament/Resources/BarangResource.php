<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Filament\Exports\BarangExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function getNavigationGroup(): ?string
    {
        return 'Kelola Barang';
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        // Nama Barang
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->placeholder('Masukkan nama barang')
                            ->required()
                            ->maxLength(255),

                        // Satuan
                        Select::make('satuan_id')
                            ->label('Satuan')
                            ->relationship('satuan', 'nama_satuan') // pastikan relasi ada di model
                            ->required(),

                        // Harga Beli
                        TextInput::make('harga_beli')
                            ->label('Harga Beli')
                            ->placeholder('Masukkan harga beli')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),

                        // Stok
                        TextInput::make('stok')
                            ->label('Stok')
                            ->placeholder('Jumlah stok')
                            ->numeric()
                            ->required(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No.'),
                TextColumn::make('nama_barang')->searchable()
                    ->label('Barang'),
                TextColumn::make('satuan.nama_satuan'),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),
                TextColumn::make('stok'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            // 'index' => Pages\ListBarangs::route('/'),
            // 'create' => Pages\CreateBarang::route('/create'),
            // 'edit' => Pages\EditBarang::route('/{record}/edit'),
            'index' => Pages\ManageBarangs::route('/'),
        ];
    }
}
