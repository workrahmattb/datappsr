<?php

namespace App\Livewire\Site;

use Illuminate\View\View;
use Livewire\Component;

class Navbar extends Component
{
    /**
     * Menu utama website sekolah.
     *
     * @var list<array{label: string, route: string}>
     */
    public array $menu = [
        ['label' => 'Berita', 'route' => 'berita.index'],
        ['label' => 'Fasilitas', 'route' => 'fasilitas.index'],
        ['label' => 'Guru', 'route' => 'guru.index'],
        ['label' => 'Kontak', 'route' => 'kontak.index'],
    ];

    /**
     * Menu mobile sedang terbuka — state disimpan di server (Livewire), bukan Alpine.
     */
    public bool $menuTerbuka = false;

    /**
     * Nama route halaman yang sedang dibuka. Diambil sekali saat mount agar
     * sorotan menu tetap benar walau komponen dirender ulang oleh aksi Livewire.
     */
    public string $routeAktif = '';

    public function mount(): void
    {
        $this->routeAktif = (string) request()->route()?->getName();
    }

    /**
     * Buka/tutup menu mobile.
     */
    public function toggleMenu(): void
    {
        $this->menuTerbuka = ! $this->menuTerbuka;
    }

    /**
     * Apakah menu dengan route tersebut (atau halaman turunannya) sedang aktif.
     */
    public function apakahAktif(string $route): bool
    {
        return $this->routeAktif === $route
            || str_starts_with($this->routeAktif, explode('.', $route)[0].'.');
    }

    public function render(): View
    {
        return view('livewire.site.navbar');
    }
}
