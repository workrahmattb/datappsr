<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Student data fields
            $table->string('nik')->nullable()->after('jenjang_pendidikan');
            $table->string('kk')->nullable()->after('nik');
            $table->string('nama_kk')->nullable()->after('kk');
            $table->string('nis')->nullable()->after('nisn');
            $table->string('anak_ke')->nullable()->after('nis');
            $table->string('jumlah_saudara')->nullable()->after('anak_ke');
            
            // Kelas relationship
            $table->foreignId('kelas_id')->nullable()->after('tahun_ajaran')->constrained('kelas')->onDelete('set null');
            
            // Additional student info
            $table->string('tgl_masuk')->nullable()->after('kelas_id');
            $table->string('kks')->nullable()->after('tgl_masuk');
            $table->string('pkh')->nullable()->after('kks');
            $table->string('kip')->nullable()->after('pkh');
            
            // Previous school info
            $table->string('jenjang_pendidikan_sebelumnya')->nullable()->after('kip');
            $table->string('status_sekolah_sebelumnya')->nullable()->after('jenjang_pendidikan_sebelumnya');
            $table->string('nama_sekolah_sebelumnya')->nullable()->after('status_sekolah_sebelumnya');
            $table->string('npsn_sekolah_sebelumnya')->nullable()->after('nama_sekolah_sebelumnya');
            $table->string('alamat_sekolah_sebelumnya')->nullable()->after('npsn_sekolah_sebelumnya');
            $table->string('kecamatan_sekolah_sebelumnya')->nullable()->after('alamat_sekolah_sebelumnya');
            $table->string('kabupaten_sekolah_sebelumnya')->nullable()->after('kecamatan_sekolah_sebelumnya');
            $table->string('provinsi_sekolah_sebelumnya')->nullable()->after('kabupaten_sekolah_sebelumnya');
            
            // Father info
            $table->string('nik_ayah')->nullable()->after('provinsi_sekolah_sebelumnya');
            $table->string('tempat_lahir_ayah')->nullable()->after('nama_ayah');
            $table->date('tanggal_lahir_ayah')->nullable()->after('tempat_lahir_ayah');
            $table->string('status_ayah')->nullable()->after('tanggal_lahir_ayah');
            $table->string('no_hp_ayah')->nullable()->after('status_ayah');
            $table->string('pendidikan_ayah')->nullable()->after('no_hp_ayah');
            $table->string('pekerjaan_ayah')->nullable()->after('pendidikan_ayah');
            $table->string('penghasilan_ayah')->nullable()->after('pekerjaan_ayah');
            
            // Mother info
            $table->string('nik_ibu')->nullable()->after('penghasilan_ayah');
            $table->string('tempat_lahir_ibu')->nullable()->after('nama_ibu');
            $table->date('tanggal_lahir_ibu')->nullable()->after('tempat_lahir_ibu');
            $table->string('status_ibu')->nullable()->after('tanggal_lahir_ibu');
            $table->string('no_hp_ibu')->nullable()->after('status_ibu');
            $table->string('pendidikan_ibu')->nullable()->after('no_hp_ibu');
            $table->string('pekerjaan_ibu')->nullable()->after('pendidikan_ibu');
            $table->string('penghasilan_ibu')->nullable()->after('pekerjaan_ibu');
            
            // Address info
            $table->string('status_milik')->nullable()->after('penghasilan_ibu');
            $table->string('rt')->nullable()->after('status_milik');
            $table->string('rw')->nullable()->after('rt');
            $table->string('desa')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('desa');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->string('kode_pos')->nullable()->after('provinsi');
            
            // Guardian info
            $table->string('nik_wali')->nullable()->after('kode_pos');
            $table->string('nama_wali')->nullable()->after('nik_wali');
            $table->string('tempat_lahir_wali')->nullable()->after('nama_wali');
            $table->date('tanggal_lahir_wali')->nullable()->after('tempat_lahir_wali');
            $table->string('no_hp_wali')->nullable()->after('tanggal_lahir_wali');
            $table->string('pendidikan_wali')->nullable()->after('no_hp_wali');
            $table->string('pekerjaan_wali')->nullable()->after('pendidikan_wali');
            $table->string('penghasilan_wali')->nullable()->after('pekerjaan_wali');
            
            // Document uploads
            $table->string('fotokk')->nullable()->after('penghasilan_wali');
            $table->string('fotoakta')->nullable()->after('fotokk');
            $table->string('fototransfer')->nullable()->after('fotoakta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn([
                'nik', 'kk', 'nama_kk', 'nis', 'anak_ke', 'jumlah_saudara',
                'kelas_id', 'tgl_masuk', 'kks', 'pkh', 'kip',
                'jenjang_pendidikan_sebelumnya', 'status_sekolah_sebelumnya',
                'nama_sekolah_sebelumnya', 'npsn_sekolah_sebelumnya',
                'alamat_sekolah_sebelumnya', 'kecamatan_sekolah_sebelumnya',
                'kabupaten_sekolah_sebelumnya', 'provinsi_sekolah_sebelumnya',
                'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
                'status_ayah', 'no_hp_ayah', 'pendidikan_ayah',
                'pekerjaan_ayah', 'penghasilan_ayah',
                'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
                'status_ibu', 'no_hp_ibu', 'pendidikan_ibu',
                'pekerjaan_ibu', 'penghasilan_ibu',
                'status_milik', 'rt', 'rw', 'desa', 'kecamatan',
                'kabupaten', 'provinsi', 'kode_pos',
                'nik_wali', 'nama_wali', 'tempat_lahir_wali',
                'tanggal_lahir_wali', 'no_hp_wali', 'pendidikan_wali',
                'pekerjaan_wali', 'penghasilan_wali',
                'fotokk', 'fotoakta', 'fototransfer'
            ]);
        });
    }
};
