<?php

namespace App\Livewire\Admin;

use App\Models\Guru;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class GurusTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $jenisKelamin = null;

    public int $perPage = 15;

    public $deleteId = null;

    public string $deleteItemName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'jenisKelamin' => ['except' => null],
        'perPage' => ['except' => 15],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingJenisKelamin(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $guru = Guru::find($id);

        if (! $guru) {
            return;
        }

        $this->deleteId = $guru->id;
        $this->deleteItemName = (string) $guru->name;
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

        $guru = Guru::find($this->deleteId);

        if ($guru) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            $guru->delete();
            $this->dispatch('success', 'Profil guru berhasil dihapus.');
        }

        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function render()
    {
        $query = Guru::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('nip', 'like', "%{$this->search}%")
                    ->orWhere('jabatan', 'like', "%{$this->search}%");
            });
        }

        if ($this->jenisKelamin) {
            $query->where('jenis_kelamin', $this->jenisKelamin);
        }

        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.gurus-table', [
            'gurus' => $query->orderBy('urutan')->orderBy('name')->paginate($perPage),
        ]);
    }
}
