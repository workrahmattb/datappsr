<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;
use App\Models\Pendaftaran;
use App\Models\Kelas;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'mtsputra_count' => Mtsputra::count(),
            'mtsputri_count' => Mtsputri::count(),
            'maputra_count' => Maputra::count(),
            'maputri_count' => Maputri::count(),
            'pendaftaran_count' => Pendaftaran::count(),
            'pendaftaran_pending' => Pendaftaran::where('status_pendaftaran', 'pending')->count(),
            'kelas_count' => Kelas::count(),
        ];

        $recentPendaftarans = Pendaftaran::with('kelas')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentPendaftarans'));
    }
}
