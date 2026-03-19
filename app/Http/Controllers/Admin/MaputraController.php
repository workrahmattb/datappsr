<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maputra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaputraController extends Controller
{
    public function index(Request $request)
    {
        $query = Maputra::latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $maputras = $query->paginate(15)->withQueryString();

        return view('admin.maputras.index', compact('maputras'));
    }

    public function create()
    {
        return view('admin.maputras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        if ($request->hasFile('fotokk')) {
            $validated['fotokk'] = $request->file('fotokk')->store('documents/maputra', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/maputra', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/maputra', 'public');
        }

        Maputra::create($validated);

        return redirect()->route('admin.maputras.index')
            ->with('success', 'Data siswa MA Putra berhasil ditambahkan.');
    }

    public function show(Maputra $maputra)
    {
        return view('admin.maputras.show', compact('maputra'));
    }

    public function edit(Maputra $maputra)
    {
        return view('admin.maputras.edit', compact('maputra'));
    }

    public function update(Request $request, Maputra $maputra)
    {
        $validated = $request->validate([
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
        ]);

        if ($request->hasFile('fotokk')) {
            if ($maputra->fotokk) Storage::disk('public')->delete($maputra->fotokk);
            $validated['fotokk'] = $request->file('fotokk')->store('documents/maputra', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            if ($maputra->fotoakta) Storage::disk('public')->delete($maputra->fotoakta);
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/maputra', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            if ($maputra->fototransfer) Storage::disk('public')->delete($maputra->fototransfer);
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/maputra', 'public');
        }

        $maputra->update($validated);

        return redirect()->route('admin.maputras.index')
            ->with('success', 'Data siswa MA Putra berhasil diupdate.');
    }

    public function destroy(Maputra $maputra)
    {
        if ($maputra->fotokk) Storage::disk('public')->delete($maputra->fotokk);
        if ($maputra->fotoakta) Storage::disk('public')->delete($maputra->fotoakta);
        if ($maputra->fototransfer) Storage::disk('public')->delete($maputra->fototransfer);

        $maputra->delete();

        return redirect()->route('admin.maputras.index')
            ->with('success', 'Data siswa MA Putra berhasil dihapus.');
    }

    public function export(\Illuminate\Http\Request $request)
    {
        $filename = 'data-maputra-' . now()->format('Ymd-His') . '.xlsx';
        
        $query = Maputra::query();
        
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        return \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload($filename)
            ->addHeader([
                'No', 'Nama', 'NISN', 'NIS', 'NIK', 'Tahun Ajaran',
                'Tempat Lahir', 'Tanggal Lahir', 'Anak Ke', 'Jml Saudara', 'No KK',
                'Nama Ayah', 'No HP Ayah', 'Nama Ibu', 'No HP Ibu',
                'Alamat', 'Dibuat Pada'
            ])
            ->addRows($query->latest()->get()->map(function($p, $index) {
                return [
                    'No' => $index + 1,
                    'Nama' => $p->nama,
                    'NISN' => $p->nisn,
                    'NIS' => $p->nis,
                    'NIK' => $p->nik,
                    'Tahun Ajaran' => $p->tahun_ajaran,
                    'Tempat Lahir' => $p->tempat_lahir,
                    'Tanggal Lahir' => $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') : '-',
                    'Anak Ke' => $p->anak_ke,
                    'Jml Saudara' => $p->jumlah_saudara,
                    'No KK' => $p->kk,
                    'Nama Ayah' => $p->nama_ayah,
                    'No HP Ayah' => $p->no_hp_ayah,
                    'Nama Ibu' => $p->nama_ibu,
                    'No HP Ibu' => $p->no_hp_ibu,
                    'Alamat' => $p->alamat_rumah_tinggal ?? ($p->desa . ' ' . $p->kecamatan),
                    'Dibuat Pada' => $p->created_at->format('Y-m-d H:i')
                ];
            }))
            ->toBrowser();
    }
}
