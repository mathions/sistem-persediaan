<?php

namespace App\Filament\Resources\TransaksiMasukResource\Pages;

use App\Filament\Resources\TransaksiMasukResource;
use App\Filament\Exports\TransaksiMasukExporter;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTransaksiMasuks extends ManageRecords
{
    protected static string $resource = TransaksiMasukResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(TransaksiMasukExporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Ekspor')
                ->visible(fn () => auth()->user()?->role !== 'pegawai'),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah')
                ->visible(fn () => auth()->user()?->role !== 'pegawai'),
        ];
    }
}