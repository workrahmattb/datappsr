<?php

namespace App\Console\Commands;

use App\Support\ResponsiveImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OptimizeSiteImages extends Command
{
    protected $signature = 'site:optimize-images {--only= : Pilih storage atau assets; kosong untuk keduanya}';

    protected $description = 'Membuat varian WebP responsif untuk konten website tanpa mengubah gambar asli';

    public function handle(): int
    {
        $only = $this->option('only');
        if (! in_array($only, [null, 'storage', 'assets'], true)) {
            $this->error('Opsi only harus storage atau assets.');

            return self::FAILURE;
        }

        if (! function_exists('imagewebp')) {
            $this->error('Aktifkan ekstensi PHP GD dengan dukungan WebP.');

            return self::FAILURE;
        }

        $files = [];
        if ($only !== 'assets') {
            if (config('filesystems.disks.public.driver') !== 'local') {
                $this->error('Optimasi ini memerlukan public disk lokal.');

                return self::FAILURE;
            }
            foreach (Storage::disk('public')->allFiles('konten') as $path) {
                $files[] = [$path, false];
            }
        }
        if ($only !== 'storage' && is_dir(public_path('images'))) {
            foreach (File::allFiles(public_path('images')) as $file) {
                $files[] = ['images/'.$file->getRelativePathname(), true];
            }
        }

        $failed = false;
        foreach ($files as [$path, $asset]) {
            if (str_contains($path, '.optimized-') || ! preg_match('/\.(jpe?g|png|webp)$/i', $path)) {
                continue;
            }
            try {
                if (ResponsiveImage::generate($path, $asset)) {
                    $this->info('Siap: '.$path);
                } else {
                    $this->warn('Dilewati (gunakan gambar asli): '.$path);
                }
            } catch (Throwable $exception) {
                $failed = true;
                $this->error($path.': '.$exception->getMessage());
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
