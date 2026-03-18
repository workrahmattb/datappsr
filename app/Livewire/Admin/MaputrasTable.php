<?php

namespace App\Livewire\Admin;

use App\Models\Maputra;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MaputrasTable extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $kelasId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'kelasId' => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingKelasId(): void
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
        $query = Maputra::with('kelas')->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nik', 'like', "%{$this->search}%");
            });
        }

        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }

        return view('livewire.admin.maputras-table', [
            'maputras' => $query->paginate(15),
            'kelas' => Kelas::all(),
        ]);
    }
}
