<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakRaporController extends Controller
{
    public function generate(Request $request)
    {
        $siswaId = $request->input('siswa_id');
        $siswaType = $request->input('siswa_type');
        $semester = $request->input('semester');
        $tahunAjaran = $request->input('tahun_ajaran');

        // Get siswa instance
        $siswa = $siswaType::find($siswaId);
        
        if (!$siswa) {
            abort(404, 'Siswa tidak ditemukan');
        }

        // Get kelas
        $kelas = $siswa->kelas;
        
        // Get all nilai for this siswa
        $nilaiCollection = Nilai::where('siswa_id', $siswaId)
            ->where('siswa_type', $siswaType)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->with('mataPelajaran')
            ->get();

        // Group nilai by mata pelajaran
        $nilaiPerMapel = [];
        $totalRataRata = 0;
        $jumlahMapel = 0;

        foreach ($nilaiCollection->groupBy('mata_pelajaran_id') as $mapelId => $nilaiGroup) {
            $mataPelajaran = $nilaiGroup->first()->mataPelajaran;
            
            $pengetahuan = $nilaiGroup->where('jenis_nilai', 'Pengetahuan')->first();
            $keterampilan = $nilaiGroup->where('jenis_nilai', 'Keterampilan')->first();
            $sikap = $nilaiGroup->where('jenis_nilai', 'Sikap')->first();

            $nilaiPengetahuan = $pengetahuan ? $pengetahuan->nilai : 0;
            $nilaiKeterampilan = $keterampilan ? $keterampilan->nilai : 0;
            $nilaiSikap = $sikap ? $sikap->nilai : 0;

            // Calculate average for this mapel
            $count = 0;
            $sum = 0;
            
            if ($nilaiPengetahuan > 0) { $sum += $nilaiPengetahuan; $count++; }
            if ($nilaiKeterampilan > 0) { $sum += $nilaiKeterampilan; $count++; }
            if ($nilaiSikap > 0) { $sum += $nilaiSikap; $count++; }
            
            $rataRata = $count > 0 ? round($sum / $count, 2) : 0;
            
            // Calculate predikat
            $predikat = $this->calculatePredikat($rataRata);

            $nilaiPerMapel[] = [
                'mata_pelajaran' => $mataPelajaran->nama,
                'kode' => $mataPelajaran->kode,
                'kkm' => $mataPelajaran->kkm,
                'pengetahuan' => $nilaiPengetahuan,
                'predikat_pengetahuan' => $pengetahuan ? $pengetahuan->predikat : '-',
                'deskripsi_pengetahuan' => $pengetahuan ? $pengetahuan->deskripsi : '',
                'keterampilan' => $nilaiKeterampilan,
                'predikat_keterampilan' => $keterampilan ? $keterampilan->predikat : '-',
                'deskripsi_keterampilan' => $keterampilan ? $keterampilan->deskripsi : '',
                'sikap' => $nilaiSikap,
                'predikat_sikap' => $sikap ? $sikap->predikat : '-',
                'deskripsi_sikap' => $sikap ? $sikap->deskripsi : '',
                'rata_rata' => $rataRata,
                'predikat' => $predikat,
            ];

            if ($rataRata > 0) {
                $totalRataRata += $rataRata;
                $jumlahMapel++;
            }
        }

        // Calculate overall average
        $rataRataKeseluruhan = $jumlahMapel > 0 ? round($totalRataRata / $jumlahMapel, 2) : 0;
        $predikatKeseluruhan = $this->calculatePredikat($rataRataKeseluruhan);

        // Prepare data for PDF
        $data = [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran,
            'nilai_per_mapel' => $nilaiPerMapel,
            'rata_rata_keseluruhan' => $rataRataKeseluruhan,
            'predikat_keseluruhan' => $predikatKeseluruhan,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.rapor', $data)
            ->setPaper('a4', 'portrait');

        // Download PDF
        $filename = 'Rapor-' . str_replace(' ', '-', $siswa->nama) . '-Sem' . $semester . '-' . str_replace('/', '-', $tahunAjaran) . '.pdf';
        
        return $pdf->download($filename);
    }

    private function calculatePredikat($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}
