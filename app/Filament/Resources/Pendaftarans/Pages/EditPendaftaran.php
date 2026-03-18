<?php


namespace App\Filament\Resources\Pendaftarans\Pages;

use App\Filament\Resources\Pendaftarans\PendaftaranResource;
use App\Models\Mtsputri;
use App\Models\Mtsputra;
use App\Models\Maputri;
use App\Models\Maputra;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPendaftaran extends EditRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->record->toArray();
        $jenjangPendidikan = $data['jenjang_pendidikan'] ?? null;

        if (!$jenjangPendidikan) {
            Notification::make()
                ->warning()
                ->title('Peringatan')
                ->body('Jenjang pendidikan belum dipilih. Data tidak disimpan ke tabel siswa.')
                ->send();
            return;
        }

        // Prepare data for student table (remove pendaftaran-specific fields)
        $studentData = collect($data)->except([
            'id',
            'created_at',
            'updated_at',
            'jenjang_pendidikan',
            'asal_sekolah', // legacy field
            'alamat', // legacy field
            'buktitransfer', // legacy field
        ])->toArray();

        // Map legacy fields if they exist and new fields are empty
        if (empty($studentData['nama_sekolah_sebelumnya']) && !empty($data['asal_sekolah'])) {
            $studentData['nama_sekolah_sebelumnya'] = $data['asal_sekolah'];
        }
        if (empty($studentData['fototransfer']) && !empty($data['buktitransfer'])) {
            $studentData['fototransfer'] = $data['buktitransfer'];
        }

        try {
            switch ($jenjangPendidikan) {
                case 'MTs Putri':
                    $existing = Mtsputri::where('nisn', $data['nisn'])->first();
                    if ($existing) {
                        $existing->update($studentData);
                        $message = 'Data berhasil diupdate di tabel MTs Putri';
                    } else {
                        Mtsputri::create($studentData);
                        $message = 'Data berhasil disimpan ke tabel MTs Putri';
                    }
                    break;

                case 'MTs Putra':
                    $existing = Mtsputra::where('nisn', $data['nisn'])->first();
                    if ($existing) {
                        $existing->update($studentData);
                        $message = 'Data berhasil diupdate di tabel MTs Putra';
                    } else {
                        Mtsputra::create($studentData);
                        $message = 'Data berhasil disimpan ke tabel MTs Putra';
                    }
                    break;

                case 'MA Putri':
                    $existing = Maputri::where('nisn', $data['nisn'])->first();
                    if ($existing) {
                        $existing->update($studentData);
                        $message = 'Data berhasil diupdate di tabel MA Putri';
                    } else {
                        Maputri::create($studentData);
                        $message = 'Data berhasil disimpan ke tabel MA Putri';
                    }
                    break;

                case 'MA Putra':
                    $existing = Maputra::where('nisn', $data['nisn'])->first();
                    if ($existing) {
                        $existing->update($studentData);
                        $message = 'Data berhasil diupdate di tabel MA Putra';
                    } else {
                        Maputra::create($studentData);
                        $message = 'Data berhasil disimpan ke tabel MA Putra';
                    }
                    break;

                default:
                    Notification::make()
                        ->warning()
                        ->title('Peringatan')
                        ->body('Jenjang pendidikan tidak valid: ' . $jenjangPendidikan)
                        ->send();
                    return;
            }

            Notification::make()
                ->success()
                ->title('Berhasil')
                ->body($message)
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Gagal menyimpan data: ' . $e->getMessage())
                ->send();
        }
    }
}
