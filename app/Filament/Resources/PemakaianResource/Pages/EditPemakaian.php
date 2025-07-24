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

            // Setujui hanya untuk user yang bukan pegawai
            Actions\Action::make('Setujui')
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->visible(fn () =>
                    auth()->user()?->role !== 'pegawai' &&
                    $this->record->status_id != 3
                )
                ->action(function () {
                    foreach ($this->record->detail_pemakaian as $detail) {
                        $referensi = $detail->referensi;

                        // Hitung total stok tersedia dari semua entri stok untuk referensi ini
                        $stokTersedia = \App\Models\Stok::where('referensi_id', $referensi->id)->sum('volume');

                        if ($stokTersedia < $detail->volume) {
                            Notification::make()
                                ->title('Stok Tidak Cukup')
                                ->body("Stok untuk barang <strong>{$referensi->nama_barang}</strong> hanya tersedia <strong>{$stokTersedia}</strong>, tapi yang diminta <strong>{$detail->volume}</strong>.")
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }
                    }

                    // Lanjut jika semua stok cukup
                    \DB::transaction(function () {
                        $this->record->update(['status_id' => 3]);

                        foreach ($this->record->detail_pemakaian as $detail) {
                            $referensiId = $detail->referensi_id;
                            $jumlah = $detail->volume;
                            $userId = $this->record->user_id;

                            // Catat transaksi keluar (jika modelnya ada)
                            \App\Models\TransaksiKeluar::create([
                                'referensi_id' => $referensiId,
                                'volume' => $jumlah,
                                'user_id' => $userId,
                            ]);

                            // Kurangi stok berdasarkan FIFO dari tabel stok
                            $stokList = \App\Models\Stok::where('referensi_id', $referensiId)
                                ->where('volume', '>', 0)
                                ->orderBy('created_at')
                                ->get();

                            foreach ($stokList as $stok) {
                                if ($jumlah <= 0) break;

                                $pakai = min($stok->volume, $jumlah);
                                $stok->decrement('volume', $pakai);
                                $jumlah -= $pakai;
                            }
                        }
                    });

                Notification::make()
                    ->title('Disetujui')
                    ->body('Pengajuan disetujui dan stok berhasil dikurangi.')
                    ->success()
                    ->send();

                return redirect(\App\Filament\Resources\PemakaianResource::getUrl('index'));
            }),

            // Tolak hanya untuk user yang bukan pegawai
            Actions\Action::make('Tolak')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->requiresConfirmation()
                ->visible(fn () =>
                    auth()->user()?->role !== 'pegawai' &&
                    $this->record->status_id != 4
                )
                ->action(function () {
                    $this->record->update(['status_id' => 4]); // 4 = Ditolak
                    Notification::make()
                        ->title('Berhasil')
                        ->body('Pengajuan ditolak.')
                        ->danger()
                        ->send();

                    return redirect(PemakaianResource::getUrl('index'));
                }),
        
            ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
