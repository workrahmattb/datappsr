<?php

namespace App\Livewire;

use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateFotoForm extends Component
{
    use WithFileUploads;

    public $type;
    public $studentId;
    public $foto;
    public $submitted = false;

    public $student;
    public $existingFoto = null;

    public function mount($type, $id)
    {
        $this->type = $type;
        $this->studentId = $id;

        $modelClass = $this->getModelClass();
        if (!$modelClass) {
            session()->flash('error', 'Jenis data tidak valid.');
            return redirect()->route('home');
        }

        $this->student = $modelClass::findOrFail($id);
        $this->existingFoto = $this->student->foto;
    }

    protected function getModelClass()
    {
        return match ($this->type) {
            'Mtsputra' => Mtsputra::class,
            'Mtsputri' => Mtsputri::class,
            'Maputra' => Maputra::class,
            'Maputri' => Maputri::class,
            default => null,
        };
    }

    public function rules()
    {
        return [
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'foto.required' => 'Foto profil wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto profil harus berformat JPG atau PNG.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2 MB.',
        ];
    }

    public function submit()
    {
        $this->validate($this->rules(), [], $this->messages());

        try {
            $sanitizedNama = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->student->nama);
            $sanitizedNama = preg_replace('/_+/', '_', $sanitizedNama);
            $sanitizedNama = trim($sanitizedNama, '_');
            $timestamp = now()->format('YmdHis');

            // Hapus foto lama jika ada
            if ($this->existingFoto) {
                Storage::disk('public')->delete($this->existingFoto);
            }

            // Upload foto baru
            $fotoPath = $this->foto->storeAs(
                'foto',
                "FOTO_{$this->student->nisn}_{$sanitizedNama}_{$timestamp}.{$this->foto->getClientOriginalExtension()}",
                'public'
            );

            // Update student record
            $modelClass = $this->getModelClass();
            $modelClass::where('id', $this->studentId)->update(['foto' => $fotoPath]);

            // Refresh student data agar success page menampilkan foto yang baru
            $this->student = $modelClass::find($this->studentId);
            $this->existingFoto = $this->student->foto;

            $this->submitted = true;
            session()->flash('success', 'Foto profil berhasil diperbarui!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.update-foto-form')->layout('layouts.standalone');
    }
}
