<?php

namespace App\Filament\Resources\TransaksiKeluarResource\Pages;

use App\Filament\Resources\TransaksiKeluarResource;
use App\Filament\Exports\TransaksiKeluarExporter;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTransaksiKeluars extends ManageRecords
{
    protected static string $resource = TransaksiKeluarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(TransaksiKeluarExporter::class)
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