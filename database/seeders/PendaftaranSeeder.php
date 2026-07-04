<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use App\Models\Mtsputra;
use App\Models\Mtsputri;
use App\Models\Maputra;
use App\Models\Maputri;

use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat data dummy:
     * - 5 pendaftaran pending (belum daftar ulang) — tersebar di 4 jenjang
     * - 4 pendaftaran completed (sudah daftar ulang → terisi juga di tabel siswa)
     * - Total pendaftaran: 9
     * - Total siswa: 4 (1 per jenjang)
     */
    public function run(): void
    {
        $tahunAjaran = '2026/2027';

        // ===================================================================
        // DATA PENDAFTARAN PENDING (Belum Daftar Ulang)
        // ===================================================================

        $pendingData = [
            // MTs Putra
            [
                'nisn' => '1234567890',
                'nik' => '3501141205120001',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Ahmad Fauzi',
                'jenjang_pendidikan' => 'MTs Putra',
                'tempat_lahir' => 'Pasuruan',
                'tanggal_lahir' => '2012-05-14',
                'asal_sekolah' => 'SDN Kebon Agung 1',
                'alamat' => 'Jl. Raya Wonorejo No. 10, Kec. Kraton, Pasuruan',
                'nama_ayah' => 'H. Supriyanto',
                'nama_ibu' => 'Hj. Siti Aminah',
                'no_hp' => '081234567890',
                'status_pendaftaran' => 'pending',
            ],
            // MTs Putri
            [
                'nisn' => '2234567890',
                'nik' => '3515082002130002',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Aisyah Nurul Hidayah',
                'jenjang_pendidikan' => 'MTs Putri',
                'tempat_lahir' => 'Sidoarjo',
                'tanggal_lahir' => '2013-02-20',
                'asal_sekolah' => 'MI Al-Hidayah',
                'alamat' => 'Perumahan Pondok Mutiara Blok A3, Sidoarjo',
                'nama_ayah' => 'Drs. Ahmad Syafii',
                'nama_ibu' => 'Dra. Masruroh',
                'no_hp' => '082345678901',
                'status_pendaftaran' => 'pending',
            ],
            // MA Putra
            [
                'nisn' => '3234567890',
                'nik' => '3573081108090003',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Muhammad Rizky Pratama',
                'jenjang_pendidikan' => 'MA Putra',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2009-11-08',
                'asal_sekolah' => 'MTs Negeri 1 Malang',
                'alamat' => 'Jl. Ijen No. 45, Malang',
                'nama_ayah' => 'Ir. H. Abdul Malik',
                'nama_ibu' => 'Hj. Lailatul Badriyah',
                'no_hp' => '083456789012',
                'status_pendaftaran' => 'pending',
            ],
            // MA Putri (2 data)
            [
                'nisn' => '4234567890',
                'nik' => '3515252507100004',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Zahra Amalia Putri',
                'jenjang_pendidikan' => 'MA Putri',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2010-07-25',
                'asal_sekolah' => 'MTs Darul Ulum',
                'alamat' => 'Jl. Raya Tembaan No. 88, Bangil, Pasuruan',
                'nama_ayah' => 'H. Moch. Yasin',
                'nama_ibu' => 'Ny. Hj. Khodijah',
                'no_hp' => '084567890123',
                'status_pendaftaran' => 'pending',
            ],
            [
                'nisn' => '5234567890',
                'nik' => '3574091501100005',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Naila Fitriana Dewi',
                'jenjang_pendidikan' => 'MA Putri',
                'tempat_lahir' => 'Probolinggo',
                'tanggal_lahir' => '2010-01-15',
                'asal_sekolah' => 'MTs Al-Ikhlas',
                'alamat' => 'Jl. Mastrip No. 12, Probolinggo',
                'nama_ayah' => 'H. Mahrus Ali',
                'nama_ibu' => 'Hj. Fatimah',
                'no_hp' => '085678901234',
                'status_pendaftaran' => 'pending',
            ],
        ];

        foreach ($pendingData as $data) {
            Pendaftaran::create($data);
        }

        // ===================================================================
        // DATA SISWA (Sudah Daftar Ulang → Completed)
        // ===================================================================

        $siswaData = [
            // MTs Putra
            [
                'nisn' => '6234567890',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Fathan Muhammad Al-Ghifari',
                'jenjang_pendidikan' => 'MTs Putra',
                'tempat_lahir' => 'Pasuruan',
                'tanggal_lahir' => '2013-06-10',
                'asal_sekolah' => 'SDN Bangil 3',
                'alamat' => 'Ds. Kedungringin RT 02 RW 01, Kec. Beji, Pasuruan',
                'nama_ayah' => 'Moch. Sholeh',
                'nama_ibu' => 'Siti Maryam',
                'no_hp' => '086789012345',
                'status_pendaftaran' => 'completed',
            ],
            // MTs Putri
            [
                'nisn' => '7234567890',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Khumairoh Azzahra',
                'jenjang_pendidikan' => 'MTs Putri',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2015-03-22',
                'asal_sekolah' => 'MI Bahrul Ulum',
                'alamat' => 'Perum Griya Permata Asri Blok C5, Surabaya',
                'nama_ayah' => 'Drs. H. Imam Bukhori',
                'nama_ibu' => 'Hj. Siti Romlah',
                'no_hp' => '087890123456',
                'status_pendaftaran' => 'completed',
            ],
            // MA Putra
            [
                'nisn' => '8234567890',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'M. Faqih Al-Munawwar',
                'jenjang_pendidikan' => 'MA Putra',
                'tempat_lahir' => 'Gresik',
                'tanggal_lahir' => '2007-12-05',
                'asal_sekolah' => 'MTs Al-Fattah',
                'alamat' => 'Jl. Raya Manyar No. 78, Gresik',
                'nama_ayah' => 'K. Ahmad Dahlan',
                'nama_ibu' => 'Ny. Khadijah',
                'no_hp' => '088901234567',
                'status_pendaftaran' => 'completed',
            ],
            // MA Putri
            [
                'nisn' => '9234567890',
                'tahun_ajaran' => $tahunAjaran,
                'nama' => 'Salma Nur Azizah',
                'jenjang_pendidikan' => 'MA Putri',
                'tempat_lahir' => 'Pasuruan',
                'tanggal_lahir' => '2008-09-18',
                'asal_sekolah' => 'MTs Nurul Jadid',
                'alamat' => 'Ds. Plinggisan RT 01 RW 02, Kraton, Pasuruan',
                'nama_ayah' => 'H. Shodiqin',
                'nama_ibu' => 'Hj. Halimah',
                'no_hp' => '089012345678',
                'status_pendaftaran' => 'completed',
            ],
        ];

        // --- Mapping jenjang ke model & data siswa ---
        $modelMap = [
            'MTs Putra' => Mtsputra::class,
            'MTs Putri' => Mtsputri::class,
            'MA Putra' => Maputra::class,
            'MA Putri' => Maputri::class,
        ];

        $typeMap = [
            'MTs Putra' => 'mtsputra',
            'MTs Putri' => 'mtsputri',
            'MA Putra' => 'maputra',
            'MA Putri' => 'maputri',
        ];

        foreach ($siswaData as $data) {
            $jenjang = $data['jenjang_pendidikan'];
            $modelClass = $modelMap[$jenjang];
            $type = $typeMap[$jenjang];

            // Simpan ke tabel pendaftaran
            $pendaftaran = Pendaftaran::create($data);

            // Simpan ke tabel siswa sesuai jenjang
            $studentData = [
                'nisn' => $data['nisn'],
                'tahun_ajaran' => $data['tahun_ajaran'],
                'nama' => $data['nama'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'nama_sekolah_sebelumnya' => $data['asal_sekolah'],
                'nama_ayah' => $data['nama_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'nik' => '1234567890123456',
                'kk' => '1234567890123456',
                'nama_kk' => 'Kepala Keluarga',
                'nis' => '12345',
                'anak_ke' => '2',
                'jumlah_saudara' => '3',
                'tgl_masuk' => now()->format('Y-m-d'),
                'status_milik' => 'Milik Sendiri',
                'desa' => 'Desa Contoh',
                'kecamatan' => 'Kecamatan Contoh',
                'kabupaten' => 'Kabupaten Contoh',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '67152',
                'nik_ayah' => '1234567890123450',
                'tempat_lahir_ayah' => 'Pasuruan',
                'tanggal_lahir_ayah' => '1980-01-01',
                'status_ayah' => 'Masih Hidup',
                'no_hp_ayah' => '081111111111',
                'pendidikan_ayah' => 'SMA/SMK Sederajat',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => 'Rp. 1.000.000 - Rp. 2.000.000',
                'nik_ibu' => '1234567890123451',
                'tempat_lahir_ibu' => 'Pasuruan',
                'tanggal_lahir_ibu' => '1985-03-15',
                'status_ibu' => 'Masih Hidup',
                'no_hp_ibu' => '082222222222',
                'pendidikan_ibu' => 'SMA/SMK Sederajat',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 'Tidak Ada',
                'rt' => '001',
                'rw' => '002',
            ];

            $student = $modelClass::create($studentData);

            // Update pendaftaran: tandai selesai, simpan relasi ke siswa
            $pendaftaran->update([
                'status_pendaftaran' => 'completed',
                'student_id' => $student->id,
                'student_type' => $type,
            ]);
        }

        // Output
        $totalPendaftaran = Pendaftaran::count();
        $totalMtsputra = Mtsputra::count();
        $totalMtsputri = Mtsputri::count();
        $totalMaputra = Maputra::count();
        $totalMaputri = Maputri::count();

        $this->command->info('✅ Seeder data pendaftaran & siswa berhasil!');
        $this->command->info("   • Pendaftaran: {$totalPendaftaran} data");
        $this->command->info("   • MTs Putra: {$totalMtsputra} siswa");
        $this->command->info("   • MTs Putri: {$totalMtsputri} siswa");
        $this->command->info("   • MA Putra: {$totalMaputra} siswa");
        $this->command->info("   • MA Putri: {$totalMaputri} siswa");
    }
}
