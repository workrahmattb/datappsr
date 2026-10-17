<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuruRequest;
use App\Models\Guru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuruController extends Controller
{
    /**
     * Directory on the public disk where teacher photos are stored.
     */
    private const FOTO_DIRECTORY = 'konten/guru';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $gurus = Guru::orderBy('urutan')->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.gurus.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.gurus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuruRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store(self::FOTO_DIRECTORY, 'public');
        }

        Guru::create($validated);

        return redirect()
            ->route('admin.gurus.index')
            ->with('success', 'Profil guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru): View
    {
        return view('admin.gurus.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru): View
    {
        return view('admin.gurus.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuruRequest $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            $validated['foto'] = $request->file('foto')->store(self::FOTO_DIRECTORY, 'public');
        }

        $guru->update($validated);

        return redirect()
            ->route('admin.gurus.index')
            ->with('success', 'Profil guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()
            ->route('admin.gurus.index')
            ->with('success', 'Profil guru berhasil dihapus.');
    }
}
