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
            'fototransfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
            'fotokk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fotoakta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function submitStep1()
    {
        $this->validate($this->rulesStep1());
        $this->currentStep = 2;
        session()->flash('success', 'Bukti transfer berhasil diupload. Silakan lengkapi data pendaftaran.');
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
        $this->validate($this->rulesStep2());

        try {
            DB::beginTransaction();

            $sanitizedNama = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->nama);
            $sanitizedNama = preg_replace('/_+/', '_', $sanitizedNama);
            $sanitizedNama = trim($sanitizedNama, '_');
            $timestamp = now()->format('YmdHis');

            // Upload bukti transfer
            $fototransferPath = $this->fototransfer->storeAs(
                'dokumen-siswa/transfer',
                "TRANSFER_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$this->fototransfer->getClientOriginalExtension()}",
                'public'
            );

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
                'fototransfer' => $fototransferPath,
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
