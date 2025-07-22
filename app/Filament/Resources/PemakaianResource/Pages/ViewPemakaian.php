<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use App\Filament\Resources\PemakaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPemakaian extends ViewRecord
{
    protected static string $resource = PemakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
        // Tombol download PDF
        Actions\Action::make('Download PDF')
            ->label('Unduh Formulir')
            ->icon('heroicon-o-arrow-down-tray')
            ->url(fn () => route('pemakaian.pdf', ['pemakaian' => $this->record->id]))
            ->openUrlInNewTab()
        ];
    }
}
