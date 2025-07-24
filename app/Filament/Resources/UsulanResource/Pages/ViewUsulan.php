<?php

namespace App\Filament\Resources\UsulanResource\Pages;

use App\Filament\Resources\UsulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ViewUsulan extends ViewRecord
{
    protected static string $resource = UsulanResource::class;

        protected function getHeaderActions(): array
    {
        return [
            // Hapus hanya jika user adalah pembuat usulan
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->id() === $this->record->user_id),

            //Rekap hanya untuk user yang bukan pegawai
            Actions\Action::make('Rekap')
                ->color('warning')
                ->icon('heroicon-o-document-text')
                ->requiresConfirmation()
                ->visible(fn () =>
                    auth()->user()?->role !== 'pegawai' &&
                    $this->record->status_id != 2
                )
                ->action(function () {
                    $this->record->update(['status_id' => 2]); // 2 = Direkap
                    Notification::make()
                        ->title('Berhasil')
                        ->body('Pengajuan direkap.')
                        ->success()
                        ->send();

                    return redirect(UsulanResource::getUrl('index'));
                }),

            //Batal Rekap hanya untuk user yang bukan pegawai
            Actions\Action::make('Batal Rekap')
                ->color('warning')
                ->icon('heroicon-o-document-text')
                ->requiresConfirmation()
                ->visible(fn () =>
                    auth()->user()?->role !== 'pegawai' &&
                    $this->record->status_id != 1
                )
                ->action(function () {
                    $this->record->update(['status_id' => 1]); // 1 = Diajukan
                    Notification::make()
                        ->title('Berhasil')
                        ->body('Pengajuan batal direkap.')
                        ->success()
                        ->send();

                    return redirect(UsulanResource::getUrl('index'));
                }),

        ];
    }
}
