<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mtsputri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'kk',
        'nama_kk',
        'nisn',
        'nis',
        'tk',
        'paud',
        'hobi',
        'cita_cita',
        'anak_ke',
        'tahun_ajaran',
        'jumlah_saudara',
        'tgl_masuk',
        'kks',
        'pkh',
        'kip',
        'jenjang_pendidikan_sebelumnya',
        'status_sekolah_sebelumnya',
        'nama_sekolah_sebelumnya',
        'npsn_sekolah_sebelumnya',
        'alamat_sekolah_sebelumnya',
        'kecamatan_sekolah_sebelumnya',
        'kabupaten_sekolah_sebelumnya',
        'provinsi_sekolah_sebelumnya',
        'nik_ayah',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'status_ayah',
        'no_hp_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nik_ibu',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'status_ibu',
        'no_hp_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'status_milik',
        'alamat_rumah_tinggal',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'nik_wali',
        'nama_wali',
        'tempat_lahir_wali',
        'tanggal_lahir_wali',
        'status_wali',
        'no_hp_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'fotokk',
        'fotoakta',
        'fototransfer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_lahir_ayah' => 'date',
            'tanggal_lahir_ibu' => 'date',
            'tanggal_lahir_wali' => 'date',
        ];
    }

    /**
     * Sanitize nama attribute to prevent XSS
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

    /**
     * Sanitize tempat_lahir attribute to prevent XSS
     */
    protected function tempatLahir(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

    /**
     * Sanitize nama_kk attribute to prevent XSS
     */
    protected function namaKk(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

    /**
     * Sanitize nama_ayah attribute to prevent XSS
     */
    protected function namaAyah(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

    /**
     * Sanitize nama_ibu attribute to prevent XSS
     */
    protected function namaIbu(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

    /**
     * Sanitize nama_wali attribute to prevent XSS
     */
    protected function namaWali(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }

}
