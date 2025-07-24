<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokResource\Pages;
use App\Filament\Resources\StokResource\RelationManagers;
use App\Models\Stok;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;

class StokResource extends Resource
{
    protected static ?string $model = Stok::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationGroup(): ?string
    {
        return 'Kelola Persediaan';
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        // Referensi
                        Select::make('referensi_id')
                            ->label('Referensi')
                            ->options(function () {
                                return \App\Models\Referensi::all()
                                    ->mapWithKeys(function ($ref) {
                                        $label = $ref->nama_barang . ' (' . $ref->satuan->nama_satuan . ')';
                                        return [$ref->id => $label];
                                    });
                            })
                            ->searchable()
                            ->required()
                            ->columnSpan(2),

                        // Harga Beli
                        TextInput::make('harga_beli')
                            ->label('Harga Beli')
                            ->placeholder('Masukkan harga beli')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),

                        // Volume
                        TextInput::make('volume')
                            ->label('Volume')
                            ->placeholder('Masukkan volume')
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
                TextColumn::make('no')
                    ->label('No.')
                    ->getStateUsing(fn ($record, $livewire) => $livewire->getTableRecords()->search(fn ($item) => $item->id === $record->id) + 1),
                TextColumn::make('referensi.nama_barang')->searchable()
                    ->label('Barang'),
                TextColumn::make('referensi.satuan.nama_satuan')
                    ->label('Satuan'),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('volume')
                    ->label('Volume'),
                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->role === 'admin'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->role === 'admin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStoks::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }

}
