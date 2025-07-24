<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use App\Models\TransaksiKeluar;
use App\Filament\Resources\PemakaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class EditPemakaian extends EditRecord
{
    protected static string $resource = PemakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Hapus hanya jika user adalah pembuat pemakaian
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->id() === $this->record->user_id),
        
            ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
