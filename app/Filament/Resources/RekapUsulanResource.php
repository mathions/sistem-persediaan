<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapUsulanResource\Pages;
use App\Filament\Resources\RekapUsulanResource\RelationManagers;
use App\Models\RekapUsulan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapUsulanResource extends Resource
{
    protected static ?string $model = RekapUsulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Rekapitulasi';
    }

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role !== 'pegawai';
    }

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
                TextColumn::make('referensi.nama_barang')
                    ->searchable()
                    ->label('Barang'),
                TextColumn::make('referensi.satuan.nama_satuan')
                    ->label('Satuan'),
                TextColumn::make('volume')
                    ->label('Volume'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageRekapUsulans::route('/'),
        ];
    }
}
