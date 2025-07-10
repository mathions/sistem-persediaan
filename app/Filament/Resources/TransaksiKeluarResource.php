<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiKeluarResource\Pages;
use App\Filament\Resources\TransaksiKeluarResource\RelationManagers;
use App\Models\TransaksiKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiKeluarResource extends Resource
{
    protected static ?string $model = TransaksiKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left';

    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        // Barang
                        Select::make('barang_id')
                            ->label('Barang')
                            ->relationship('barang', 'nama_barang') // pastikan relasi ada di model
                            ->searchable()
                            ->required(),

                        // Satuan
                        Select::make('satuan_id')
                            ->label('Satuan')
                            ->relationship('satuan', 'nama_satuan') // pastikan relasi ada di model
                            ->required(),

                        // Jumlah
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->placeholder('Masukkan jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        // user_id disembunyikan, terisi otomatis dari user login
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->getStateUsing(fn ($record, $livewire) => $livewire->getTableRecords()->search(fn ($item) => $item->id === $record->id) + 1),
                TextColumn::make('barang.nama_barang')
                    ->label('Barang')
                    ->searchable(),
                TextColumn::make('satuan.nama_satuan')
                    ->label('Satuan'),
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                TextColumn::make('user.name')
                    ->label('Nama'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTransaksiKeluars::route('/'),
            'create' => Pages\CreateTransaksiKeluar::route('/create'),
            'edit' => Pages\EditTransaksiKeluar::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }
}
