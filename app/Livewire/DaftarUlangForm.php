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
    public $pendaftaran;
    
    // Data fields - sesuai dengan MtsputriForm
    public $nama, $tempat_lahir, $tanggal_lahir, $nik, $kk, $nama_kk;
    public $nisn, $nis, $anak_ke, $jumlah_saudara, $tahun_ajaran, $kelas_id;
    public $tgl_masuk, $kks, $pkh, $kip;
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
    public $fotokk, $fotoakta, $fototransfer;

    public $submitted = false;

    // Auto-set penghasilan to "Tidak Ada" when pekerjaan is "Tidak Bekerja"
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

    public function updatedPekerjaanWali($value)
    {
        if ($value === 'Tidak Bekerja') {
            $this->penghasilan_wali = 'Tidak Ada';
        }
    }

    public function mount($id)
    {
        $this->pendaftaranId = $id;
        $this->pendaftaran = Pendaftaran::findOrFail($id);

        // Check if already completed
        if ($this->pendaftaran->status_pendaftaran === 'completed') {
            session()->flash('error', 'Pendaftaran sudah selesai dilakukan.');
            return redirect()->route('daftar-ulang.table');
        }

        // Pre-fill data from pendaftaran
        $this->nama = $this->pendaftaran->nama;
        $this->tempat_lahir = $this->pendaftaran->tempat_lahir;
        $this->tanggal_lahir = $this->pendaftaran->tanggal_lahir;
        $this->nisn = $this->pendaftaran->nisn;
        $this->tahun_ajaran = $this->pendaftaran->tahun_ajaran;
        $this->nama_ayah = $this->pendaftaran->nama_ayah;
        $this->nama_ibu = $this->pendaftaran->nama_ibu;
        $this->no_hp_ayah = $this->pendaftaran->no_hp;
        
        // Pre-fill asal sekolah (nama sekolah sebelumnya)
        $this->nama_sekolah_sebelumnya = $this->pendaftaran->asal_sekolah;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|min:16|max:16',
            'kk' => 'nullable|string|min:16|max:16',
            'nama_kk' => 'nullable|string|max:255',
            'nisn' => 'nullable|string|min:10|max:10',
            'nis' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara' => 'nullable|integer|min:0',
            'tgl_masuk' => 'nullable|date',
            'kks' => 'nullable|string|max:50',
            'pkh' => 'nullable|string|max:50',
            'kip' => 'nullable|string|max:50',
            
            // Data Sekolah Sebelumnya
            'jenjang_pendidikan_sebelumnya' => 'nullable|string',
            'status_sekolah_sebelumnya' => 'nullable|string',
            'nama_sekolah_sebelumnya' => 'nullable|string|max:255',
            'npsn_sekolah_sebelumnya' => 'nullable|string|max:50',
            'alamat_sekolah_sebelumnya' => 'nullable|string',
            'kecamatan_sekolah_sebelumnya' => 'nullable|string|max:100',
            'kabupaten_sekolah_sebelumnya' => 'nullable|string|max:100',
            'provinsi_sekolah_sebelumnya' => 'nullable|string|max:100',
            
            // Data Ayah
            'nik_ayah' => 'nullable|string|min:16|max:16',
            'nama_ayah' => 'required|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|string',
            'no_hp_ayah' => 'required|string|max:15',
            'pendidikan_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            
            // Data Ibu
            'nik_ibu' => 'nullable|string|min:16|max:16',
            'nama_ibu' => 'required|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'status_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string|max:15',
            'pendidikan_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'penghasilan_ibu' => 'nullable|string',
            
            // Data Alamat
            'status_milik' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            
            // Data Wali
            'nik_wali' => 'nullable|string|min:16|max:16',
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|date',
            'no_hp_wali' => 'nullable|string|max:15',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            
            // Upload Dokumen
            'fotokk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fotoakta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Sanitize nama for filename (remove special characters, spaces to underscore)
            $sanitizedNama = preg_replace('/[^A-Za-z0-9\-]/', '_', $this->nama);
            $sanitizedNama = preg_replace('/_+/', '_', $sanitizedNama); // Remove multiple underscores
            $sanitizedNama = trim($sanitizedNama, '_'); // Remove leading/trailing underscores
            
            // Create timestamp
            $timestamp = now()->format('YmdHis');
            
            // Upload files with structured naming
            $fotokkPath = null;
            $fotoaktaPath = null;
            
            if ($this->fotokk) {
                $extension = $this->fotokk->getClientOriginalExtension();
                $filename = "KK_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$extension}";
                $fotokkPath = $this->fotokk->storeAs('dokumen-siswa/kk', $filename, 'public');
            }
            
            if ($this->fotoakta) {
                $extension = $this->fotoakta->getClientOriginalExtension();
                $filename = "AKTA_{$this->nisn}_{$sanitizedNama}_{$timestamp}.{$extension}";
                $fotoaktaPath = $this->fotoakta->storeAs('dokumen-siswa/akta', $filename, 'public');
            }

            // Prepare data
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
                'kelas_id' => $this->kelas_id,
                'tgl_masuk' => $this->tgl_masuk,
                'kks' => $this->kks,
                'pkh' => $this->pkh,
                'kip' => $this->kip,
                'jenjang_pendidikan_sebelumnya' => $this->jenjang_pendidikan_sebelumnya,
                'status_sekolah_sebelumnya' => $this->status_sekolah_sebelumnya,
                'nama_sekolah_sebelumnya' => $this->nama_sekolah_sebelumnya,
                'npsn_sekolah_sebelumnya' => $this->npsn_sekolah_sebelumnya,
                'alamat_sekolah_sebelumnya' => $this->alamat_sekolah_sebelumnya,
                'kecamatan_sekolah_sebelumnya' => $this->kecamatan_sekolah_sebelumnya,
                'kabupaten_sekolah_sebelumnya' => $this->kabupaten_sekolah_sebelumnya,
                'provinsi_sekolah_sebelumnya' => $this->provinsi_sekolah_sebelumnya,
                'nik_ayah' => $this->nik_ayah,
                'nama_ayah' => $this->nama_ayah,
                'tempat_lahir_ayah' => $this->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $this->tanggal_lahir_ayah,
                'status_ayah' => $this->status_ayah,
                'no_hp_ayah' => $this->no_hp_ayah,
                'pendidikan_ayah' => $this->pendidikan_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'penghasilan_ayah' => $this->penghasilan_ayah,
                'nik_ibu' => $this->nik_ibu,
                'nama_ibu' => $this->nama_ibu,
                'tempat_lahir_ibu' => $this->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $this->tanggal_lahir_ibu,
                'status_ibu' => $this->status_ibu,
                'no_hp_ibu' => $this->no_hp_ibu,
                'pendidikan_ibu' => $this->pendidikan_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'penghasilan_ibu' => $this->penghasilan_ibu,
                'status_milik' => $this->status_milik,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'desa' => $this->desa,
                'kecamatan' => $this->kecamatan,
                'kabupaten' => $this->kabupaten,
                'provinsi' => $this->provinsi,
                'kode_pos' => $this->kode_pos,
                'nik_wali' => $this->nik_wali,
                'nama_wali' => $this->nama_wali,
                'tempat_lahir_wali' => $this->tempat_lahir_wali,
                'tanggal_lahir_wali' => $this->tanggal_lahir_wali,
                'no_hp_wali' => $this->no_hp_wali,
                'pendidikan_wali' => $this->pendidikan_wali,
                'pekerjaan_wali' => $this->pekerjaan_wali,
                'penghasilan_wali' => $this->penghasilan_wali,
                'fotokk' => $fotokkPath,
                'fotoakta' => $fotoaktaPath,
            ];

            // Get target model class
            $modelClass = $this->pendaftaran->getTargetModelClass();
            
            if (!$modelClass) {
                throw new \Exception('Jenjang pendidikan tidak valid: ' . $this->pendaftaran->jenjang_pendidikan);
            }

            // Log untuk debugging
            \Log::info('Attempting to save to: ' . $modelClass);
            \Log::info('Data to save:', $data);

            // Create student record
            $student = $modelClass::create($data);

            // Update pendaftaran status
            $this->pendaftaran->update([
                'status_pendaftaran' => 'completed',
                'student_id' => $student->id,
                'student_type' => $this->pendaftaran->getStudentType(),
            ]);

            DB::commit();

            $this->submitted = true;

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Error in DaftarUlangForm submit: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.daftar-ulang-form')->layout('layouts.standalone');
    }
}
