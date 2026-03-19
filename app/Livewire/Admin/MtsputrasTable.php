<?php

namespace App\Livewire\Admin;

use App\Models\Mtsputra;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MtsputrasTable extends Component
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
            $mtsputra = Mtsputra::find($this->deleteId);
            
            if ($mtsputra) {
                // Delete associated files
                if ($mtsputra->fotokk) Storage::disk('public')->delete($mtsputra->fotokk);
                if ($mtsputra->fotoakta) Storage::disk('public')->delete($mtsputra->fotoakta);
                if ($mtsputra->fototransfer) Storage::disk('public')->delete($mtsputra->fototransfer);
                
                $mtsputra->delete();
                $this->dispatch('success', 'Data siswa berhasil dihapus.');
            }
            
            $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
            $this->deleteId = null;
            $this->deleteStudentName = '';
        }
    }

    public function render()
    {
        $query = Mtsputra::latest();

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

        return view('livewire.admin.mtsputras-table', [
            'mtsputras' => $query->paginate(15),
            'tahunAjarans' => Mtsputra::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
