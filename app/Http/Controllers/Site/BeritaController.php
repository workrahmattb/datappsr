<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /**
     * Daftar berita yang sudah diterbitkan.
     */
    public function index(): View
    {
        $beritas = Berita::published()
            ->latest('published_at')
            ->paginate(9);

        return view('site.berita.index', compact('beritas'));
    }

    /**
     * Detail berita berdasarkan slug.
     */
    public function show(string $slug): View
    {
        $berita = Berita::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $lainnya = Berita::published()
            ->whereKeyNot($berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('site.berita.show', compact('berita', 'lainnya'));
    }
}
