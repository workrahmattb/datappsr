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
        $query = Pendaftaran::latest();

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
