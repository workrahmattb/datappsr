<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    /**
     * Daftar fasilitas yang aktif beserta galeri fotonya.
     */
    public function index(): View
    {
        $fasilitasList = Fasilitas::aktif()
            ->with('fotos')
            ->paginate(9);

        return view('site.fasilitas.index', compact('fasilitasList'));
    }
}
