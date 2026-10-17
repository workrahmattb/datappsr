<?php

namespace App\Livewire\Admin;

use App\Models\Kontak;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class KontaksTable extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 15;

    public $deleteId = null;

    public string $deleteItemName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 15],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $kontak = Kontak::find($id);

        if (! $kontak) {
            return;
        }

        $this->deleteId = $kontak->id;
        $this->deleteItemName = (string) $kontak->nama;
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

        $kontak = Kontak::find($this->deleteId);

        if ($kontak) {
            $kontak->delete();
            $this->dispatch('success', 'Kontak berhasil dihapus.');
        }

        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function render()
    {
        $query = Kontak::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                    ->orWhere('unit', 'like', "%{$this->search}%")
                    ->orWhere('jabatan', 'like', "%{$this->search}%")
                    ->orWhere('telepon', 'like', "%{$this->search}%")
                    ->orWhere('whatsapp', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.kontaks-table', [
            'kontaks' => $query->orderBy('urutan')->orderBy('nama')->paginate($perPage),
        ]);
    }
}
