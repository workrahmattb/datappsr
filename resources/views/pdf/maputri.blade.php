<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: A4;
            margin: 40px 40px 80px 40px;
        }

        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .school-logo {
            width: 80px;
            margin-bottom: 5px;
        }

        .school-name {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
            color: #1b5e20;
        }

        .school-address {
            font-size: 12px;
            color: #444;
        }

        .divider {
            border: 0;
            border-top: 2px solid #1b5e20;
            margin: 10px 0 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 8px;
            color: #1b5e20;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            width: 30%;
            background: #e8f5e9;
            color: #1b5e20;
            font-weight: bold;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }

        .signature .name {
            font-weight: bold;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    @php
        use Carbon\Carbon;
        $tgl = Carbon::parse($record->tanggal_lahir);
    @endphp

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('logo-ponpes.png') }}" class="school-logo">
        <div class="school-name">Pondok Pesantren Syafa'aturrasul</div>
        <div class="school-address">Kuantan Singingi, Riau</div>
    </div>

    <hr class="divider">

    {{-- TITLE --}}
    <div class="section-title">Data Santriwati MA Putri Pondok Pesantren Syafa'aturrasul</div>

    {{-- TABLE --}}
    <table>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $record->nama }}</td>
        </tr>
        <tr>
            <th>NIS</th>
            <td>{{ $record->nis }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $record->kelas }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $tgl->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $record->alamat }}</td>
        </tr>
    </table>

    {{-- FOOTER TANDA TANGAN --}}
    <div class="signature">
        Kuantan Singingi, {{ now()->translatedFormat('d F Y') }}<br>
        Kepala MTs Putri,<br><br><br><br>

        <span class="name">Ustadzah ................................</span>
    </div>

</body>

</html>
