<?php

namespace App\Filament\Exports;

use App\Models\Pendaftaran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PendaftaranExporter extends Exporter
{
    protected static ?string $model = Pendaftaran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nisn'),
            ExportColumn::make('nama'),
            ExportColumn::make('tahun_ajaran'),
            ExportColumn::make('jenjang_pendidikan'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('asal_sekolah'),
            ExportColumn::make('alamat'),
            ExportColumn::make('nama_ayah'),
            ExportColumn::make('nama_ibu'),
            ExportColumn::make('no_hp'),
            ExportColumn::make('buktitransfer'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data pendaftaran telah selesai dan ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil di-export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal di-export.';
        }

        return $body;
    }
}
