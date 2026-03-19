<?php

namespace App\Livewire\Admin;

use App\Models\Mtsputri;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MtsputrisTable extends Component
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
            $mtsputri = Mtsputri::find($this->deleteId);

            if ($mtsputri) {
                // Delete associated files
                if ($mtsputri->fotokk) Storage::disk('public')->delete($mtsputri->fotokk);
                if ($mtsputri->fotoakta) Storage::disk('public')->delete($mtsputri->fotoakta);
                if ($mtsputri->fototransfer) Storage::disk('public')->delete($mtsputri->fototransfer);

                $mtsputri->delete();
                $this->dispatch('success', 'Data siswi berhasil dihapus.');
            }

            $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
            $this->deleteId = null;
            $this->deleteStudentName = '';
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
