<?php

namespace App\Livewire\Admin;

use App\Models\Fasilitas;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class FasilitasTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $kategori = null;

    public int $perPage = 15;

    public $deleteId = null;

    public string $deleteItemName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'kategori' => ['except' => null],
        'perPage' => ['except' => 15],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingKategori(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $fasilitas = Fasilitas::find($id);

        if (! $fasilitas) {
            return;
        }

        $this->deleteId = $fasilitas->id;
        $this->deleteItemName = (string) $fasilitas->nama;
        $this->dispatch('modal-show', ...['name' => 'delete-confirm']);
    }

    public function closeModal(): void
    {
        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function deleteConfirmed(): void
    {
        if (! $this->deleteId) {
            return;
        }

        $fasilitas = Fasilitas::find($this->deleteId);

        if ($fasilitas) {
            foreach ($fasilitas->fotos as $foto) {
                Storage::disk('public')->delete($foto->path);
            }

            $fasilitas->fotos()->delete();

            if ($fasilitas->gambar) {
                Storage::disk('public')->delete($fasilitas->gambar);
            }

            $fasilitas->delete();
            $this->dispatch('success', 'Fasilitas berhasil dihapus.');
        }

        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function render()
    {
        $query = Fasilitas::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                    ->orWhere('deskripsi', 'like', "%{$this->search}%");
            });
        }

        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }

        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.fasilitas-table', [
            'fasilitasList' => $query->orderBy('urutan')->orderBy('nama')->paginate($perPage),
            'kategoris' => Fasilitas::query()
                ->whereNotNull('kategori')
                ->where('kategori', '!=', '')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori'),
        ]);
    }
}
