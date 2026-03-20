<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status_pendaftaran', $request->status);
        }

        $pendaftarans = $query->paginate(15)->withQueryString();

        return view('admin.pendaftarans.index', compact('pendaftarans'));
    }

    public function create()
    {
        return view('admin.pendaftarans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenjang_pendidikan' => 'required|in:MTs Putri,MTs Putra,MA Putri,MA Putra',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|max:20',
            'kk' => 'nullable|string|max:20',
            'nama_kk' => 'nullable|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'nis' => 'nullable|string|max:20',
            'anak_ke' => 'nullable|string|max:10',
            'tahun_ajaran' => 'nullable|string|max:20',

            'jumlah_saudara' => 'nullable|string|max:10',
            'tgl_masuk' => 'nullable|date',
            'kks' => 'nullable|string|max:50',
            'pkh' => 'nullable|string|max:50',
            'kip' => 'nullable|string|max:50',
            'jenjang_pendidikan_sebelumnya' => 'nullable|string|max:100',
            'status_sekolah_sebelumnya' => 'nullable|string|max:100',
            'nama_sekolah_sebelumnya' => 'nullable|string|max:255',
            'npsn_sekolah_sebelumnya' => 'nullable|string|max:20',
            'alamat_sekolah_sebelumnya' => 'nullable|string|max:255',
            'kecamatan_sekolah_sebelumnya' => 'nullable|string|max:100',
            'kabupaten_sekolah_sebelumnya' => 'nullable|string|max:100',
            'provinsi_sekolah_sebelumnya' => 'nullable|string|max:100',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'status_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|string|max:100',
            'status_milik' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'nik_wali' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|date',
            'no_hp_wali' => 'nullable|string|max:20',
            'pendidikan_wali' => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'penghasilan_wali' => 'nullable|string|max:100',
            'fotokk' => 'nullable|image|max:2048',
            'fotoakta' => 'nullable|image|max:2048',
            'fototransfer' => 'nullable|image|max:2048',
            'bayar_uang_masuk' => 'nullable|numeric',
        ]);

        if ($request->hasFile('fotokk')) {
            $validated['fotokk'] = $request->file('fotokk')->store('documents/pendaftaran', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/pendaftaran', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/pendaftaran', 'public');
        }

        $validated['status_pendaftaran'] = $validated['status_pendaftaran'] ?? 'pending';

        Pendaftaran::create($validated);

        return redirect()->route('admin.pendaftarans.index')
            ->with('success', 'Data pendaftaran berhasil ditambahkan.');
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftarans.show', compact('pendaftaran'));
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftarans.edit', compact('pendaftaran'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'jenjang_pendidikan' => 'required|in:MTs Putri,MTs Putra,MA Putri,MA Putra',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|max:20',
            'kk' => 'nullable|string|max:20',
            'nama_kk' => 'nullable|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'nis' => 'nullable|string|max:20',
            'anak_ke' => 'nullable|string|max:10',
            'tahun_ajaran' => 'nullable|string|max:20',

            'jumlah_saudara' => 'nullable|string|max:10',
            'tgl_masuk' => 'nullable|date',
            'kks' => 'nullable|string|max:50',
            'pkh' => 'nullable|string|max:50',
            'kip' => 'nullable|string|max:50',
            'jenjang_pendidikan_sebelumnya' => 'nullable|string|max:100',
            'status_sekolah_sebelumnya' => 'nullable|string|max:100',
            'nama_sekolah_sebelumnya' => 'nullable|string|max:255',
            'npsn_sekolah_sebelumnya' => 'nullable|string|max:20',
            'alamat_sekolah_sebelumnya' => 'nullable|string|max:255',
            'kecamatan_sekolah_sebelumnya' => 'nullable|string|max:100',
            'kabupaten_sekolah_sebelumnya' => 'nullable|string|max:100',
            'provinsi_sekolah_sebelumnya' => 'nullable|string|max:100',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'status_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|string|max:100',
            'status_milik' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'nik_wali' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|date',
            'no_hp_wali' => 'nullable|string|max:20',
            'pendidikan_wali' => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'penghasilan_wali' => 'nullable|string|max:100',
            'fotokk' => 'nullable|image|max:2048',
            'fotoakta' => 'nullable|image|max:2048',
            'fototransfer' => 'nullable|image|max:2048',
            'bayar_uang_masuk' => 'nullable|numeric',
        ]);

        if ($request->hasFile('fotokk')) {
            if ($pendaftaran->fotokk) Storage::disk('public')->delete($pendaftaran->fotokk);
            $validated['fotokk'] = $request->file('fotokk')->store('documents/pendaftaran', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            if ($pendaftaran->fotoakta) Storage::disk('public')->delete($pendaftaran->fotoakta);
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/pendaftaran', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            if ($pendaftaran->fototransfer) Storage::disk('public')->delete($pendaftaran->fototransfer);
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/pendaftaran', 'public');
        }

        $pendaftaran->update($validated);

        return redirect()->route('admin.pendaftarans.index')
            ->with('success', 'Data pendaftaran berhasil diupdate.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->fotokk) Storage::disk('public')->delete($pendaftaran->fotokk);
        if ($pendaftaran->fotoakta) Storage::disk('public')->delete($pendaftaran->fotoakta);
        if ($pendaftaran->fototransfer) Storage::disk('public')->delete($pendaftaran->fototransfer);

        $pendaftaran->delete();

        return redirect()->route('admin.pendaftarans.index')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function export()
    {
        $filename = 'pendaftarans-' . now()->format('Y-m-d-His') . '.xlsx';

        return SimpleExcelWriter::streamDownload($filename)
            ->addHeader([
                'ID', 'Nama', 'NISN', 'NIK', 'Jenjang', 'Status',
                'Tempat Lahir', 'Tanggal Lahir', 'No HP Ayah', 'No HP Ibu',
                'Alamat', 'Kelas', 'Tahun Ajaran', 'Created At'
            ])
            ->addRows(Pendaftaran::latest()->get()->map(function($p) {
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
                    'alamat' => $p->alamat_rumah_tinggal ?? $p->alamat,

                    'tahun_ajaran' => $p->tahun_ajaran,
                    'created_at' => $p->created_at->format('Y-m-d H:i'),
                ];
            }))
            ->toBrowser();
    }
}
