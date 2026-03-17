<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tingkat',
        'nomor_kelas',
        'tahun_ajaran',
        'guru_id',
        'kapasitas',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas' => 'integer',
        ];
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Get the MTs Putri students in this class
     */
    public function mtsputris(): HasMany
    {
        return $this->hasMany(Mtsputri::class);
    }

    /**
     * Get the MTs Putra students in this class
     */
    public function mtsputras(): HasMany
    {
        return $this->hasMany(Mtsputra::class);
    }

    /**
     * Get the MA Putri students in this class
     */
    public function maputris(): HasMany
    {
        return $this->hasMany(Maputri::class);
    }

    /**
     * Get the MA Putra students in this class
     */
    public function maputras(): HasMany
    {
        return $this->hasMany(Maputra::class);
    }
}
