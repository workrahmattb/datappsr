<?php

namespace App\Livewire\Site;

use App\Models\Setting;
use Illuminate\View\View;
use Livewire\Component;

class WhatsappButton extends Component
{
    /**
     * Nomor WhatsApp tujuan (format internasional, tanpa tanda +).
     */
    public const NOMOR_DEFAULT = '6285259875754';

    /**
     * Pesan pembuka yang otomatis terisi di WhatsApp.
     */
    public const PESAN_DEFAULT = "Assalamualaikum warohmatullahi wabarokatuh, Kami ingin mengetahui informasi lebih lanjut Pondok Pesantren Syafa'aturrasul";

    /**
     * Nomor yang dipakai tombol (dari Pengaturan → Kontak Lembaga bila ada).
     */
    public string $nomor = self::NOMOR_DEFAULT;

    public function mount(): void
    {
        $this->nomor = self::nomorDariPengaturan();
    }

    /**
     * Tautan wa.me lengkap dengan pesan pembuka.
     */
    public function linkWhatsapp(): string
    {
        return 'https://wa.me/'.$this->nomor.'?text='.rawurlencode(self::PESAN_DEFAULT);
    }

    public function render(): View
    {
        return view('livewire.site.whatsapp-button');
    }

    /**
     * Nomor WhatsApp dari Pengaturan → Kontak Lembaga, dinormalkan ke format
     * internasional (awalan 0 → 62). Bila kosong, pakai nomor default.
     */
    public static function nomorDariPengaturan(): string
    {
        $nomor = (string) preg_replace('/\D/', '', (string) Setting::value('kontak_whatsapp', ''));

        if (blank($nomor)) {
            return self::NOMOR_DEFAULT;
        }

        return (string) preg_replace('/^0/', '62', $nomor);
    }
}
