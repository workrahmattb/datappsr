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
        Schema::create('mtsputras', function (Blueprint $table) {
            $table->id();

            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('kk')->nullable();
            $table->string('nama_kk')->nullable();
            $table->string('nisn',20)->nullable()->unique();
            $table->string('nis')->nullable();

            $table->string('anak_ke')->nullable();
            $table->string('jumlah_saudara')->nullable();

            $table->string('tahun_ajaran')->nullable();

            $table->string('tgl_masuk')->nullable();
            $table->string('kks')->nullable();
            $table->string('pkh')->nullable();
            $table->string('kip')->nullable();

            $table->string('jenjang_pendidikan_sebelumnya')->nullable();
            $table->string('status_sekolah_sebelumnya')->nullable();
            $table->string('nama_sekolah_sebelumnya')->nullable();
            $table->string('npsn_sekolah_sebelumnya')->nullable();
            $table->string('alamat_sekolah_sebelumnya')->nullable();
            $table->string('kecamatan_sekolah_sebelumnya')->nullable();
            $table->string('kabupaten_sekolah_sebelumnya')->nullable();
            $table->string('provinsi_sekolah_sebelumnya')->nullable();

            $table->string('nik_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('status_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();

            $table->string('nik_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('status_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();

            $table->string('status_milik')->nullable();
            $table->string('alamat_rumah_tinggal')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();

            $table->string('nik_wali')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();

            $table->string('fotokk')->nullable();
            $table->string('fotoakta')->nullable();
            $table->string('fototransfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtsputras');
    }
};
