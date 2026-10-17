<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselRequest;
use App\Models\Carousel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarouselController extends Controller
{
    /**
     * Directory on the public disk where carousel images are stored.
     */
    private const GAMBAR_DIRECTORY = 'konten/carousel';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $carousels = Carousel::orderBy('urutan')->paginate(15)->withQueryString();

        return view('admin.carousels.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.carousels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarouselRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['gambar'] = $request->file('gambar')->store(self::GAMBAR_DIRECTORY, 'public');

        Carousel::create($validated);

        return redirect()
            ->route('admin.carousels.index')
            ->with('success', 'Slide carousel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carousel $carousel): View
    {
        return view('admin.carousels.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carousel): View
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarouselRequest $request, Carousel $carousel): RedirectResponse
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('gambar')) {
            if ($carousel->gambar) {
                Storage::disk('public')->delete($carousel->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store(self::GAMBAR_DIRECTORY, 'public');
        }

        $carousel->update($validated);

        return redirect()
            ->route('admin.carousels.index')
            ->with('success', 'Slide carousel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carousel): RedirectResponse
    {
        if ($carousel->gambar) {
            Storage::disk('public')->delete($carousel->gambar);
        }

        $carousel->delete();

        return redirect()
            ->route('admin.carousels.index')
            ->with('success', 'Slide carousel berhasil dihapus.');
    }
}
