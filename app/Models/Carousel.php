<?php

namespace App\Models;

use App\Models\Concerns\SanitizesTextFields;
use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    /** @use HasFactory<\Database\Factories\CarouselFactory> */
    use HasFactory, SanitizesTextFields;

    /**
     * Text attributes that are stripped of HTML tags on write.
     *
     * @var list<string>
     */
    protected array $sanitizedTextFields = ['judul', 'deskripsi', 'link_text'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'link_url',
        'link_text',
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

    protected static function booted(): void
    {
        static::saving(function (self $carousel): void {
            // Tolak tautan berbahaya (javascript:, data:, ...) agar tidak
            // menjadi celah XSS saat dirender di halaman publik.
            if (filled($carousel->link_url)
                && ! HtmlSanitizer::isSafeUrl((string) $carousel->link_url)) {
                $carousel->link_url = null;
            }
        });
    }

    /**
     * Scope only active slides, ordered for display.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Whether this slide has a complete call-to-action button.
     */
    public function getPunyaTombolAttribute(): bool
    {
        return filled($this->link_url) && filled($this->link_text);
    }
}
