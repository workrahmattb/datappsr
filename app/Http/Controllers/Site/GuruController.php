<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\View\View;

class GuruController extends Controller
{
    /**
     * Daftar profil guru / ustadz-ustadzah.
     */
    public function index(): View
    {
        $gurus = Guru::aktif()->paginate(12);

        return view('site.guru.index', compact('gurus'));
    }
}
