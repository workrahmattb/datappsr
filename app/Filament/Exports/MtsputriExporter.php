<?php

namespace App\Filament\Exports;

use App\Models\Mtsputri;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MtsputriExporter extends Exporter
{
    protected static ?string $model = Mtsputri::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('nik'),
            ExportColumn::make('kk'),
            ExportColumn::make('nama_kk'),
            ExportColumn::make('nisn'),
            ExportColumn::make('nis'),
            ExportColumn::make('anak_ke'),
            ExportColumn::make('jumlah_saudara'),
            ExportColumn::make('tahun_ajaran'),
            ExportColumn::make('tgl_masuk'),
            ExportColumn::make('kks'),
            ExportColumn::make('pkh'),
            ExportColumn::make('kip'),
            ExportColumn::make('jenjang_pendidikan_sebelumnya'),
            ExportColumn::make('status_sekolah_sebelumnya'),
            ExportColumn::make('nama_sekolah_sebelumnya'),
            ExportColumn::make('npsn_sekolah_sebelumnya'),
            ExportColumn::make('alamat_sekolah_sebelumnya'),
            ExportColumn::make('kecamatan_sekolah_sebelumnya'),
            ExportColumn::make('kabupaten_sekolah_sebelumnya'),
            ExportColumn::make('provinsi_sekolah_sebelumnya'),
            ExportColumn::make('nik_ayah'),
            ExportColumn::make('nama_ayah'),
            ExportColumn::make('tempat_lahir_ayah'),
            ExportColumn::make('tanggal_lahir_ayah'),
            ExportColumn::make('status_ayah'),
            ExportColumn::make('no_hp_ayah'),
            ExportColumn::make('pendidikan_ayah'),
            ExportColumn::make('pekerjaan_ayah'),
            ExportColumn::make('penghasilan_ayah'),
            ExportColumn::make('nik_ibu'),
            ExportColumn::make('nama_ibu'),
            ExportColumn::make('tempat_lahir_ibu'),
            ExportColumn::make('tanggal_lahir_ibu'),
            ExportColumn::make('status_ibu'),
            ExportColumn::make('no_hp_ibu'),
            ExportColumn::make('pendidikan_ibu'),
            ExportColumn::make('pekerjaan_ibu'),
            ExportColumn::make('penghasilan_ibu'),
            ExportColumn::make('status_milik'),
            ExportColumn::make('alamat_rumah_tinggal'),
            ExportColumn::make('rt'),
            ExportColumn::make('rw'),
            ExportColumn::make('desa'),
            ExportColumn::make('kecamatan'),
            ExportColumn::make('kabupaten'),
            ExportColumn::make('provinsi'),
            ExportColumn::make('kode_pos'),
            ExportColumn::make('nik_wali'),
            ExportColumn::make('nama_wali'),
            ExportColumn::make('tempat_lahir_wali'),
            ExportColumn::make('tanggal_lahir_wali'),
            ExportColumn::make('no_hp_wali'),
            ExportColumn::make('pendidikan_wali'),
            ExportColumn::make('pekerjaan_wali'),
            ExportColumn::make('penghasilan_wali'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your mtsputri export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
