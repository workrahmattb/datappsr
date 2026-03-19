<?php

namespace App\Livewire\Admin;

use App\Models\Mtsputri;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MtsputrisTable extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $tahunAjaran = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'tahunAjaran' => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTahunAjaran(): void
    {
        $this->resetPage();
    }

    public function delete($id): void
    {
        if (confirm('Yakin ingin menghapus data siswi ini?')) {
            Mtsputri::destroy($id);
            $this->dispatch('success', 'Data siswi berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Mtsputri::latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nik', 'like', "%{$this->search}%");
            });
        }

        if ($this->tahunAjaran) {
            $query->where('tahun_ajaran', $this->tahunAjaran);
        }

        return view('livewire.admin.mtsputris-table', [
            'mtsputris' => $query->paginate(15),
            'tahunAjarans' => Mtsputri::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
