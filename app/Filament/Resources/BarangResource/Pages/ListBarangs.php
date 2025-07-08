<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Filament\Exports\BarangExporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(BarangExporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Ekspor'),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah Barang'),
        ];
    }
}
