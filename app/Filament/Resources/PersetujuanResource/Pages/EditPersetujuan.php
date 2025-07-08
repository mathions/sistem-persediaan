<?php

namespace App\Filament\Resources\PersetujuanResource\Pages;

use App\Filament\Resources\PersetujuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersetujuan extends EditRecord
{
    protected static string $resource = PersetujuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $persetujuan = $this->record;

        // Update status pemakaian sesuai status persetujuan
        $persetujuan->pemakaian?->update([
            'status_id' => $persetujuan->status_id,
        ]);
    }
}
