<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailUsulanResource\Pages;
use App\Filament\Resources\DetailUsulanResource\RelationManagers;
use App\Models\DetailUsulan;
use App\Filament\Exports\DetailUsulanExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailUsulanResource extends Resource
{
    protected static ?string $model = DetailUsulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Rekapitulasi';
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->getStateUsing(fn ($record, $livewire) => $livewire->getTableRecords()->search(fn ($item) => $item->id === $record->id) + 1),
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->label('Barang'),
                TextColumn::make('satuan.nama_satuan')
                    ->label('Satuan'),
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date(),
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
            'index' => Pages\ListDetailUsulans::route('/'),
            'create' => Pages\CreateDetailUsulan::route('/create'),
            'edit' => Pages\EditDetailUsulan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }
}
