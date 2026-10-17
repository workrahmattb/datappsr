<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Models\Setting;
use App\Support\HtmlSanitizer;
use Illuminate\View\View;

class KontakController extends Controller
{
    /**
     * Halaman kontak: informasi lembaga + daftar kontak person.
     */
    public function index(): View
    {
        return view('site.kontak.index', [
            'kontaks' => Kontak::aktif()->get(),
            'lembaga' => [
                'alamat' => Setting::value('kontak_alamat'),
                'telepon' => Setting::value('kontak_telepon'),
                'whatsapp' => Setting::value('kontak_whatsapp'),
                'email' => Setting::value('kontak_email'),
                'jam' => Setting::value('kontak_jam_layanan'),
                'maps' => HtmlSanitizer::embedUrl(Setting::value('kontak_maps_embed')),
                'facebook' => Setting::value('kontak_facebook'),
                'instagram' => Setting::value('kontak_instagram'),
                'youtube' => Setting::value('kontak_youtube'),
            ],
        ]);
    }
}
