<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenjang_pendidikan',
        'status_pendaftaran',
        'student_id',
        'student_type',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'kk',
        'nama_kk',
        'nisn',
        'nis',
        'anak_ke',
        'tahun_ajaran',
        'kelas_id',
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
        'no_hp_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'fotokk',
        'fotoakta',
        'fototransfer',
        // Legacy fields
        'asal_sekolah',
        'alamat',
        'no_hp',
        'buktitransfer',
        'bayar_uang_masuk',
    ];

    /**
     * Get the target model class based on jenjang_pendidikan
     */
    public function getTargetModelClass(): ?string
    {
        return match($this->jenjang_pendidikan) {
            'MTs Putri' => Mtsputri::class,
            'MTs Putra' => Mtsputra::class,
            'MA Putri' => Maputri::class,
            'MA Putra' => Maputra::class,
            default => null,
        };
    }

    /**
     * Get the student type string for database storage
     */
    public function getStudentType(): ?string
    {
        return match($this->jenjang_pendidikan) {
            'MTs Putri' => 'mtsputri',
            'MTs Putra' => 'mtsputra',
            'MA Putri' => 'maputri',
            'MA Putra' => 'maputra',
            default => null,
        };
    }

    /**
     * Get the kelas that the pendaftaran belongs to
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}
