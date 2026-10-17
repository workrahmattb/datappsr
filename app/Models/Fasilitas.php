<?php

namespace App\Models;

use App\Models\Concerns\SanitizesTextFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fasilitas extends Model
{
    /** @use HasFactory<\Database\Factories\FasilitasFactory> */
    use HasFactory, SanitizesTextFields;

    /**
     * Explicit table name (Indonesian singular noun, not auto-pluralized).
     */
    protected $table = 'fasilitas';

    /**
     * Text attributes that are stripped of HTML tags on write.
     *
     * @var list<string>
     */
    protected array $sanitizedTextFields = ['nama', 'kategori', 'deskripsi'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'gambar',
        'urutan',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Foto-foto fasilitas (foto pertama = gambar utama).
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(FasilitasFoto::class)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Sinkronkan kolom `gambar` (cover) dengan foto pertama di galeri.
     */
    public function syncGambarUtama(): void
    {
        $cover = $this->fotos()->value('path');

        if ($this->gambar !== $cover) {
            $this->forceFill(['gambar' => $cover])->save();
        }
    }

    /**
     * Scope only active facilities, ordered for display.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('nama');
    }
}
