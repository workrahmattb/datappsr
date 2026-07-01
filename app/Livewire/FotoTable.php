<?php

namespace App\Livewire;

use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.standalone')]
class FotoTable extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $jenjang = null;
    public string $tahunAjaran = '2026/2027';

    protected $queryString = [
        'search' => ['except' => ''],
        'jenjang' => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingJenjang(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = collect();

        $models = [
            ['class' => Mtsputra::class, 'label' => 'MTs Putra'],
            ['class' => Mtsputri::class, 'label' => 'MTs Putri'],
            ['class' => Maputra::class, 'label' => 'MA Putra'],
            ['class' => Maputri::class, 'label' => 'MA Putri'],
        ];

        foreach ($models as $model) {
            $query = $model['class']::where('tahun_ajaran', $this->tahunAjaran);

            if ($this->jenjang) {
                if ($model['label'] !== $this->jenjang) {
                    continue;
                }
            }

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nisn', 'like', '%' . $this->search . '%');
                });
            }

            $results = $query->get()->map(function ($item) use ($model) {
                $item->jenjang_label = $model['label'];
                $item->alamat_lengkap = $item->alamat_rumah_tinggal
                    ?? collect([$item->desa, $item->kecamatan, $item->kabupaten, $item->provinsi])
                        ->filter()->implode(', ')
                    ?? '-';
                return $item;
            });

            $students = $students->concat($results);
        }

        // Sort by nama
        $students = $students->sortBy('nama')->values();

        // Manual pagination
        $currentPage = $this->getPage();
        $perPage = 15;
        $total = $students->count();
        $items = $students->forPage($currentPage, $perPage);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.foto-table', [
            'students' => $paginator,
        ]);
    }
}
