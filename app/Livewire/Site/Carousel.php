<?php

namespace App\Livewire\Site;

use App\Models\Carousel as CarouselModel;
use Illuminate\View\View;
use Livewire\Component;

class Carousel extends Component
{
    /**
     * Data slide (array primitif, bukan model) agar setiap re-render polling
     * tidak memicu query ulang ke database.
     *
     * @var list<array{gambar: string, judul: ?string, deskripsi: ?string, link_url: ?string, link_text: ?string}>
     */
    public array $slides = [];

    /**
     * Indeks slide yang sedang tampil.
     */
    public int $aktif = 0;

    public function mount(): void
    {
        $this->slides = CarouselModel::aktif()
            ->take(5)
            ->get()
            ->map(fn (CarouselModel $slide): array => [
                'gambar' => (string) $slide->gambar,
                'judul' => $slide->judul,
                'deskripsi' => $slide->deskripsi,
                'link_url' => $slide->link_url,
                'link_text' => $slide->link_text,
            ])
            ->all();
    }

    public function jumlahSlide(): int
    {
        return count($this->slides);
    }

    /**
     * Apakah slide punya teks/tombol untuk ditampilkan pada kartu sorotan.
     *
     * @param  array{gambar: string, judul: ?string, deskripsi: ?string, link_url: ?string, link_text: ?string}  $slide
     */
    public function adaTeks(array $slide): bool
    {
        return filled($slide['judul'])
            || filled($slide['deskripsi'])
            || (filled($slide['link_url']) && filled($slide['link_text']));
    }

    /**
     * Geser ke slide berikutnya (dipakai tombol & auto-rotate `wire:poll`).
     */
    public function berikut(): void
    {
        if ($this->jumlahSlide() > 1) {
            $this->aktif = ($this->aktif + 1) % $this->jumlahSlide();
        }
    }

    /**
     * Geser ke slide sebelumnya.
     */
    public function sebelumnya(): void
    {
        if ($this->jumlahSlide() > 1) {
            $this->aktif = ($this->aktif - 1 + $this->jumlahSlide()) % $this->jumlahSlide();
        }
    }

    /**
     * Lompat ke slide tertentu (dipakai titik indikator).
     */
    public function keSlide(int $index): void
    {
        if ($index >= 0 && $index < $this->jumlahSlide()) {
            $this->aktif = $index;
        }
    }

    public function render(): View
    {
        return view('livewire.site.carousel');
    }
}
