<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Memvalidasi ketentuan ukuran gambar: ukuran minimum dan rentang rasio
 * (perbandingan lebar : tinggi) agar gambar selalu berbentuk lanskap.
 *
 * Pesan error menyertakan ukuran gambar yang diunggah supaya pengguna
 * tahu persis apa yang perlu diperbaiki.
 */
class KetentuanUkuranGambar implements ValidationRule
{
    public function __construct(
        private readonly int $minLebar,
        private readonly int $minTinggi,
        private readonly float $minRasio,
        private readonly float $maxRasio,
        private readonly string $rekomendasi,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            return;
        }

        $ukuran = @getimagesize($value->getRealPath());

        // Berkas yang bukan gambar valid ditangani oleh rule `image` / `mimes`.
        if ($ukuran === false) {
            return;
        }

        [$lebar, $tinggi] = $ukuran;

        if ($tinggi <= 0) {
            return;
        }

        $rasio = round($lebar / $tinggi, 2);
        $ukuranPengguna = "{$lebar} × {$tinggi} px (rasio {$rasio})";

        if ($lebar < $this->minLebar || $tinggi < $this->minTinggi) {
            $fail(
                "Ukuran gambar terlalu kecil: {$ukuranPengguna}. ".
                "Minimal {$this->minLebar} × {$this->minTinggi} px. Rekomendasi {$this->rekomendasi}."
            );

            return;
        }

        if ($rasio < $this->minRasio || $rasio > $this->maxRasio) {
            $fail(
                "Rasio gambar tidak sesuai: {$ukuranPengguna}. ".
                "Gunakan gambar lanskap dengan rasio {$this->minRasio}–{$this->maxRasio}. ".
                "Rekomendasi {$this->rekomendasi}."
            );
        }
    }
}
