<?php

namespace App\Livewire\Admin;

use App\Models\Maputri;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class MaputrisTable extends Component
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
            $maputri = Maputri::find($this->deleteId);

            if ($maputri) {
                // Delete associated files
                if ($maputri->fotokk) Storage::disk('public')->delete($maputri->fotokk);
                if ($maputri->fotoakta) Storage::disk('public')->delete($maputri->fotoakta);
                if ($maputri->fototransfer) Storage::disk('public')->delete($maputri->fototransfer);

                $maputri->delete();
                $this->dispatch('success', 'Data siswi berhasil dihapus.');
            }

            $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
            $this->deleteId = null;
            $this->deleteStudentName = '';
        }
    }

    public function render()
    {
        $query = Maputri::latest();

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

        return view('livewire.admin.maputris-table', [
            'maputris' => $query->paginate(15),
            'tahunAjarans' => Maputri::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
