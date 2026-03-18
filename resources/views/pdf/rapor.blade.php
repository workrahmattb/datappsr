<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Siswa - {{ $siswa->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .title {
            text-align: center;
            margin: 15px 0;
        }
        
        .title h3 {
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .identitas {
            margin-bottom: 15px;
        }
        
        .identitas table {
            width: 100%;
        }
        
        .identitas td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .identitas td:first-child {
            width: 150px;
        }
        
        .identitas td:nth-child(2) {
            width: 10px;
        }
        
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .nilai-table th,
        .nilai-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        
        .nilai-table th {
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 11px;
        }
        
        .nilai-table td {
            font-size: 11px;
        }
        
        .nilai-table td.left {
            text-align: left;
        }
        
        .nilai-table td.center {
            text-align: center;
        }
        
        .summary {
            margin: 20px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #000;
        }
        
        .summary table {
            width: 100%;
        }
        
        .summary td {
            padding: 5px;
        }
        
        .summary td:first-child {
            width: 200px;
            font-weight: bold;
        }
        
        .signature {
            margin-top: 30px;
        }
        
        .signature table {
            width: 100%;
        }
        
        .signature td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        
        .signature .name {
            margin-top: 60px;
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
        }
        
        .catatan {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #000;
            min-height: 80px;
        }
        
        .catatan h4 {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .predikat-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .predikat-A { background-color: #4CAF50; color: white; }
        .predikat-B { background-color: #2196F3; color: white; }
        .predikat-C { background-color: #FFC107; color: black; }
        .predikat-D { background-color: #FF5722; color: white; }
        .predikat-E { background-color: #9E9E9E; color: white; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>PONDOK PESANTREN SALAFIYAH RAHMATUL UMMAH</h1>
        <h2>MADRASAH {{ $kelas->tingkat === 'MTs' ? 'TSANAWIYAH' : 'ALIYAH' }}</h2>
        <p>Alamat: [Alamat Sekolah]</p>
        <p>Telp: [Nomor Telepon] | Email: [Email Sekolah]</p>
    </div>

    <!-- Title -->
    <div class="title">
        <h3>LAPORAN HASIL BELAJAR SISWA (RAPOR)</h3>
        <p>Semester {{ $semester }} Tahun Pelajaran {{ $tahun_ajaran }}</p>
    </div>

    <!-- Identitas Siswa -->
    <div class="identitas">
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td><strong>{{ $siswa->nama }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $siswa->nis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $kelas->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Wali Kelas</td>
                <td>:</td>
                <td>{{ $kelas->guru->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Nilai -->
    <table class="nilai-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">No</th>
                <th rowspan="2" style="width: 150px;">Mata Pelajaran</th>
                <th rowspan="2" style="width: 40px;">KKM</th>
                <th colspan="2">Pengetahuan</th>
                <th colspan="2">Keterampilan</th>
                <th colspan="2">Sikap</th>
                <th rowspan="2" style="width: 50px;">Rata-rata</th>
                <th rowspan="2" style="width: 50px;">Predikat</th>
            </tr>
            <tr>
                <th style="width: 40px;">Nilai</th>
                <th style="width: 40px;">Pred.</th>
                <th style="width: 40px;">Nilai</th>
                <th style="width: 40px;">Pred.</th>
                <th style="width: 40px;">Nilai</th>
                <th style="width: 40px;">Pred.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai_per_mapel as $index => $mapel)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="left">{{ $mapel['mata_pelajaran'] }}</td>
                <td class="center">{{ $mapel['kkm'] }}</td>
                <td class="center">{{ $mapel['pengetahuan'] > 0 ? $mapel['pengetahuan'] : '-' }}</td>
                <td class="center">{{ $mapel['predikat_pengetahuan'] }}</td>
                <td class="center">{{ $mapel['keterampilan'] > 0 ? $mapel['keterampilan'] : '-' }}</td>
                <td class="center">{{ $mapel['predikat_keterampilan'] }}</td>
                <td class="center">{{ $mapel['sikap'] > 0 ? $mapel['sikap'] : '-' }}</td>
                <td class="center">{{ $mapel['predikat_sikap'] }}</td>
                <td class="center"><strong>{{ $mapel['rata_rata'] > 0 ? $mapel['rata_rata'] : '-' }}</strong></td>
                <td class="center"><strong>{{ $mapel['predikat'] }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="center">Belum ada nilai untuk semester ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary -->
    @if(count($nilai_per_mapel) > 0)
    <div class="summary">
        <table>
            <tr>
                <td>Rata-rata Keseluruhan</td>
                <td>: <strong>{{ $rata_rata_keseluruhan }}</strong></td>
            </tr>
            <tr>
                <td>Predikat Keseluruhan</td>
                <td>: <strong class="predikat-badge predikat-{{ $predikat_keseluruhan }}">{{ $predikat_keseluruhan }}</strong></td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Catatan Wali Kelas -->
    <div class="catatan">
        <h4>Catatan Wali Kelas:</h4>
        <p style="margin-top: 10px;">
            <!-- Catatan bisa diisi manual atau dari database -->
        </p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <table>
            <tr>
                <td>
                    <p>Mengetahui,</p>
                    <p><strong>Kepala Sekolah</strong></p>
                    <div class="name">
                        <p>(...........................)</p>
                    </div>
                </td>
                <td>
                    <p>Wali Kelas</p>
                    <p>&nbsp;</p>
                    <div class="name">
                        <p>{{ $kelas->guru->name ?? '(...........................)' }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Keterangan Predikat -->
    <div style="margin-top: 20px; font-size: 10px;">
        <p><strong>Keterangan Predikat:</strong></p>
        <p>A = 90-100 (Sangat Baik) | B = 80-89 (Baik) | C = 70-79 (Cukup) | D = 60-69 (Kurang) | E = 0-59 (Sangat Kurang)</p>
    </div>
</body>
</html>
