<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Support\AdmissionPeriod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('admin.layout')]
class Settings extends Component
{
    use WithFileUploads;

    public string $tahunAjaranAktif = '';

    public string $admissionStage = 'both';

    #[Locked]
    public string $admissionYear = '';

    public $headerImage;

    public $headerImagePreview = '';

    public function mount(): void
    {
        $this->loadAdmissionPeriod();
        $this->tahunAjaranAktif = Setting::activeTahunAjaran();
        $this->headerImagePreview = Setting::value('header_image', 'images/psb.webp');
    }

    public function updatedHeaderImage(): void
    {
        $this->validate([
            'headerImage' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Show temporary preview
        $this->headerImagePreview = $this->headerImage->temporaryUrl();
    }

    public function saveHeader(): void
    {
        $this->validate([
            'headerImage' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Delete old custom image if exists
        $oldImage = Setting::value('header_image');
        if ($oldImage && $oldImage !== 'images/psb.webp' && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Store new image
        $path = $this->headerImage->store('settings', 'public');
        Setting::set('header_image', $path);

        $this->headerImagePreview = Storage::url($path);
        $this->headerImage = null;

        session()->flash('success', 'Header image berhasil diperbarui!');
    }

    public function removeHeader(): void
    {
        $oldImage = Setting::value('header_image');
        if ($oldImage && $oldImage !== 'images/psb.webp' && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        Setting::set('header_image', 'images/psb.webp');
        $this->headerImagePreview = 'images/psb.webp';
        $this->headerImage = null;

        session()->flash('success', 'Header image dikembalikan ke default.');
    }

    public function save(): void
    {
        $this->validate([
            'tahunAjaranAktif' => 'required|string|max:20',
        ]);

        abort_unless(auth()->user()?->hasRole('admin'), 403);
        Setting::set('tahun_ajaran_aktif', $this->tahunAjaranAktif);
        $this->loadAdmissionPeriod();

        session()->flash('success', 'Tahun ajaran aktif berhasil diperbarui menjadi '.$this->tahunAjaranAktif);
    }

    protected function loadAdmissionPeriod(): void
    {
        $this->admissionYear = AdmissionPeriod::year();
        $this->admissionStage = AdmissionPeriod::stage($this->admissionYear);
    }

    public function saveAdmissionPeriod(): void
    {
        abort_unless(auth()->user()?->hasRole('admin'), 403);
        $this->validate(['admissionStage' => ['required', Rule::in(array_keys(AdmissionPeriod::STAGES))]]);
        if ($this->admissionYear !== AdmissionPeriod::year()) {
            $this->addError('admissionStage', 'Tahun ajaran aktif telah berubah. Muat ulang halaman sebelum menyimpan.');

            return;
        }
        Setting::set(AdmissionPeriod::key($this->admissionYear), $this->admissionStage);
        session()->flash('success', 'Periode penerimaan berhasil diperbarui.');
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
