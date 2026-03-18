<?php

namespace App\Livewire;

use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarUlangTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pendaftarans = Pendaftaran::where('tahun_ajaran', '2026/2027')
            ->where('status_pendaftaran', 'pending')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nisn', 'like', '%' . $this->search . '%')
                        ->orWhere('tempat_lahir', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.daftar-ulang-table', [
            'pendaftarans' => $pendaftarans
        ]);
    }
}
