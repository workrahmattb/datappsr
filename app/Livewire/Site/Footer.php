<?php

namespace App\Livewire\Site;

use App\Models\Setting;
use Illuminate\View\View;
use Livewire\Component;

class Footer extends Component
{
    /**
     * Menu tautan utama (dipakai navbar & footer).
     *
     * @var list<array{label: string, route: string}>
     */
    public array $menu = [
        ['label' => 'Berita', 'route' => 'berita.index'],
        ['label' => 'Fasilitas', 'route' => 'fasilitas.index'],
        ['label' => 'Guru', 'route' => 'guru.index'],
        ['label' => 'Kontak', 'route' => 'kontak.index'],
    ];

    public ?string $alamat = null;

    public ?string $telepon = null;

    public ?string $whatsapp = null;

    public ?string $email = null;

    public function mount(): void
    {
        $this->alamat = Setting::value('kontak_alamat');
        $this->telepon = Setting::value('kontak_telepon');
        $this->whatsapp = Setting::value('kontak_whatsapp');
        $this->email = Setting::value('kontak_email');
    }

    public function render(): View
    {
        return view('livewire.site.footer');
    }
}
