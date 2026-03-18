<?php

namespace App\Filament\Imports;

use App\Models\Pendaftaran;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PendaftaranImporter extends Importer
{
    protected static ?string $model = Pendaftaran::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nisn')
                ->label('NISN')
                ->guess(['NISN'])
                ->rules(['nullable', 'string', 'max:10']),
            
            ImportColumn::make('nama')
                ->label('Nama Lengkap')
                ->guess(['Nama Lengkap', 'nama'])
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),
            
            ImportColumn::make('jenjang_pendidikan')
                ->label('Jenjang Pendidikan')
                ->guess(['Jenjang Pendidikan', 'jenjang'])
                ->rules(['nullable', 'string', 'max:50']),
            
            ImportColumn::make('tempat_lahir')
                ->label('Tempat Lahir')
                ->guess(['Tempat Lahir', 'tempat lahir'])
                ->rules(['nullable', 'string', 'max:255']),
            
            ImportColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir (YYYY-MM-DD)')
                ->guess(['Tanggal Lahir (YYYY-MM-DD)', 'Tanggal Lahir', 'tanggal lahir'])
                ->rules(['nullable', 'date']),
            
            ImportColumn::make('asal_sekolah')
                ->label('Asal Sekolah')
                ->guess(['Asal Sekolah', 'asal sekolah'])
                ->rules(['nullable', 'string', 'max:255']),
            
            ImportColumn::make('alamat')
                ->label('Alamat')
                ->guess(['Alamat'])
                ->rules(['nullable', 'string']),
            
            ImportColumn::make('nama_ayah')
                ->label('Nama Ayah')
                ->guess(['Nama Ayah', 'nama ayah'])
                ->rules(['nullable', 'string', 'max:255']),
            
            ImportColumn::make('nama_ibu')
                ->label('Nama Ibu')
                ->guess(['Nama Ibu', 'nama ibu'])
                ->rules(['nullable', 'string', 'max:255']),
            
            ImportColumn::make('no_hp')
                ->label('No HP')
                ->guess(['No HP', 'no hp', 'HP'])
                ->rules(['nullable', 'string', 'max:20']),
        ];
    }

    public function resolveRecord(): ?Pendaftaran
    {
        // Cari berdasarkan NISN jika ada, atau buat baru
        if (!empty($this->data['nisn'])) {
            return Pendaftaran::firstOrNew([
                'nisn' => $this->data['nisn'],
            ]);
        }

        return new Pendaftaran();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data pendaftaran selesai. ' . number_format($import->successful_rows) . ' baris berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimport.';
        }

        return $body;
    }
}
