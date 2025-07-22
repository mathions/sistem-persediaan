<?php

namespace App\Filament\Resources\RekapUsulanResource\Pages;

use App\Filament\Resources\RekapUsulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRekapUsulans extends ManageRecords
{
    protected static string $resource = RekapUsulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),

            Actions\Action::make('Unduh Rekap')
                ->label('Unduh Rekap')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('rekapusulan.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
