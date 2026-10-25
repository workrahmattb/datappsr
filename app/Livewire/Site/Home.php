<?php

namespace App\Livewire\Site;

use App\Models\Berita;
use App\Models\Carousel as CarouselModel;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\Kontak;
use App\Models\Setting;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public', [
    'description' => "Pondok Pesantren Syafaaturrasul di Kuantan Singingi (Kuansing), Riau. MTs dan MA Putra/Putri berakreditasi A, pendidikan Al-Qur'an, serta informasi pendaftaran.",
])]
#[Title('Pesantren Syafaaturrasul Kuansing | MTs & MA')]
class Home extends Component
{
    /**
     * Halaman utama website sekolah: carousel, berita terbaru, fasilitas,
     * profil guru, dan kontak.
     */
    public function render(): View
    {
        return view('livewire.site.home', [
            'adaSlide' => CarouselModel::aktif()->exists(),
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
