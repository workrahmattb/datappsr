<?php

namespace App\Livewire\Site;

use App\Models\Kontak;
use App\Models\Setting;
use App\Support\HtmlSanitizer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public', [
    'description' => "Informasi kontak resmi Pondok Pesantren Syafa'aturrasul — alamat, telepon, WhatsApp, dan email.",
])]
#[Title('Kontak - PPSR')]
class KontakIndex extends Component
{
    /**
     * Halaman kontak: informasi lembaga + daftar kontak person + peta.
     */
    public function render(): View
    {
        return view('livewire.site.kontak-index', [
            'kontaks' => Kontak::aktif()->get(),
            'lembaga' => [
                'alamat' => Setting::value('kontak_alamat'),
                'telepon' => Setting::value('kontak_telepon'),
                'whatsapp' => Setting::value('kontak_whatsapp'),
                'email' => Setting::value('kontak_email'),
                'jam' => Setting::value('kontak_jam_layanan'),
                // Hanya URL-nya yang diambil dari kode embed (anti XSS).
                'maps' => HtmlSanitizer::embedUrl(Setting::value('kontak_maps_embed')),
                'facebook' => Setting::value('kontak_facebook'),
                'instagram' => Setting::value('kontak_instagram'),
                'youtube' => Setting::value('kontak_youtube'),
            ],
        ]);
    }
}
