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

            Actions\Action::make('Rekap')
                ->color('warning')
                ->icon('heroicon-o-document-text')
                ->requiresConfirmation()
                ->visible(fn () =>
                    auth()->user()?->role !== 'pegawai' &&
                    $this->record->status_id != 2
                )
                ->action(function () {
                    // Update status usulan jadi "Direkap"
                    $this->record->update(['status_id' => 2]); // 2 = Direkap

                    // Ambil semua detail usulan terkait
                    $details = $this->record->detail_usulan;

                    foreach ($details as $detail) {
                        $rekap = \App\Models\RekapUsulan::where('referensi_id', $detail->referensi_id)->first();

                        if ($rekap) {
                            // Tambah volume jika sudah ada
                            $rekap->update([
                                'volume' => $rekap->volume + $detail->volume,
                            ]);
                        } else {
                            // Buat rekap baru jika belum ada
                            \App\Models\RekapUsulan::create([
                                'referensi_id' => $detail->referensi_id,
                                'volume' => $detail->volume,
                            ]);
                        }
                    }

                    Notification::make()
                        ->title('Berhasil')
                        ->body('Pengajuan direkap.')
                        ->success()
                        ->send();

                    return redirect(UsulanResource::getUrl('index'));
                }),


            // //Batal Rekap hanya untuk user yang bukan pegawai
            // Actions\Action::make('Batal Rekap')
            //     ->color('warning')
            //     ->icon('heroicon-o-document-text')
            //     ->requiresConfirmation()
            //     ->visible(fn () =>
            //         auth()->user()?->role !== 'pegawai' &&
            //         $this->record->status_id != 1
            //     )
            //     ->action(function () {
            //         $this->record->update(['status_id' => 1]); // 1 = Diajukan
            //         Notification::make()
            //             ->title('Berhasil')
            //             ->body('Pengajuan batal direkap.')
            //             ->success()
            //             ->send();

            //         return redirect(UsulanResource::getUrl('index'));
            //     }),

        ];
    }
}
