<?php

namespace App\Filament\Resources\StokResource\Pages;

use App\Filament\Resources\StokResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStoks extends ManageRecords
{
    protected static string $resource = StokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('Unduh Laporan')
                ->label('Unduh Laporan')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('stok.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
