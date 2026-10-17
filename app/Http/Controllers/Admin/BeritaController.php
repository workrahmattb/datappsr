<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\Berita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /**
     * Directory on the public disk where news images are stored.
     */
    private const GAMBAR_DIRECTORY = 'konten/berita';

    /**
     * Directory for images embedded inside the article body.
     */
    private const ISI_GAMBAR_DIRECTORY = 'konten/berita/isi';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $beritas = Berita::latest()->paginate(15)->withQueryString();

        return view('admin.beritas.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.beritas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BeritaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store(self::GAMBAR_DIRECTORY, 'public');
        }

        Berita::create($validated);

        return redirect()
            ->route('admin.beritas.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita): View
    {
        return view('admin.beritas.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita): View
    {
        return view('admin.beritas.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BeritaRequest $request, Berita $berita): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store(self::GAMBAR_DIRECTORY, 'public');
        }

        $berita->update($validated);

        return redirect()
            ->route('admin.beritas.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Upload an inline image used inside the article body (rich text editor).
     */
    public function uploadGambar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gambar.required' => 'Gambar wajib dipilih.',
            'gambar.image' => 'Berkas harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
        ]);

        $path = $validated['gambar']->store(self::ISI_GAMBAR_DIRECTORY, 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita): RedirectResponse
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()
            ->route('admin.beritas.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
