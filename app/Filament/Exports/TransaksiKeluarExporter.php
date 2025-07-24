<?php

namespace App\Filament\Exports;

use App\Models\TransaksiKeluar;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransaksiKeluarExporter extends Exporter
{
    protected static ?string $model = TransaksiKeluar::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('No.'),
            ExportColumn::make('referensi.nama_barang')
                ->label('Nama Barang'),
            ExportColumn::make('referensi.satuan.nama_satuan')
                ->label('Satuan'),
            ExportColumn::make('volume')
                ->label('Volume'),
            ExportColumn::make('user.name')
                ->label('Nama'),
            ExportColumn::make('created_at')
                ->label('Tanggal')
                ->formatStateUsing(fn ($state) => $state->format('d M Y')),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transaksi keluar export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
