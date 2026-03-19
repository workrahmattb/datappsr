<?php

namespace App\Livewire\Admin;

use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;
use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'mtsputra_count' => Mtsputra::count(),
            'mtsputri_count' => Mtsputri::count(),
            'maputra_count' => Maputra::count(),
            'maputri_count' => Maputri::count(),
            'pendaftaran_count' => Pendaftaran::count(),
            'pendaftaran_pending' => Pendaftaran::where('status_pendaftaran', 'pending')->count(),
        ];

        $recentPendaftarans = Pendaftaran::latest()->take(10)->get();
        $recentMtsputras = Mtsputra::latest()->take(5)->get();
        $recentMtsputris = Mtsputri::latest()->take(5)->get();
        $recentMaputras = Maputra::latest()->take(5)->get();
        $recentMaputris = Maputri::latest()->take(5)->get();

        return view('livewire.admin.dashboard', compact(
            'stats', 
            'recentPendaftarans',
            'recentMtsputras',
            'recentMtsputris',
            'recentMaputras',
            'recentMaputris'
        ));
    }
}
