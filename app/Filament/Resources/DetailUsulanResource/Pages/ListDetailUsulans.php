<?php

namespace App\Filament\Resources\DetailUsulanResource\Pages;

use App\Filament\Resources\DetailUsulanResource;
use App\Filament\Exports\DetailUsulanExporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ExportAction;

class ListDetailUsulans extends ListRecords
{
    protected static string $resource = DetailUsulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(DetailUsulanExporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Ekspor'),
        ];
    }
}
