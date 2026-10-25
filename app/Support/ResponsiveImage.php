<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ResponsiveImage
{
    private const WIDTHS = [320, 640, 960, 1280, 1920];

    /** @return array{src: string, srcset: string, width: ?int, height: ?int} */
    public static function attributes(string $path, bool $asset = false): array
    {
        $url = $asset ? asset($path) : Storage::disk('public')->url($path);
        $file = self::localPath($path, $asset);
        $dimensions = $file ? @getimagesize($file) : false;
        $sources = [];

        if ($dimensions) {
            foreach (self::widths($dimensions[0]) as $width) {
                $variant = $file.'.optimized-'.$width.'.webp';
                if (is_file($variant) && filemtime($variant) >= filemtime($file)) {
                    $variantPath = $path.'.optimized-'.$width.'.webp';
                    $variantUrl = $asset ? asset($variantPath) : Storage::disk('public')->url($variantPath);
                    $sources[] = $variantUrl.'?v='.filemtime($variant).' '.$width.'w';
                }
            }
        }

        return [
            'src' => $url,
            'srcset' => implode(', ', $sources),
            'width' => $dimensions ? $dimensions[0] : null,
            'height' => $dimensions ? $dimensions[1] : null,
        ];
    }

    /** Generate derivatives outside the visitor request; never replace the original. */
    public static function generate(string $path, bool $asset = false): bool
    {
        $file = self::localPath($path, $asset);
        $dimensions = $file ? @getimagesize($file) : false;

        if (! $dimensions || ! in_array($dimensions[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            return false;
        }

        if ($dimensions[0] * $dimensions[1] > 20000000) {
            return false;
        }

        if (! function_exists('imagewebp')) {
            throw new RuntimeException('Ekstensi PHP GD dengan WebP diperlukan.');
        }

        if ($dimensions[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($file);
            if (($exif['Orientation'] ?? 1) !== 1) {
                return false;
            }
        }

        $pending = array_filter(self::widths($dimensions[0]), function (int $width) use ($file): bool {
            $variant = $file.'.optimized-'.$width.'.webp';

            return ! is_file($variant) || filemtime($variant) < filemtime($file);
        });

        if ($pending === []) {
            return true;
        }

        $contents = file_get_contents($file);
        if ($contents === false) {
            throw new RuntimeException('Gagal membaca gambar: '.$path);
        }
        if ($dimensions[2] === IMAGETYPE_WEBP && str_contains(substr($contents, 0, 100), 'ANIM')) {
            return false;
        }

        $source = @imagecreatefromstring($contents);
        if (! $source) {
            return false;
        }

        try {
            foreach ($pending as $width) {
                $height = max(1, (int) round($dimensions[1] * $width / $dimensions[0]));
                $resized = imagecreatetruecolor($width, $height);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $width, $height, $dimensions[0], $dimensions[1]);
                $temporary = tempnam(dirname($file), '.responsive-');

                try {
                    if ($temporary === false) {
                        throw new RuntimeException('Gagal membuat file sementara: '.$path);
                    }
                    if (! imagewebp($resized, $temporary, 80) || ! filesize($temporary)) {
                        throw new RuntimeException('Gagal membuat gambar WebP: '.$path);
                    }
                    chmod($temporary, 0644);
                    if (! rename($temporary, $file.'.optimized-'.$width.'.webp')) {
                        throw new RuntimeException('Gagal menyimpan gambar WebP: '.$path);
                    }
                } finally {
                    imagedestroy($resized);
                    if ($temporary !== false && is_file($temporary)) {
                        unlink($temporary);
                    }
                }
            }
        } finally {
            imagedestroy($source);
        }

        return true;
    }

    /** @return list<int> */
    private static function widths(int $originalWidth): array
    {
        return array_values(array_unique(array_map(fn (int $width): int => min($width, $originalWidth), self::WIDTHS)));
    }

    private static function localPath(string $path, bool $asset): ?string
    {
        if (str_contains($path, '..') || ! str_starts_with($path, $asset ? 'images/' : 'konten/')) {
            return null;
        }

        if (! $asset && config('filesystems.disks.public.driver') !== 'local') {
            return null;
        }

        $file = $asset ? public_path($path) : Storage::disk('public')->path($path);

        return is_file($file) ? $file : null;
    }
}
