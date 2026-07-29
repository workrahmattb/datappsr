<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('admin.layout')]
class Settings extends Component
{
    public string $tahunAjaranAktif = '';

    public function mount(): void
    {
        $this->tahunAjaranAktif = Setting::activeTahunAjaran();
    }

    public function save(): void
    {
        $this->validate([
            'tahunAjaranAktif' => 'required|string|max:20',
        ]);

        Setting::set('tahun_ajaran_aktif', $this->tahunAjaranAktif);

        session()->flash('success', 'Tahun ajaran aktif berhasil diperbarui menjadi ' . $this->tahunAjaranAktif);
    }

    public function render()
    {
        return view('livewire.admin.settings', [
            'tahunAjaranList' => [
                '2025/2026', '2026/2027',
                '2027/2028', '2028/2029', '2029/2030', '2030/2031',
                '2031/2032', '2032/2033',
            ],
        ]);
    }
}
