<?php

namespace App\Filament\Resources\UsulanResource\Pages;

use App\Filament\Resources\UsulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsulans extends ListRecords
{
    protected static string $resource = UsulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Buat Usulan')
                ->visible(fn () => auth()->user()?->role === 'pegawai'),
        ];
    }
}
