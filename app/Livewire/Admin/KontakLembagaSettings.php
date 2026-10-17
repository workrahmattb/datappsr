<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layout')]
class KontakLembagaSettings extends Component
{
    public string $alamat = '';

    public string $telepon = '';

    public string $whatsapp = '';

    public string $email = '';

    public string $jamLayanan = '';

    public string $mapsEmbed = '';

    public string $facebook = '';

    public string $instagram = '';

    public string $youtube = '';

    public function mount(): void
    {
        $this->alamat = (string) Setting::value('kontak_alamat', '');
        $this->telepon = (string) Setting::value('kontak_telepon', '');
        $this->whatsapp = (string) Setting::value('kontak_whatsapp', '');
        $this->email = (string) Setting::value('kontak_email', '');
        $this->jamLayanan = (string) Setting::value('kontak_jam_layanan', '');
        $this->mapsEmbed = (string) Setting::value('kontak_maps_embed', '');
        $this->facebook = (string) Setting::value('kontak_facebook', '');
        $this->instagram = (string) Setting::value('kontak_instagram', '');
        $this->youtube = (string) Setting::value('kontak_youtube', '');
    }

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'jamLayanan' => 'nullable|string|max:255',
            'mapsEmbed' => 'nullable|string|max:2000',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 50 karakter.',
            'whatsapp.max' => 'Nomor WhatsApp tidak boleh lebih dari 50 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'jamLayanan.max' => 'Jam layanan tidak boleh lebih dari 255 karakter.',
            'mapsEmbed.max' => 'Kode embed Google Maps terlalu panjang.',
            'facebook.max' => 'Link Facebook tidak boleh lebih dari 255 karakter.',
            'instagram.max' => 'Link Instagram tidak boleh lebih dari 255 karakter.',
            'youtube.max' => 'Link YouTube tidak boleh lebih dari 255 karakter.',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('kontak_alamat', $this->alamat);
        Setting::set('kontak_telepon', $this->telepon);
        Setting::set('kontak_whatsapp', $this->whatsapp);
        Setting::set('kontak_email', $this->email);
        Setting::set('kontak_jam_layanan', $this->jamLayanan);
        Setting::set('kontak_maps_embed', $this->mapsEmbed);
        Setting::set('kontak_facebook', $this->facebook);
        Setting::set('kontak_instagram', $this->instagram);
        Setting::set('kontak_youtube', $this->youtube);

        session()->flash('success', 'Kontak lembaga berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.kontak-lembaga-settings');
    }
}
