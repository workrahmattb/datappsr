<?php

namespace App\Livewire\Site;

use App\Models\Guru;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public', [
    'description' => "Ustadz dan ustadzah pengajar Pondok Pesantren Syafa'aturrasul.",
])]
#[Title('Profil Guru - PPSR')]
class GuruIndex extends Component
{
    use WithPagination;

    /**
     * Daftar profil guru aktif (12 per halaman).
     */
    public function render(): View
    {
        return view('livewire.site.guru-index', [
            'gurus' => Guru::aktif()->paginate(12)->withPath(route('guru.index')),
        ]);
    }
}
