<?php

namespace App\Livewire\Admin;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('admin.layout')]
class PendaftaransTable extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $tahunAjaran = null;
    #[Validate('in:pending,completed')]
    public string $status = '';
    public $deleteId = null;
    public string $deleteItemName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'tahunAjaran' => ['except' => null],
        'status' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTahunAjaran(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function confirmDelete($id, $name): void
    {
        $this->deleteId = $id;
        $this->deleteItemName = $name;
        $this->dispatch('modal-show', ...['name' => 'delete-confirm']);
    }

    public function closeModal(): void
    {
        $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
        $this->deleteId = null;
        $this->deleteItemName = '';
    }

    public function deleteConfirmed(): void
    {
        if ($this->deleteId) {
            $pendaftaran = Pendaftaran::find($this->deleteId);

            if ($pendaftaran) {
                // Delete associated files
                if ($pendaftaran->fotokk) Storage::disk('public')->delete($pendaftaran->fotokk);
                if ($pendaftaran->fotoakta) Storage::disk('public')->delete($pendaftaran->fotoakta);
                if ($pendaftaran->fototransfer) Storage::disk('public')->delete($pendaftaran->fototransfer);
                if ($pendaftaran->buktitransfer) Storage::disk('public')->delete($pendaftaran->buktitransfer);

                $pendaftaran->delete();
                $this->dispatch('success', 'Data pendaftaran berhasil dihapus.');
            }

            $this->dispatch('modal-close', ...['name' => 'delete-confirm']);
            $this->deleteId = null;
            $this->deleteItemName = '';
        }
    }

    public function export(): void
    {
        $filename = 'pendaftarans-' . now()->format('Y-m-d-His') . '.xlsx';

        $query = Pendaftaran::latest();
        if (!auth()->user()->hasRole('admin') && auth()->user()->jenjang) {
            $query->where('jenjang_pendidikan', auth()->user()->jenjang);
        }

        SimpleExcelWriter::streamDownload($filename)
            ->addHeader([
                'ID', 'Nama', 'NISN', 'NIK', 'KK', 'Nama KK', 'Jenjang Pendidikan', 'Status Pendaftaran',
                'Tempat Lahir', 'Tanggal Lahir', 'Anak Ke', 'Jumlah Saudara', 'Tahun Ajaran', 'Tanggal Masuk',
                'KKS', 'PKH', 'KIP', 'Jenjang Sebelumnya', 'Status Sekolah Sebelumnya', 'Nama Sekolah Sebelumnya',
                'NPSN Sekolah Sebelumnya', 'Alamat Sekolah Sebelumnya', 'Kecamatan Sekolah Sebelumnya',
                'Kabupaten Sekolah Sebelumnya', 'Provinsi Sekolah Sebelumnya',
                'NIK Ayah', 'Nama Ayah', 'Tempat Lahir Ayah', 'Tanggal Lahir Ayah', 'Status Ayah',
                'No HP Ayah', 'Pendidikan Ayah', 'Pekerjaan Ayah', 'Penghasilan Ayah',
                'NIK Ibu', 'Nama Ibu', 'Tempat Lahir Ibu', 'Tanggal Lahir Ibu', 'Status Ibu',
                'No HP Ibu', 'Pendidikan Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu',
                'Status Milik Rumah', 'RT', 'RW', 'Desa', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Kode Pos',
                'NIK Wali', 'Nama Wali', 'Tempat Lahir Wali', 'Tanggal Lahir Wali', 'No HP Wali',
                'Pendidikan Wali', 'Pekerjaan Wali', 'Penghasilan Wali',
                'Foto KK', 'Foto Akta', 'Foto Transfer', 'Bukti Transfer',
                'Asal Sekolah', 'Alamat', 'No HP', 'Bayar Uang Masuk',
                'Created At', 'Updated At'
            ])
            ->addRows($query->get()->map(function($p) {
                return [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'nisn' => $p->nisn,
                    'nik' => $p->nik,
                    'kk' => $p->kk,
                    'nama_kk' => $p->nama_kk,
                    'jenjang_pendidikan' => $p->jenjang_pendidikan,
                    'status_pendaftaran' => $p->status_pendaftaran,
                    'tempat_lahir' => $p->tempat_lahir,
                    'tanggal_lahir' => $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') : '',
                    'anak_ke' => $p->anak_ke,
                    'jumlah_saudara' => $p->jumlah_saudara,
                    'tahun_ajaran' => $p->tahun_ajaran,
                    'tgl_masuk' => $p->tgl_masuk ? \Carbon\Carbon::parse($p->tgl_masuk)->format('Y-m-d') : '',
                    'kks' => $p->kks,
                    'pkh' => $p->pkh,
                    'kip' => $p->kip,
                    'jenjang_pendidikan_sebelumnya' => $p->jenjang_pendidikan_sebelumnya,
                    'status_sekolah_sebelumnya' => $p->status_sekolah_sebelumnya,
                    'nama_sekolah_sebelumnya' => $p->nama_sekolah_sebelumnya,
                    'npsn_sekolah_sebelumnya' => $p->npsn_sekolah_sebelumnya,
                    'alamat_sekolah_sebelumnya' => $p->alamat_sekolah_sebelumnya,
                    'kecamatan_sekolah_sebelumnya' => $p->kecamatan_sekolah_sebelumnya,
                    'kabupaten_sekolah_sebelumnya' => $p->kabupaten_sekolah_sebelumnya,
                    'provinsi_sekolah_sebelumnya' => $p->provinsi_sekolah_sebelumnya,
                    'nik_ayah' => $p->nik_ayah,
                    'nama_ayah' => $p->nama_ayah,
                    'tempat_lahir_ayah' => $p->tempat_lahir_ayah,
                    'tanggal_lahir_ayah' => $p->tanggal_lahir_ayah ? \Carbon\Carbon::parse($p->tanggal_lahir_ayah)->format('Y-m-d') : '',
                    'status_ayah' => $p->status_ayah,
                    'no_hp_ayah' => $p->no_hp_ayah,
                    'pendidikan_ayah' => $p->pendidikan_ayah,
                    'pekerjaan_ayah' => $p->pekerjaan_ayah,
                    'penghasilan_ayah' => $p->penghasilan_ayah,
                    'nik_ibu' => $p->nik_ibu,
                    'nama_ibu' => $p->nama_ibu,
                    'tempat_lahir_ibu' => $p->tempat_lahir_ibu,
                    'tanggal_lahir_ibu' => $p->tanggal_lahir_ibu ? \Carbon\Carbon::parse($p->tanggal_lahir_ibu)->format('Y-m-d') : '',
                    'status_ibu' => $p->status_ibu,
                    'no_hp_ibu' => $p->no_hp_ibu,
                    'pendidikan_ibu' => $p->pendidikan_ibu,
                    'pekerjaan_ibu' => $p->pekerjaan_ibu,
                    'penghasilan_ibu' => $p->penghasilan_ibu,
                    'status_milik' => $p->status_milik,
                    'rt' => $p->rt,
                    'rw' => $p->rw,
                    'desa' => $p->desa,
                    'kecamatan' => $p->kecamatan,
                    'kabupaten' => $p->kabupaten,
                    'provinsi' => $p->provinsi,
                    'kode_pos' => $p->kode_pos,
                    'nik_wali' => $p->nik_wali,
                    'nama_wali' => $p->nama_wali,
                    'tempat_lahir_wali' => $p->tempat_lahir_wali,
                    'tanggal_lahir_wali' => $p->tanggal_lahir_wali ? \Carbon\Carbon::parse($p->tanggal_lahir_wali)->format('Y-m-d') : '',
                    'no_hp_wali' => $p->no_hp_wali,
                    'pendidikan_wali' => $p->pendidikan_wali,
                    'pekerjaan_wali' => $p->pekerjaan_wali,
                    'penghasilan_wali' => $p->penghasilan_wali,
                    'fotokk' => $p->fotokk,
                    'fotoakta' => $p->fotoakta,
                    'fototransfer' => $p->fototransfer,
                    'buktitransfer' => $p->buktitransfer,
                    'asal_sekolah' => $p->asal_sekolah,
                    'alamat' => $p->alamat,
                    'no_hp' => $p->no_hp,
                    'bayar_uang_masuk' => $p->bayar_uang_masuk,
                    'created_at' => $p->created_at->format('Y-m-d H:i'),
                    'updated_at' => $p->updated_at->format('Y-m-d H:i'),
                ];
            }))
            ->toBrowser();
    }

    public function render()
    {
        $query = Pendaftaran::latest();

        if (!auth()->user()->hasRole('admin') && auth()->user()->jenjang) {
            $query->where('jenjang_pendidikan', auth()->user()->jenjang);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nik', 'like', "%{$this->search}%");
            });
        }

        if ($this->tahunAjaran) {
            $query->where('tahun_ajaran', $this->tahunAjaran);
        }

        if ($this->status) {
            $query->where('status_pendaftaran', $this->status);
        }

        return view('livewire.admin.pendaftarans-table', [
            'pendaftarans' => $query->paginate(15),
            'tahunAjarans' => Pendaftaran::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
