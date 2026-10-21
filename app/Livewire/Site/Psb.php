<?php

namespace App\Livewire\Site;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public', [
    'description' => "Pencarian data santri dan pendaftaran santri baru Pondok Pesantren Syafa'aturrasul.",
])]
#[Title('Cari Data & Pendaftaran Santri - PPSR 2026')]
class Psb extends Component
{
    /**
     * Halaman layanan PSB: pencarian data santri (komponen CariSiswaTable)
     * dan info bantuan.
     */
    public function render(): View
    {
        return view('livewire.site.psb');
    }
}
