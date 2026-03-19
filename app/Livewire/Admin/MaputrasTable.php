<?php

namespace App\Livewire\Admin;

use App\Models\Maputra;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MaputrasTable extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $tahunAjaran = null;
    public $deleteId = null;
    public string $deleteStudentName = '';

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

    public function confirmDelete($id, $name): void
    {
        $this->deleteId = $id;
        $this->deleteStudentName = $name;
        $this->dispatch('modal-show', ...['name' => 'delete-confirm']);
    }

    public function closeModal(): void
    {
        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteStudentName = '';
    }

    public function deleteConfirmed(): void
    {
        if ($this->deleteId) {
            $maputra = Maputra::find($this->deleteId);

            if ($maputra) {
                // Delete associated files
                if ($maputra->fotokk) Storage::disk('public')->delete($maputra->fotokk);
                if ($maputra->fotoakta) Storage::disk('public')->delete($maputra->fotoakta);
                if ($maputra->fototransfer) Storage::disk('public')->delete($maputra->fototransfer);

                $maputra->delete();
                $this->dispatch('success', 'Data siswa berhasil dihapus.');
            }

            $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
            $this->deleteId = null;
            $this->deleteStudentName = '';
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
