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
    public ?string $jenjang = null;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 15;
    public $deleteId = null;
    public string $deleteItemName = '';
    public $editingBayar = null;
    public string $bayarValue = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'tahunAjaran' => ['except' => null],
        'status' => ['except' => ''],
        'jenjang' => ['except' => null],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 15],
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

    public function updatingJenjang(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function confirmDelete($id, $name): void
    {
        $this->deleteId = $id;
        $this->deleteItemName = $name;
        $this->dispatch('modal-show', ...['name' => 'delete-confirm']);
    }

    public function editBayar($id): void
    {
        $pendaftaran = Pendaftaran::find($id);
        if ($pendaftaran) {
            $this->editingBayar = (int) $id;
            $this->bayarValue = $pendaftaran->bayar_uang_masuk ?? '';
        }
    }

    public function saveBayar($id, $nilai = null): void
    {
        // Nilai dari Alpine (x-on:keydown.enter / x-on:blur) lebih diutamakan
        if ($nilai !== null) {
            $this->bayarValue = (string) $nilai;
        }

        $this->validate([
            'bayarValue' => 'nullable|numeric|min:0',
        ]);

        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            $this->dispatch('error', 'Data pendaftaran tidak ditemukan.');
            $this->editingBayar = null;
            $this->bayarValue = '';
            return;
        }

        $pendaftaran->update([
            'bayar_uang_masuk' => $this->bayarValue !== '' && $this->bayarValue !== null ? $this->bayarValue : null,
        ]);

        $this->dispatch('success', 'Pembayaran uang masuk berhasil diperbarui.');
        $this->editingBayar = null;
        $this->bayarValue = '';
    }

    public function cancelBayar(): void
    {
        $this->editingBayar = null;
        $this->bayarValue = '';
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

        if ($this->jenjang) {
            $query->where('jenjang_pendidikan', $this->jenjang);
        }

        $filename = 'pendaftarans-' . now()->format('Y-m-d-His') . '.xlsx';
        $tempPath = 'temp/' . $filename;

        // Ensure temp directory exists & cleanup old files (>= 1 jam)
        Storage::disk('public')->makeDirectory('temp');
        collect(Storage::disk('public')->files('temp'))
            ->each(fn($f) => Storage::disk('public')->lastModified($f) < now()->subHour()->timestamp
                ? Storage::disk('public')->delete($f)
                : null
            );

        SimpleExcelWriter::create(Storage::disk('public')->path($tempPath))
            ->addHeader([
                'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Jenjang', 'Asal Sekolah', 'Tanggal Pendaftaran',
                'Status', 'Uang Masuk', 'Kontak', 'Nama Ayah', 'Nama Ibu', 'Alamat'
            ])
            ->addRows($query->get()->map(function($p) {
                $wib = $p->created_at->setTimezone('Asia/Jakarta');
                return [
                    'nama' => $p->nama ?? '-',
                    'tempat_lahir' => $p->tempat_lahir ?? '-',
                    'tanggal_lahir' => $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') : '-',
                    'jenjang' => $p->jenjang_pendidikan ?? '-',
                    'asal_sekolah' => $p->nama_sekolah_sebelumnya ?? $p->asal_sekolah ?? '-',
                    'tanggal_pendaftaran' => $wib->locale('id')->isoFormat('D MMMM Y') . ' ' . $wib->format('H:i') . ' WIB',
                    'status' => ucfirst($p->status_pendaftaran ?? '-'),
                    'uang_masuk' => $p->bayar_uang_masuk ? number_format($p->bayar_uang_masuk, 0, ',', '.') : '-',
                    'kontak' => $p->no_hp ?? '-',
                    'nama_ayah' => $p->nama_ayah ?? '-',
                    'nama_ibu' => $p->nama_ibu ?? '-',
                    'alamat' => $p->alamat ?? (collect([$p->desa, $p->kecamatan, $p->kabupaten, $p->provinsi])->filter()->implode(', ') ?: '-'),
                ];
            }));

        $this->dispatch('download-excel', url: Storage::disk('public')->url($tempPath));
    }

    public static function waUrl($p): string
    {
        $ttl = $p->tempat_lahir . ', ' . ($p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') : '-');
        $asalSekolah = $p->nama_sekolah_sebelumnya ?? $p->asal_sekolah ?? '-';
        $kontak = $p->no_hp ?? $p->no_hp_ayah ?? $p->no_hp_ibu ?? '-';
        $alamatLengkap = $p->alamat ?? (collect([$p->desa, $p->kecamatan, $p->kabupaten, $p->provinsi])->filter()->implode(', ') ?: '-');

        return 'https://wa.me/6285259875754?text=' . rawurlencode(
            "*Data Pendaftaran Siswa Baru*\n" .
            "\n" .
            "Nama: " . $p->nama . "\n" .
            "Tempat/Tgl Lahir: " . $ttl . "\n" .
            "Jenjang: " . $p->jenjang_pendidikan . "\n" .
            "Nama Ayah: " . ($p->nama_ayah ?? '-') . "\n" .
            "Nama Ibu: " . ($p->nama_ibu ?? '-') . "\n" .
            "Asal Sekolah: " . $asalSekolah . "\n" .
            "No. Kontak: " . $kontak . "\n" .
            "Alamat: " . $alamatLengkap
        );
    }

    public function render()
    {
        $query = Pendaftaran::query();

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

        if ($this->jenjang) {
            $query->where('jenjang_pendidikan', $this->jenjang);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        // PerPage: pilihan 15, 25, 50, 100 — validasi
        $perPage = in_array($this->perPage, [15, 25, 50, 100]) ? $this->perPage : 15;

        return view('livewire.admin.pendaftarans-table', [
            'pendaftarans' => $query->paginate($perPage),
            'tahunAjarans' => Pendaftaran::whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->unique(),
        ]);
    }
}
