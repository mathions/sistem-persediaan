<?php

namespace App\Filament\Exports;

use App\Models\TransaksiMasuk;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransaksiMasukExporter extends Exporter
{
    protected static ?string $model = TransaksiMasuk::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('No.'),
            ExportColumn::make('referensi.nama_barang')
                ->label('Nama Barang'),
            ExportColumn::make('referensi.satuan.nama_satuan')
                ->label('Satuan'),
            ExportColumn::make('harga_beli')
                ->label('Harga Beli'),
            ExportColumn::make('volume')
                ->label('Volume'),
            ExportColumn::make('total')
                ->label('Total'),
            ExportColumn::make('keterangan')
                ->label('Keterangan'),
            ExportColumn::make('created_at')
                ->label('Tanggal')
                ->formatStateUsing(fn ($state) => $state->format('d M Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transaksi masuk export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
