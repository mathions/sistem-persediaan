<?php

namespace App\Filament\Resources\ReferensiResource\Pages;

use App\Filament\Resources\ReferensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReferensis extends ManageRecords
{
    protected static string $resource = ReferensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
