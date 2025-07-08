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
                    // Validasi stok terlebih dahulu (tanpa DB::transaction)
                    foreach ($this->record->detail_pemakaian as $detail) {
                        $barang = $detail->barang;

                        if ($barang->stok < $detail->jumlah) {
                            Notification::make()
                                ->title('Stok Tidak Cukup')
                                ->body("Stok untuk barang <strong>{$barang->nama_barang}</strong> hanya tersedia <strong>{$barang->stok}</strong>, tapi yang diminta <strong>{$detail->jumlah}</strong>.")
                                ->danger()
                                ->persistent()
                                ->send();

                            return; // hentikan action tanpa lanjut
                        }
                    }

                    // Semua stok cukup, lakukan transaksi
                    \DB::transaction(function () {
                        $this->record->update(['status_id' => 3]);

                        foreach ($this->record->detail_pemakaian as $detail) {
                            \App\Models\TransaksiKeluar::create([
                                'barang_id' => $detail->barang_id,
                                'satuan_id' => $detail->satuan_id,
                                'jumlah' => $detail->jumlah,
                                'user_id' => $this->record->user_id,
                            ]);

                            $detail->barang->decrement('stok', $detail->jumlah);
                        }
                    });

                    Notification::make()
                        ->title('Disetujui')
                        ->body('Pengajuan disetujui dan stok barang berhasil dikurangi.')
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
