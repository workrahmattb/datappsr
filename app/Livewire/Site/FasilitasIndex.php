<?php

namespace App\Livewire\Site;

use App\Models\Fasilitas;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public', [
    'description' => "Sarana dan prasarana Pondok Pesantren Syafa'aturrasul.",
])]
#[Title('Fasilitas - PPSR')]
class FasilitasIndex extends Component
{
    use WithPagination;

    /**
     * Daftar fasilitas aktif beserta galeri fotonya (9 per halaman).
     */
    public function render(): View
    {
        return view('livewire.site.fasilitas-index', [
            'fasilitasList' => Fasilitas::aktif()
                ->with('fotos')
                ->paginate(9)->withPath(route('fasilitas.index')),
        ]);
    }
}
