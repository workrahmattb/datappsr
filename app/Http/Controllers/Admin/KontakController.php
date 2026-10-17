<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KontakRequest;
use App\Models\Kontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kontaks = Kontak::orderBy('urutan')->orderBy('nama')->paginate(15)->withQueryString();

        return view('admin.kontaks.index', compact('kontaks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.kontaks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KontakRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        Kontak::create($validated);

        return redirect()
            ->route('admin.kontaks.index')
            ->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontak $kontak): View
    {
        return view('admin.kontaks.show', compact('kontak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontak $kontak): View
    {
        return view('admin.kontaks.edit', compact('kontak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KontakRequest $request, Kontak $kontak): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        $kontak->update($validated);

        return redirect()
            ->route('admin.kontaks.index')
            ->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak): RedirectResponse
    {
        $kontak->delete();

        return redirect()
            ->route('admin.kontaks.index')
            ->with('success', 'Kontak berhasil dihapus.');
    }
}
