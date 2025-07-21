<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiMasukResource\Pages;
use App\Filament\Resources\TransaksiMasukResource\RelationManagers;
use App\Models\TransaksiMasuk;
use App\Models\Barang;
use App\Filament\Exports\TransaksiExporter;
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
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TransaksiMasukResource extends Resource
{
    protected static ?string $model = TransaksiMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right';

    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }

    protected static ?int $navigationSort = 1;

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

                        // Keterangan
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Masukkan keterangan')
                            ->nullable()
                            ->columnSpan(2),

                        // user_id disembunyikan, terisi otomatis dari user login
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),

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
                TextColumn::make('referensi.nama_barang')
                    ->label('Barang')
                    ->searchable(),
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
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
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
            'index' => Pages\ManageTransaksiMasuks::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }
}
