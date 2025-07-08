<?php

namespace App\Filament\Resources\DetailUsulanResource\Pages;

use App\Filament\Resources\DetailUsulanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDetailUsulan extends CreateRecord
{
    protected static string $resource = DetailUsulanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
