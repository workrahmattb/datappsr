<?php

namespace App\Livewire;

use App\Models\Maputra;
use App\Models\Maputri;
use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Pendaftaran;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class CariSiswaTable extends Component
{
    use WithPagination;

    /**
     * Minimum characters required before a search is executed.
     * Prevents the heavy 5-table lookup from running on every keystroke.
     */
    public const MIN_SEARCH_LENGTH = 3;

    /**
     * Number of results shown per page.
     */
    public const PER_PAGE = 10;

    public $search = '';

    public $tahunAjaran = '';

    public function boot()
    {
        // Set tahun ajaran from settings
        $this->tahunAjaran = activeTahunAjaran();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Whether the current keyword is long enough to run the search.
     */
    public function hasValidSearchTerm(): bool
    {
        return strlen($this->searchKeyword()) >= self::MIN_SEARCH_LENGTH;
    }

    /**
     * The search keyword without leading/trailing whitespace.
     */
    public function searchKeyword(): string
    {
        return trim((string) $this->search);
    }

    public function render()
    {
        $students = collect();

        if ($this->hasValidSearchTerm()) {
            $keyword = $this->searchKeyword();

            // Cari di tabel siswa (mtsputras, mtsputris, maputras, maputris)
            $models = [Mtsputra::class, Mtsputri::class, Maputra::class, Maputri::class];

            foreach ($models as $model) {
                $results = $model::where('tahun_ajaran', $this->tahunAjaran)
                    ->where(function ($q) use ($keyword) {
                        $q->where('nama', 'like', '%'.$keyword.'%')
                            ->orWhere('nisn', 'like', '%'.$keyword.'%')
                            ->orWhere('nik', 'like', '%'.$keyword.'%');
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
                ->where(function ($q) use ($keyword) {
                    $q->where('nama', 'like', '%'.$keyword.'%')
                        ->orWhere('nisn', 'like', '%'.$keyword.'%')
                        ->orWhere('nik', 'like', '%'.$keyword.'%');
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

        // Manual pagination — hasil digabung dari 4 tabel siswa + tabel pendaftaran
        $currentPage = $this->getPage();

        $paginator = new LengthAwarePaginator(
            $students->forPage($currentPage, self::PER_PAGE)->values(),
            $students->count(),
            self::PER_PAGE,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.cari-siswa-table', [
            'daftarUlangDibuka' => \App\Support\AdmissionPeriod::reregistrationOpen(),
            'students' => $paginator,
            'minSearchLength' => self::MIN_SEARCH_LENGTH,
        ]);
    }
}
