<?php

namespace App\Livewire\Admin;

use App\Models\Maputra;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MaputrasTable extends Component
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
        if (confirm('Yakin ingin menghapus data siswa ini?')) {
            Maputra::destroy($id);
            $this->dispatch('success', 'Data siswa berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Maputra::latest();

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

        return view('livewire.admin.maputras-table', [
            'maputras' => $query->paginate(15),
            'tahunAjarans' => Maputra::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
