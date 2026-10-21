<?php

namespace App\Livewire\Site;

use App\Models\Berita;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public', [
    'description' => "Berita, pengumuman, dan kegiatan terbaru Pondok Pesantren Syafa'aturrasul.",
])]
#[Title('Berita & Pengumuman - PPSR')]
class BeritaIndex extends Component
{
    use WithPagination;

    /**
     * Daftar berita yang sudah diterbitkan (9 per halaman).
     */
    public function render(): View
    {
        return view('livewire.site.berita-index', [
            'beritas' => Berita::published()
                ->latest('published_at')
                ->paginate(9),
        ]);
    }
}
