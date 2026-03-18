<?php

namespace App\Livewire;

use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\WithFileUploads;

class PendaftaranForm extends Component
{
    use WithFileUploads;

    public $nisn = '';
    public $nama = '';

    public $tahun_ajaran = '2026/2027';

    public $jenjang_pendidikan = '';
    public $tempat_lahir = '';
    public $tanggal_lahir = '';
    public $asal_sekolah = '';
    public $alamat = '';
    public $nama_ayah = '';
    public $nama_ibu = '';
    public $no_hp = '';
    public $buktitransfer = null;

    public $submitted = false;
    public $submittedDataArray = [];

    public function rules()
    {
        return [
            'nisn' => 'required|string|max:20',
            'nama' => 'required|string|max:100',

            'jenjang_pendidikan' => 'required|string',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'buktitransfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.string' => 'NISN harus berupa teks',
            'nisn.max' => 'NISN tidak boleh lebih dari 20 karakter',

            'nama.required' => 'Nama lengkap wajib diisi',
            'nama.string' => 'Nama harus berupa teks',
            'nama.max' => 'Nama tidak boleh lebih dari 100 karakter',

            'jenjang_pendidikan.required' => 'Jenjang pendidikan wajib dipilih',
            'jenjang_pendidikan.string' => 'Jenjang pendidikan tidak valid',

            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 50 karakter',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',

            'asal_sekolah.required' => 'Asal sekolah wajib diisi',
            'asal_sekolah.string' => 'Asal sekolah harus berupa teks',
            'asal_sekolah.max' => 'Asal sekolah tidak boleh lebih dari 100 karakter',

            'alamat.required' => 'Alamat wajib diisi',
            'alamat.string' => 'Alamat harus berupa teks',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter',

            'nama_ayah.required' => 'Nama ayah wajib diisi',
            'nama_ayah.string' => 'Nama ayah harus berupa teks',
            'nama_ayah.max' => 'Nama ayah tidak boleh lebih dari 100 karakter',

            'nama_ibu.required' => 'Nama ibu wajib diisi',
            'nama_ibu.string' => 'Nama ibu harus berupa teks',
            'nama_ibu.max' => 'Nama ibu tidak boleh lebih dari 100 karakter',

            'no_hp.required' => 'Nomor HP wajib diisi',
            'no_hp.string' => 'Nomor HP harus berupa teks',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 15 karakter',

            'buktitransfer.required' => 'Bukti transfer wajib diunggah',
            'buktitransfer.file' => 'Bukti transfer harus berupa file',
            'buktitransfer.mimes' => 'Bukti transfer harus berformat PDF, JPG, JPEG, atau PNG',
            'buktitransfer.max' => 'Ukuran bukti transfer tidak boleh lebih dari 2 MB',
        ];
    }

    public function validateFile()
    {
        try {
            $this->validate([
                'buktitransfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ], [
                'buktitransfer.required' => 'Bukti transfer wajib diunggah',
                'buktitransfer.file' => 'Bukti transfer harus berupa file yang valid',
                'buktitransfer.mimes' => 'Bukti transfer harus berformat PDF, JPG, JPEG, atau PNG',
                'buktitransfer.max' => 'Ukuran bukti transfer tidak boleh lebih dari 2 MB',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }

    public function updatedBuktitransfer()
    {
        try {
            $this->validateFile();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->buktitransfer = null;
        }
    }

    public function submit()
    {
        $this->validate();

        // Upload file
        $buktitransferPath = $this->buktitransfer->store('pendaftaran', 'public');

        $pendaftaran = Pendaftaran::create([
            'nisn' => $this->nisn,
            'nama' => $this->nama,
            'tahun_ajaran' => $this->tahun_ajaran,
            'jenjang_pendidikan' => $this->jenjang_pendidikan,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'asal_sekolah' => $this->asal_sekolah,
            'alamat' => $this->alamat,
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'no_hp' => $this->no_hp,
            'buktitransfer' => $buktitransferPath,
        ]);

        // Convert model to array to avoid serialization issues
        $this->submittedDataArray = $pendaftaran->toArray();

        // Clear file upload
        $this->buktitransfer = null;

        $this->submitted = true;
    }

    public function resetForm()
    {
        $this->reset();
        $this->submitted = false;
        $this->submittedDataArray = [];
    }

    public function render()
    {
        return view('livewire.pendaftaran-form')->layout('layouts.standalone');
    }
}

