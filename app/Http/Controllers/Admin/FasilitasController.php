<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FasilitasRequest;
use App\Models\Fasilitas;
use App\Models\FasilitasFoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    /**
     * Directory on the public disk where facility photos are stored.
     */
    private const FOTO_DIRECTORY = 'konten/fasilitas';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $fasilitas = Fasilitas::withCount('fotos')->orderBy('urutan')->paginate(15)->withQueryString();

        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FasilitasRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $fasilitas = Fasilitas::create([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => $validated['urutan'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'gambar' => null,
        ]);

        $this->simpanFotos($fasilitas, $request->file('fotos') ?? []);
        $fasilitas->syncGambarUtama();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fasilitas $fasilitas): View
    {
        $fasilitas->load('fotos');

        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fasilitas $fasilitas): View
    {
        $fasilitas->load('fotos');

        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FasilitasRequest $request, Fasilitas $fasilitas): RedirectResponse
    {
        $validated = $request->validated();

        $fasilitas->update([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => $validated['urutan'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->simpanFotos($fasilitas, $request->file('fotos') ?? []);
        $fasilitas->syncGambarUtama();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove a single photo from the gallery.
     */
    public function destroyFoto(Fasilitas $fasilitas, FasilitasFoto $foto): RedirectResponse
    {
        abort_unless($foto->fasilitas_id === $fasilitas->id, 404);

        Storage::disk('public')->delete($foto->path);
        $foto->delete();
        $fasilitas->syncGambarUtama();

        return redirect()
            ->route('admin.fasilitas.edit', $fasilitas)
            ->with('success', 'Foto fasilitas berhasil dihapus.');
    }

    /**
     * Remove the specified resource from storage (beserta semua fotonya).
     */
    public function destroy(Fasilitas $fasilitas): RedirectResponse
    {
        foreach ($fasilitas->fotos as $foto) {
            Storage::disk('public')->delete($foto->path);
        }

        $fasilitas->fotos()->delete();
        $fasilitas->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }

    /**
     * Simpan berkas foto yang diunggah ke galeri fasilitas.
     *
     * @param  array<int, \Illuminate\Http\UploadedFile>  $files
     */
    private function simpanFotos(Fasilitas $fasilitas, array $files): void
    {
        $urutan = (int) $fasilitas->fotos()->max('urutan');

        foreach ($files as $file) {
            $fasilitas->fotos()->create([
                'path' => $file->store(self::FOTO_DIRECTORY, 'public'),
                'urutan' => ++$urutan,
            ]);
        }
    }
}
