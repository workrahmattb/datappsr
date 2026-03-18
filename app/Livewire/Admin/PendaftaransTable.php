<?php

namespace App\Livewire\Admin;

use App\Models\Pendaftaran;
use App\Models\Kelas;
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
    public ?int $kelasId = null;
    #[Validate('in:pending,completed')]
    public string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'kelasId' => ['except' => null],
        'status' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingKelasId(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function delete($id): void
    {
        if (confirm('Yakin ingin menghapus data pendaftaran ini?')) {
            Pendaftaran::destroy($id);
            $this->dispatch('success', 'Data pendaftaran berhasil dihapus.');
        }
    }

    public function export(): void
    {
        $filename = 'pendaftarans-' . now()->format('Y-m-d-His') . '.xlsx';

        SimpleExcelWriter::streamDownload($filename)
            ->addHeadings([
                'ID', 'Nama', 'NISN', 'NIK', 'Jenjang', 'Status',
                'Tempat Lahir', 'Tanggal Lahir', 'No HP Ayah', 'No HP Ibu',
                'Kelas', 'Tahun Ajaran', 'Created At'
            ])
            ->addRows(Pendaftaran::with('kelas')->latest()->get()->map(function($p) {
                return [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'nisn' => $p->nisn,
                    'nik' => $p->nik,
                    'jenjang_pendidikan' => $p->jenjang_pendidikan,
                    'status_pendaftaran' => $p->status_pendaftaran,
                    'tempat_lahir' => $p->tempat_lahir,
                    'tanggal_lahir' => $p->tanggal_lahir,
                    'no_hp_ayah' => $p->no_hp_ayah,
                    'no_hp_ibu' => $p->no_hp_ibu,
                    'kelas' => $p->kelas?->nama ?? '-',
                    'tahun_ajaran' => $p->tahun_ajaran,
                    'created_at' => $p->created_at->format('Y-m-d H:i'),
                ];
            }))
            ->toBrowser();
    }

    public function render()
    {
        $query = Pendaftaran::with('kelas')->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nik', 'like', "%{$this->search}%");
            });
        }

        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }

        if ($this->status) {
            $query->where('status_pendaftaran', $this->status);
        }

        return view('livewire.admin.pendaftarans-table', [
            'pendaftarans' => $query->paginate(15),
            'kelas' => Kelas::all(),
        ]);
    }
}
