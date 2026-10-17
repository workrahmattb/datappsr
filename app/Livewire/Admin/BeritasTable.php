<?php

namespace App\Livewire\Admin;

use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class BeritasTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $status = null;

    public ?string $kategori = null;

    public int $perPage = 15;

    public $deleteId = null;

    public string $deleteItemName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => null],
        'kategori' => ['except' => null],
        'perPage' => ['except' => 15],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
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
        $berita = Berita::find($id);

        if (! $berita) {
            return;
        }

        $this->deleteId = $berita->id;
        $this->deleteItemName = (string) $berita->judul;
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

        $berita = Berita::find($this->deleteId);

        if ($berita) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $berita->delete();
            $this->dispatch('success', 'Berita berhasil dihapus.');
        }

        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function render()
    {
        $query = Berita::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                    ->orWhere('ringkasan', 'like', "%{$this->search}%")
                    ->orWhere('penulis', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }

        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.beritas-table', [
            'beritas' => $query->latest()->paginate($perPage),
            'kategoris' => Berita::query()
                ->whereNotNull('kategori')
                ->where('kategori', '!=', '')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori'),
        ]);
    }
}
