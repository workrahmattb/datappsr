<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mtsputri;
use Livewire\WithPagination;

class Guru extends Component
{
    use WithPagination;

    public $search = ''; // untuk fitur pencarian

    protected $paginationTheme = 'tailwind'; // pakai style Tailwind

    // Reset ke halaman 1 setiap kali search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $mtsputris = Mtsputri::query()
            ->where(function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
              ->orWhere('nisn', 'like', '%' . $this->search . '%')
              ->orWhere('nama_ayah', 'like', '%' . $this->search . '%');
    })
    ->orderBy('id', 'desc')
    ->paginate(10);

        return view('livewire.guru', [
            'mtsputris' => $mtsputris,
        ]);
    }
}
