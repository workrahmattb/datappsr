<?php

namespace App\Models;

use App\Models\Concerns\SanitizesTextFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory, SanitizesTextFields;

    /**
     * Text attributes that are stripped of HTML tags on write.
     *
     * @var list<string>
     */
    protected array $sanitizedTextFields = [
        'name',
        'nip',
        'jabatan',
        'pendidikan',
        'email',
        'deskripsi',
        'alamat',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'jabatan',
        'jenis_kelamin',
        'pendidikan',
        'email',
        'deskripsi',
        'foto',
        'urutan',
        'is_active',
        'no_hp',
        'tanggal_lahir',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope only active teachers, ordered for display.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('name');
    }
}
