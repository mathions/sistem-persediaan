<?php

namespace App\Filament\Resources\DetailUsulanResource\Pages;

use App\Filament\Resources\DetailUsulanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailUsulan extends EditRecord
{
    protected static string $resource = DetailUsulanResource::class;

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
}
