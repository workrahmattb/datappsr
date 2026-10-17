<?php

namespace App\Models;

use App\Models\Concerns\SanitizesTextFields;
use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    /** @use HasFactory<\Database\Factories\BeritaFactory> */
    use HasFactory, SanitizesTextFields;

    /**
     * Text attributes that are stripped of HTML tags on write.
     *
     * Note: `isi` is intentionally NOT listed here — the article body keeps a
     * whitelisted subset of HTML (see HtmlSanitizer in the saving hook).
     *
     * @var list<string>
     */
    protected array $sanitizedTextFields = ['judul', 'kategori', 'ringkasan', 'penulis'];

    /**
     * Available publication statuses.
     *
     * @var list<string>
     */
    public const STATUSES = ['draft', 'published'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'isi',
        'gambar',
        'penulis',
        'status',
        'published_at',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $berita): void {
            if (blank($berita->slug)) {
                $berita->slug = static::generateUniqueSlug((string) $berita->judul, $berita->id);
            }

            if ($berita->status === 'published' && blank($berita->published_at)) {
                $berita->published_at = now();
            }

            // Isi berita berupa HTML dari editor → simpan hanya markup yang diizinkan.
            $berita->isi = HtmlSanitizer::clean((string) $berita->isi);
        });
    }

    /**
     * Isi berita siap tampil (HTML sudah disanitasi saat disimpan; disanitasi
     * ulang saat dibaca sebagai lapisan keamanan tambahan).
     */
    public function getIsiHtmlAttribute(): string
    {
        return HtmlSanitizer::clean((string) $this->isi);
    }

    /**
     * Ringkasan singkat untuk daftar/kartu berita.
     */
    public function getRingkasanSingkatAttribute(): string
    {
        $source = $this->ringkasan ?: strip_tags((string) $this->isi);

        return Str::limit(trim(preg_replace('/\s+/', ' ', $source) ?? ''), 150);
    }

    /**
     * Build a unique slug from the given title, ignoring an existing record.
     */
    public static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'berita';
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope only published news.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
