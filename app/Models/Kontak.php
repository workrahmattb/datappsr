<?php

namespace App\Models;

use App\Models\Concerns\SanitizesTextFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    /** @use HasFactory<\Database\Factories\KontakFactory> */
    use HasFactory, SanitizesTextFields;

    /**
     * Text attributes that are stripped of HTML tags on write.
     *
     * @var list<string>
     */
    protected array $sanitizedTextFields = [
        'unit',
        'nama',
        'jabatan',
        'telepon',
        'whatsapp',
        'email',
        'alamat',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unit',
        'nama',
        'jabatan',
        'telepon',
        'whatsapp',
        'email',
        'alamat',
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
     * WhatsApp deep link (wa.me) using the international 62 prefix.
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        if (blank($this->whatsapp)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', (string) $this->whatsapp);
        $digits = preg_replace('/^0/', '62', (string) $digits);

        return 'https://wa.me/'.$digits;
    }

    /**
     * Scope only active contacts, ordered for display.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('nama');
    }
}
