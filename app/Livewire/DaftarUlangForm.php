<?php

namespace App\Livewire;

use App\Models\Pendaftaran;
use App\Models\Mtsputri;
use App\Models\Mtsputra;
use App\Models\Maputri;
use App\Models\Maputra;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class DaftarUlangForm extends Component
{
    use WithFileUploads;

    public $pendaftaranId;
    public $currentStep = 1; // 1 = Upload Bukti Transfer, 2 = Form Lengkap
    public $submitted = false;
    public $jenjangPendidikan = '';

    // Step 1: Bukti Transfer
    public $fototransfer;
    public $fototransferPath = null;

    // Form data (Step 2)
    public $nama, $tempat_lahir, $tanggal_lahir, $nik, $kk, $nama_kk;
    public $nisn, $nis, $anak_ke, $jumlah_saudara, $tahun_ajaran;
    public $jenjang_pendidikan_sebelumnya, $status_sekolah_sebelumnya;
    public $nama_sekolah_sebelumnya, $npsn_sekolah_sebelumnya;
    public $alamat_sekolah_sebelumnya, $kecamatan_sekolah_sebelumnya;
    public $kabupaten_sekolah_sebelumnya, $provinsi_sekolah_sebelumnya;
    public $nik_ayah, $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah;
    public $status_ayah, $no_hp_ayah, $pendidikan_ayah, $pekerjaan_ayah, $penghasilan_ayah;
    public $nik_ibu, $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu;
    public $status_ibu, $no_hp_ibu, $pendidikan_ibu, $pekerjaan_ibu, $penghasilan_ibu;
    public $status_milik, $rt, $rw, $desa, $kecamatan, $kabupaten, $provinsi, $kode_pos;
    public $nik_wali, $nama_wali, $tempat_lahir_wali, $tanggal_lahir_wali;
    public $no_hp_wali, $pendidikan_wali, $pekerjaan_wali, $penghasilan_wali;
    public $fotokk, $fotoakta;
    public $foto;

    public function mount($id)
    {
        $this->pendaftaranId = $id;
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status_pendaftaran === 'completed') {
            session()->flash('error', 'Pendaftaran sudah selesai dilakukan.');
            return redirect()->route('daftar-ulang.table');
        }

        $this->tahun_ajaran = $pendaftaran->tahun_ajaran;
        $this->jenjangPendidikan = $pendaftaran->jenjang_pendidikan;
        $this->nama = $pendaftaran->nama;
        $this->tempat_lahir = $pendaftaran->tempat_lahir;
        $this->tanggal_lahir = $pendaftaran->tanggal_lahir;
        $this->nisn = $pendaftaran->nisn;
        $this->nama_ayah = $pendaftaran->nama_ayah;
        $this->nama_ibu = $pendaftaran->nama_ibu;
        $this->no_hp_ayah = $pendaftaran->no_hp;
        $this->nama_sekolah_sebelumnya = $pendaftaran->asal_sekolah;
    }

    public function rulesStep1()
    {
        return [
            'fototransfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function rulesStep2()
    {
        return [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|min:16|max:16',
            'kk' => 'nullable|string|min:16|max:16',
            'nama_kk' => 'nullable|string|max:255',
            'nisn' => 'required|string|min:10|max:10',
            'nis' => 'nullable|string|max:50',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'nama_sekolah_sebelumnya' => 'required|string|max:255',
            'npsn_sekolah_sebelumnya' => 'required|string|max:50',
            'alamat_sekolah_sebelumnya' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|string|min:16|max:16',
            'tempat_lahir_ayah' => 'required|string|max:255',
            'tanggal_lahir_ayah' => 'required|date',
            'no_hp_ayah' => 'required|string|max:15',
            'pendidikan_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|string|min:16|max:16',
            'tempat_lahir_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required|date',
            'no_hp_ibu' => 'required|string|max:15',
            'pendidikan_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'fotokk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fotoakta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            // Step 1 - Upload Bukti Transfer
            'fototransfer.required' => 'Bukti transfer wajib diunggah.',
            'fototransfer.file' => 'Bukti transfer harus berupa file yang valid.',
            'fototransfer.mimes' => 'Bukti transfer harus berformat PDF, JPG, JPEG, atau PNG.',
            'fototransfer.max' => 'Ukuran bukti transfer tidak boleh lebih dari 2 MB.',

            // Step 2 - Data Pribadi
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.min' => 'NIK harus terdiri dari 16 digit.',
            'nik.max' => 'NIK harus terdiri dari 16 digit.',
            'kk.min' => 'Nomor KK harus terdiri dari 16 digit.',
            'kk.max' => 'Nomor KK harus terdiri dari 16 digit.',
            'nama_kk.max' => 'Nama Kepala Keluarga tidak boleh lebih dari 255 karakter.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.min' => 'NISN harus terdiri dari 10 digit.',
            'nisn.max' => 'NISN harus terdiri dari 10 digit.',
            'nis.max' => 'NIS tidak boleh lebih dari 50 karakter.',
            'anak_ke.required' => 'Anak ke- wajib diisi.',
            'anak_ke.integer' => 'Anak ke- harus berupa angka.',
            'anak_ke.min' => 'Anak ke- minimal 1.',
            'jumlah_saudara.required' => 'Jumlah saudara wajib diisi.',
            'jumlah_saudara.integer' => 'Jumlah saudara harus berupa angka.',
            'jumlah_saudara.min' => 'Jumlah saudara tidak boleh negatif.',

            // Data Sekolah Sebelumnya
            'nama_sekolah_sebelumnya.required' => 'Nama sekolah sebelumnya wajib diisi.',
            'nama_sekolah_sebelumnya.max' => 'Nama sekolah tidak boleh lebih dari 255 karakter.',
            'npsn_sekolah_sebelumnya.required' => 'NPSN sekolah wajib diisi.',
            'npsn_sekolah_sebelumnya.max' => 'NPSN tidak boleh lebih dari 50 karakter.',
            'alamat_sekolah_sebelumnya.required' => 'Alamat sekolah wajib diisi.',

            // Data Ayah
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ayah.max' => 'Nama ayah tidak boleh lebih dari 255 karakter.',
            'nik_ayah.required' => 'NIK ayah wajib diisi.',
            'nik_ayah.min' => 'NIK ayah harus terdiri dari 16 digit.',
            'nik_ayah.max' => 'NIK ayah harus terdiri dari 16 digit.',
            'tempat_lahir_ayah.required' => 'Tempat lahir ayah wajib diisi.',
            'tempat_lahir_ayah.max' => 'Tempat lahir ayah tidak boleh lebih dari 255 karakter.',
            'tanggal_lahir_ayah.required' => 'Tanggal lahir ayah wajib diisi.',
            'tanggal_lahir_ayah.date' => 'Tanggal lahir ayah tidak valid.',
            'no_hp_ayah.required' => 'Nomor HP ayah wajib diisi.',
            'no_hp_ayah.max' => 'Nomor HP ayah tidak boleh lebih dari 15 karakter.',
            'pendidikan_ayah.required' => 'Pendidikan ayah wajib dipilih.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib dipilih.',
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib dipilih.',

            // Data Ibu
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'nama_ibu.max' => 'Nama ibu tidak boleh lebih dari 255 karakter.',
            'nik_ibu.required' => 'NIK ibu wajib diisi.',
            'nik_ibu.min' => 'NIK ibu harus terdiri dari 16 digit.',
            'nik_ibu.max' => 'NIK ibu harus terdiri dari 16 digit.',
            'tempat_lahir_ibu.required' => 'Tempat lahir ibu wajib diisi.',
            'tempat_lahir_ibu.max' => 'Tempat lahir ibu tidak boleh lebih dari 255 karakter.',
            'tanggal_lahir_ibu.required' => 'Tanggal lahir ibu wajib diisi.',
            'tanggal_lahir_ibu.date' => 'Tanggal lahir ibu tidak valid.',
            'no_hp_ibu.required' => 'Nomor HP ibu wajib diisi.',
            'no_hp_ibu.max' => 'Nomor HP ibu tidak boleh lebih dari 15 karakter.',
            'pendidikan_ibu.required' => 'Pendidikan ibu wajib dipilih.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib dipilih.',
            'penghasilan_ibu.required' => 'Penghasilan ibu wajib dipilih.',

            // Alamat
            'desa.required' => 'Desa/Kelurahan wajib diisi.',
            'desa.max' => 'Desa/Kelurahan tidak boleh lebih dari 100 karakter.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 100 karakter.',
            'kabupaten.required' => 'Kabupaten/Kota wajib diisi.',
            'kabupaten.max' => 'Kabupaten/Kota tidak boleh lebih dari 100 karakter.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'provinsi.max' => 'Provinsi tidak boleh lebih dari 100 karakter.',

            // Upload Dokumen
            'fotokk.required' => 'Foto Kartu Keluarga (KK) wajib diunggah.',
            'fotokk.file' => 'KK harus berupa file yang valid.',
            'fotokk.mimes' => 'KK harus berformat PDF, JPG, JPEG, atau PNG.',
            'fotokk.max' => 'Ukuran file KK tidak boleh lebih dari 2 MB.',
            'fotoakta.required' => 'Foto Akta Kelahiran wajib diunggah.',
            'fotoakta.file' => 'Akta harus berupa file yang valid.',
            'fotoakta.mimes' => 'Akta harus berformat PDF, JPG, JPEG, atau PNG.',
            'fotoakta.max' => 'Ukuran file Akta tidak boleh lebih dari 2 MB.',

            // Upload Pas Photo
            'foto.required' => 'Pas photo anak wajib diunggah.',
            'foto.image' => 'Pas photo harus berupa gambar.',
            'foto.mimes' => 'Pas photo harus berformat JPG atau PNG.',
            'foto.max' => 'Ukuran pas photo tidak boleh lebih dari 2 MB.',
        ];
    }

    public function submitStep1()
    {
        $this->validate($this->rulesStep1(), [], $this->messages());
        
        try {
            // Simpan file bukti transfer ke storage
            $sanitizedNama = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->nama);
            $sanitizedNama = preg_replace('/_+/', '_', $sanitizedNama);
            $sanitizedNama = trim($sanitizedNama, '_');
            $timestamp = now()->format('YmdHis');

            $this->fototransferPath = $this->fototransfer->storeAs(
                'dokumen-siswa/transfer',
                "TRANSFER_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$this->fototransfer->getClientOriginalExtension()}",
                'public'
            );

            $this->currentStep = 2;
            session()->flash('success', 'Bukti transfer berhasil diupload. Silakan lengkapi data pendaftaran.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengupload bukti transfer: ' . $e->getMessage());
        }
    }

    public function updatedPekerjaanAyah($value)
    {
        if ($value === 'Tidak Bekerja') {
            $this->penghasilan_ayah = 'Tidak Ada';
        }
    }

    public function updatedPekerjaanIbu($value)
    {
        if ($value === 'Tidak Bekerja') {
            $this->penghasilan_ibu = 'Tidak Ada';
        }
    }

    public function submit()
    {
        $this->validate($this->rulesStep2(), [], $this->messages());

        try {
            DB::beginTransaction();

            $sanitizedNama = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->nama);
            $sanitizedNama = preg_replace('/_+/', '_', $sanitizedNama);
            $sanitizedNama = trim($sanitizedNama, '_');
            $timestamp = now()->format('YmdHis');

            // Upload KK
            $fotokkPath = $this->fotokk->storeAs(
                'dokumen-siswa/kk',
                "KK_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$this->fotokk->getClientOriginalExtension()}",
                'public'
            );

            // Upload Akta
            $fotoaktaPath = $this->fotoakta->storeAs(
                'dokumen-siswa/akta',
                "AKTA_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$this->fotoakta->getClientOriginalExtension()}",
                'public'
            );

            // Upload Pas Photo
            $fotoPath = $this->foto->storeAs(
                'foto',
                "FOTO_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$this->foto->getClientOriginalExtension()}",
                'public'
            );

            $data = [
                'nama' => $this->nama,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'nik' => $this->nik,
                'kk' => $this->kk,
                'nama_kk' => $this->nama_kk,
                'nisn' => $this->nisn,
                'nis' => $this->nis,
                'anak_ke' => $this->anak_ke,
                'jumlah_saudara' => $this->jumlah_saudara,
                'tahun_ajaran' => $this->tahun_ajaran,
                'nama_sekolah_sebelumnya' => $this->nama_sekolah_sebelumnya,
                'npsn_sekolah_sebelumnya' => $this->npsn_sekolah_sebelumnya,
                'alamat_sekolah_sebelumnya' => $this->alamat_sekolah_sebelumnya,
                'nik_ayah' => $this->nik_ayah,
                'nama_ayah' => $this->nama_ayah,
                'tempat_lahir_ayah' => $this->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $this->tanggal_lahir_ayah,
                'no_hp_ayah' => $this->no_hp_ayah,
                'pendidikan_ayah' => $this->pendidikan_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'penghasilan_ayah' => $this->penghasilan_ayah,
                'nik_ibu' => $this->nik_ibu,
                'nama_ibu' => $this->nama_ibu,
                'tempat_lahir_ibu' => $this->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $this->tanggal_lahir_ibu,
                'no_hp_ibu' => $this->no_hp_ibu,
                'pendidikan_ibu' => $this->pendidikan_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'penghasilan_ibu' => $this->penghasilan_ibu,
                'desa' => $this->desa,
                'kecamatan' => $this->kecamatan,
                'kabupaten' => $this->kabupaten,
                'provinsi' => $this->provinsi,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'fotokk' => $fotokkPath,
                'fotoakta' => $fotoaktaPath,
                'foto' => $fotoPath,
                'fototransfer' => $this->fototransferPath,
            ];

            $pendaftaran = Pendaftaran::findOrFail($this->pendaftaranId);
            $modelClass = $pendaftaran->getTargetModelClass();

            if (!$modelClass) {
                throw new \Exception('Jenjang pendidikan tidak valid');
            }

            $student = $modelClass::create($data);

            $pendaftaran->update([
                'status_pendaftaran' => 'completed',
                'student_id' => $student->id,
                'student_type' => $pendaftaran->getStudentType(),
            ]);

            DB::commit();
            $this->submitted = true;

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.daftar-ulang-form')->layout('layouts.standalone');
    }
}
