<?php

namespace App\Livewire\Site;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class BeritaShow extends Component
{
    public Berita $berita;

    /**
     * Detail berita berdasarkan slug. Hanya berita terbit yang bisa dibuka.
     */
    public function mount(string $slug): void
    {
        $this->berita = Berita::published()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.site.berita-show', [
            'lainnya' => Berita::published()
                ->whereKeyNot($this->berita->id)
                ->latest('published_at')
                ->take(3)
                ->get(),
        ])
            ->layout('layouts.public', [
                'description' => Str::limit($this->berita->ringkasan_singkat, 155),
                'article' => $this->berita,
            ])
            ->title($this->berita->judul.' - Berita PPSR');
    }
}
