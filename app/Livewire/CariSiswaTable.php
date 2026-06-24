<?php

namespace App\Livewire;

use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;
use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\WithPagination;

class CariSiswaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $tahunAjaran = '2026/2027';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = collect();

        if (strlen($this->search) > 0) {
            // Cari di tabel siswa (mtsputras, mtsputris, maputras, maputris)
            $models = [Mtsputra::class, Mtsputri::class, Maputra::class, Maputri::class];

            foreach ($models as $model) {
                $results = $model::where('tahun_ajaran', $this->tahunAjaran)
                    ->where(function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%')
                            ->orWhere('nisn', 'like', '%' . $this->search . '%')
                            ->orWhere('nik', 'like', '%' . $this->search . '%');
                    })
                    ->get()
                    ->map(function ($item) use ($model) {
                        $item->student_type = class_basename($model);
                        $item->is_pendaftaran = false;
                        return $item;
                    });

                $students = $students->concat($results);
            }

            // Cari juga di tabel Pendaftaran yang masih pending
            $pendaftarans = Pendaftaran::where('tahun_ajaran', $this->tahunAjaran)
                ->where('status_pendaftaran', 'pending')
                ->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nisn', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%');
                })
                ->get()
                ->map(function ($item) {
                    $item->student_type = 'Pendaftaran';
                    $item->is_pendaftaran = true;
                    return $item;
                });

            $students = $students->concat($pendaftarans);

            // Sort by nama
            $students = $students->sortBy('nama')->values();
        }

        return view('livewire.cari-siswa-table', [
            'students' => $students
        ]);
    }
}
