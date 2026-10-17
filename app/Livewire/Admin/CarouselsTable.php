<?php

namespace App\Livewire\Admin;

use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layout')]
class CarouselsTable extends Component
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

    /**
     * Geser urutan slide satu langkah ke atas/bawah.
     */
    public function pindah(int $id, string $arah): void
    {
        $carousel = Carousel::find($id);

        if (! $carousel) {
            return;
        }

        $target = Carousel::query()
            ->when(
                $arah === 'naik',
                fn ($q) => $q->where('urutan', '<', $carousel->urutan)->orderByDesc('urutan'),
                fn ($q) => $q->where('urutan', '>', $carousel->urutan)->orderBy('urutan')
            )
            ->first();

        if (! $target) {
            return;
        }

        $urutanAsal = $carousel->urutan;
        $carousel->update(['urutan' => $target->urutan]);
        $target->update(['urutan' => $urutanAsal]);
    }

    public function confirmDelete(int $id): void
    {
        $carousel = Carousel::find($id);

        if (! $carousel) {
            return;
        }

        $this->deleteId = $carousel->id;
        $this->deleteItemName = (string) ($carousel->judul ?: 'Slide #'.$carousel->id);
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

        $carousel = Carousel::find($this->deleteId);

        if ($carousel) {
            if ($carousel->gambar) {
                Storage::disk('public')->delete($carousel->gambar);
            }

            $carousel->delete();
            $this->dispatch('success', 'Slide carousel berhasil dihapus.');
        }

        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function render()
    {
        $query = Carousel::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                    ->orWhere('deskripsi', 'like', "%{$this->search}%")
                    ->orWhere('link_text', 'like', "%{$this->search}%");
            });
        }

        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.carousels-table', [
            'carousels' => $query->orderBy('urutan')->orderBy('id')->paginate($perPage),
        ]);
    }
}
