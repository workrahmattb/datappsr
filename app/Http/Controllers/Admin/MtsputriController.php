<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mtsputri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MtsputriController extends Controller
{
    public function index(Request $request)
    {
        $query = Mtsputri::latest();

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
        return view('admin.mtsputris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|size:16',
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
            'nik_ayah' => 'nullable|string|size:16',
            'nama_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|size:16',
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

        // Handle file uploads
        if ($request->hasFile('fotokk')) {
            $ext = $request->file('fotokk')->getClientOriginalExtension();
            $validated['fotokk'] = $request->file('fotokk')->storeAs('documents/mtsputri', 'kk_' . $validated['nama'] . '.' . $ext, 'public');
        }
        if ($request->hasFile('fotoakta')) {
            $ext = $request->file('fotoakta')->getClientOriginalExtension();
            $validated['fotoakta'] = $request->file('fotoakta')->storeAs('documents/mtsputri', 'akta_' . $validated['nama'] . '.' . $ext, 'public');
        }
        if ($request->hasFile('fototransfer')) {
            $ext = $request->file('fototransfer')->getClientOriginalExtension();
            $validated['fototransfer'] = $request->file('fototransfer')->storeAs('documents/mtsputri', 'tf_' . $validated['nama'] . '.' . $ext, 'public');
        }

        Mtsputri::create($validated);

        return redirect()->route('admin.mtsputris.index')
            ->with('success', 'Data siswi MTs Putri berhasil ditambahkan.');
    }

    public function show(Mtsputri $mtsputri)
    {
        return view('admin.mtsputris.show', compact('mtsputri'));
    }

    public function edit(Mtsputri $mtsputri)
    {
        return view('admin.mtsputris.edit', compact('mtsputri'));
    }

    public function update(Request $request, Mtsputri $mtsputri)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|size:16',
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
            'nik_ayah' => 'nullable|string|size:16',
            'nama_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|size:16',
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
            $ext = $request->file('fotokk')->getClientOriginalExtension();
            $validated['fotokk'] = $request->file('fotokk')->storeAs('documents/mtsputri', 'kk_' . $validated['nama'] . '.' . $ext, 'public');
        }
        if ($request->hasFile('fotoakta')) {
            if ($mtsputri->fotoakta) Storage::disk('public')->delete($mtsputri->fotoakta);
            $ext = $request->file('fotoakta')->getClientOriginalExtension();
            $validated['fotoakta'] = $request->file('fotoakta')->storeAs('documents/mtsputri', 'akta_' . $validated['nama'] . '.' . $ext, 'public');
        }
        if ($request->hasFile('fototransfer')) {
            if ($mtsputri->fototransfer) Storage::disk('public')->delete($mtsputri->fototransfer);
            $ext = $request->file('fototransfer')->getClientOriginalExtension();
            $validated['fototransfer'] = $request->file('fototransfer')->storeAs('documents/mtsputri', 'tf_' . $validated['nama'] . '.' . $ext, 'public');
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

    public function export(\Illuminate\Http\Request $request)
    {
        $filename = 'data-mtsputri-' . now()->format('Ymd-His') . '.xlsx';

        $query = Mtsputri::query();

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        return \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload($filename)
            ->addHeader([
                'ID', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'NISN', 'NIS', 'NIK', 'KK', 'Nama KK',
                'Anak Ke', 'Jumlah Saudara', 'Tahun Ajaran', 'Tanggal Masuk', 'KKS', 'PKH', 'KIP',
                'NPSN Sekolah Sebelumnya', 'Nama Sekolah Sebelumnya', 'Alamat Sekolah Sebelumnya',
                'Kecamatan Sekolah Sebelumnya', 'Kabupaten Sekolah Sebelumnya', 'Provinsi Sekolah Sebelumnya',
                'NIK Ayah', 'Nama Ayah', 'Tempat Lahir Ayah', 'Tanggal Lahir Ayah', 'Status Ayah',
                'No HP Ayah', 'Pendidikan Ayah', 'Pekerjaan Ayah', 'Penghasilan Ayah',
                'NIK Ibu', 'Nama Ibu', 'Tempat Lahir Ibu', 'Tanggal Lahir Ibu', 'Status Ibu',
                'No HP Ibu', 'Pendidikan Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu',
                'Alamat', 'RT', 'RW', 'Desa', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Kode Pos',
                'NIK Wali', 'Nama Wali', 'Tempat Lahir Wali', 'Tanggal Lahir Wali', 'Status Wali', 'No HP Wali',
                'Pendidikan Wali', 'Pekerjaan Wali', 'Penghasilan Wali',
                'Created At', 'Updated At'
            ])
            ->addRows($query->latest()->get()->map(function($s) {
                return [
                    'id' => $s->id,
                    'nama' => $s->nama,
                    'tempat_lahir' => $s->tempat_lahir,
                    'tanggal_lahir' => $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('Y-m-d') : '',
                    'nisn' => $s->nisn,
                    'nis' => $s->nis,
                    'nik' => $s->nik,
                    'kk' => $s->kk,
                    'nama_kk' => $s->nama_kk,
                    'anak_ke' => $s->anak_ke,
                    'jumlah_saudara' => $s->jumlah_saudara,
                    'tahun_ajaran' => $s->tahun_ajaran,
                    'tgl_masuk' => $s->tgl_masuk ? \Carbon\Carbon::parse($s->tgl_masuk)->format('Y-m-d') : '',
                    'kks' => $s->kks,
                    'pkh' => $s->pkh,
                    'kip' => $s->kip,
                    'npsn_sekolah_sebelumnya' => $s->npsn_sekolah_sebelumnya,
                    'nama_sekolah_sebelumnya' => $s->nama_sekolah_sebelumnya,
                    'alamat_sekolah_sebelumnya' => $s->alamat_sekolah_sebelumnya,
                    'kecamatan_sekolah_sebelumnya' => $s->kecamatan_sekolah_sebelumnya,
                    'kabupaten_sekolah_sebelumnya' => $s->kabupaten_sekolah_sebelumnya,
                    'provinsi_sekolah_sebelumnya' => $s->provinsi_sekolah_sebelumnya,
                    'nik_ayah' => $s->nik_ayah,
                    'nama_ayah' => $s->nama_ayah,
                    'tempat_lahir_ayah' => $s->tempat_lahir_ayah,
                    'tanggal_lahir_ayah' => $s->tanggal_lahir_ayah ? \Carbon\Carbon::parse($s->tanggal_lahir_ayah)->format('Y-m-d') : '',
                    'status_ayah' => $s->status_ayah,
                    'no_hp_ayah' => $s->no_hp_ayah,
                    'pendidikan_ayah' => $s->pendidikan_ayah,
                    'pekerjaan_ayah' => $s->pekerjaan_ayah,
                    'penghasilan_ayah' => $s->penghasilan_ayah,
                    'nik_ibu' => $s->nik_ibu,
                    'nama_ibu' => $s->nama_ibu,
                    'tempat_lahir_ibu' => $s->tempat_lahir_ibu,
                    'tanggal_lahir_ibu' => $s->tanggal_lahir_ibu ? \Carbon\Carbon::parse($s->tanggal_lahir_ibu)->format('Y-m-d') : '',
                    'status_ibu' => $s->status_ibu,
                    'no_hp_ibu' => $s->no_hp_ibu,
                    'pendidikan_ibu' => $s->pendidikan_ibu,
                    'pekerjaan_ibu' => $s->pekerjaan_ibu,
                    'penghasilan_ibu' => $s->penghasilan_ibu,
                    'alamat_rumah_tinggal' => $s->alamat_rumah_tinggal,
                    'rt' => $s->rt,
                    'rw' => $s->rw,
                    'desa' => $s->desa,
                    'kecamatan' => $s->kecamatan,
                    'kabupaten' => $s->kabupaten,
                    'provinsi' => $s->provinsi,
                    'kode_pos' => $s->kode_pos,
                    'nik_wali' => $s->nik_wali,
                    'nama_wali' => $s->nama_wali,
                    'tempat_lahir_wali' => $s->tempat_lahir_wali,
                    'tanggal_lahir_wali' => $s->tanggal_lahir_wali ? \Carbon\Carbon::parse($s->tanggal_lahir_wali)->format('Y-m-d') : '',
                    'status_wali' => $s->status_wali,
                    'no_hp_wali' => $s->no_hp_wali,
                    'pendidikan_wali' => $s->pendidikan_wali,
                    'pekerjaan_wali' => $s->pekerjaan_wali,
                    'penghasilan_wali' => $s->penghasilan_wali,
                    'created_at' => $s->created_at->format('Y-m-d H:i'),
                    'updated_at' => $s->updated_at->format('Y-m-d H:i'),
                ];
            }))
            ->toBrowser();
    }
}
