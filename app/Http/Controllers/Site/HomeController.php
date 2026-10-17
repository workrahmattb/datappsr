<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Carousel;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\Kontak;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Halaman utama / website sekolah.
     */
    public function index(): View
    {
        return view('site.home', [
            'slides' => Carousel::aktif()->take(5)->get(),
            'beritas' => Berita::published()->latest('published_at')->take(3)->get(),
            'fasilitasList' => Fasilitas::aktif()->with('fotos')->take(3)->get(),
            'gurus' => Guru::aktif()->take(4)->get(),
            'kontaks' => Kontak::aktif()->take(4)->get(),
            'lembaga' => [
                'alamat' => Setting::value('kontak_alamat'),
                'telepon' => Setting::value('kontak_telepon'),
                'whatsapp' => Setting::value('kontak_whatsapp'),
                'email' => Setting::value('kontak_email'),
                'jam' => Setting::value('kontak_jam_layanan'),
            ],
        ]);
    }
}
