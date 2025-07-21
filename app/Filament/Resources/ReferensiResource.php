<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferensiResource\Pages;
use App\Filament\Resources\ReferensiResource\RelationManagers;
use App\Models\Referensi;
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

class ReferensiResource extends Resource
{
    protected static ?string $model = Referensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function getNavigationGroup(): ?string
    {
        return 'Kelola Persediaan';
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
                            ->maxLength(255)
                            ->columnSpan(2),

                        // Satuan
                        Select::make('satuan_id')
                            ->label('Satuan')
                            ->relationship('satuan', 'nama_satuan') // pastikan relasi ada di model
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->width('80px')
                    ->getStateUsing(fn ($record, $livewire) => $livewire->getTableRecords()->search(fn ($item) => $item->id === $record->id) + 1),
                TextColumn::make('nama_barang')->searchable()
                    ->label('Barang'),
                TextColumn::make('satuan.nama_satuan')
                    ->label('Satuan'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReferensis::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }
}
