<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mtsputri;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MtsputriController extends Controller
{
    public function index(Request $request)
    {
        $query = Mtsputri::with('kelas')->latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $mtsputris = $query->paginate(15)->withQueryString();

        return view('admin.mtsputris.index', compact('mtsputris'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.mtsputris.create', compact('kelas'));
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
            'kelas_id' => 'nullable|exists:kelas,id',
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
            $validated['fotokk'] = $request->file('fotokk')->store('documents/mtsputri', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/mtsputri', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/mtsputri', 'public');
        }

        Mtsputri::create($validated);

        return redirect()->route('admin.mtsputris.index')
            ->with('success', 'Data siswi MTs Putri berhasil ditambahkan.');
    }

    public function show(Mtsputri $mtsputri)
    {
        $mtsputri->load('kelas');
        return view('admin.mtsputris.show', compact('mtsputri'));
    }

    public function edit(Mtsputri $mtsputri)
    {
        $kelas = Kelas::all();
        return view('admin.mtsputris.edit', compact('mtsputri', 'kelas'));
    }

    public function update(Request $request, Mtsputri $mtsputri)
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
            'kelas_id' => 'nullable|exists:kelas,id',
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
            if ($mtsputri->fotokk) Storage::disk('public')->delete($mtsputri->fotokk);
            $validated['fotokk'] = $request->file('fotokk')->store('documents/mtsputri', 'public');
        }
        if ($request->hasFile('fotoakta')) {
            if ($mtsputri->fotoakta) Storage::disk('public')->delete($mtsputri->fotoakta);
            $validated['fotoakta'] = $request->file('fotoakta')->store('documents/mtsputri', 'public');
        }
        if ($request->hasFile('fototransfer')) {
            if ($mtsputri->fototransfer) Storage::disk('public')->delete($mtsputri->fototransfer);
            $validated['fototransfer'] = $request->file('fototransfer')->store('documents/mtsputri', 'public');
        }

        $mtsputri->update($validated);

        return redirect()->route('admin.mtsputris.index')
            ->with('success', 'Data siswi MTs Putri berhasil diupdate.');
    }

    public function destroy(Mtsputri $mtsputri)
    {
        if ($mtsputri->fotokk) Storage::disk('public')->delete($mtsputri->fotokk);
        if ($mtsputri->fotoakta) Storage::disk('public')->delete($mtsputri->fotoakta);
        if ($mtsputri->fototransfer) Storage::disk('public')->delete($mtsputri->fototransfer);

        $mtsputri->delete();

        return redirect()->route('admin.mtsputris.index')
            ->with('success', 'Data siswi MTs Putri berhasil dihapus.');
    }
}
