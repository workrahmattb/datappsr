<?php

use App\Livewire\Site\Carousel;
use App\Models\Carousel as CarouselModel;
use App\Support\ResponsiveImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
});

test('opsi optimasi tidak valid ditolak tanpa membuat file', function () {
    $this->artisan('site:optimize-images', ['--only' => 'invalid'])->assertFailed();

    expect(Storage::disk('public')->allFiles())->toBe([]);
});

test('optimasi menghasilkan webp responsif tanpa mengubah gambar asli', function () {
    $path = UploadedFile::fake()->image('hero.png', 1600, 900)->store('konten/carousel', 'public');
    $original = Storage::disk('public')->get($path);

    $this->artisan('site:optimize-images', ['--only' => 'storage'])->assertSuccessful();

    expect(Storage::disk('public')->get($path))->toBe($original);
    $image = ResponsiveImage::attributes($path);
    expect($image['width'])->toBe(1600)
        ->and($image['height'])->toBe(900)
        ->and($image['srcset'])->toContain('320w', '640w', '960w', '1280w', '1600w')
        ->and($image['srcset'])->not->toContain('1920w');

    $variant = Storage::disk('public')->path($path.'.optimized-640.webp');
    $dimensions = getimagesize($variant);
    expect($dimensions[0])->toBe(640)
        ->and($dimensions[1])->toBe(360)
        ->and($dimensions['mime'])->toBe('image/webp');

    $timestamp = filemtime($variant);
    $this->artisan('site:optimize-images', ['--only' => 'storage'])->assertSuccessful();
    clearstatcache(true, $variant);
    expect(filemtime($variant))->toBe($timestamp);
});

test('gambar kecil tidak diperbesar dan file hilang memakai url asli', function () {
    $path = UploadedFile::fake()->image('avatar.png', 80, 80)->store('konten/guru', 'public');
    expect(ResponsiveImage::generate($path))->toBeTrue();
    expect(ResponsiveImage::attributes($path)['srcset'])->toContain('80w')->not->toContain('320w');
    expect(ResponsiveImage::attributes('konten/guru/missing.jpg'))
        ->toMatchArray(['src' => Storage::disk('public')->url('konten/guru/missing.jpg'), 'srcset' => '', 'width' => null, 'height' => null]);
});

test('optimasi mengabaikan dokumen santri dan file bukan gambar', function () {
    $private = UploadedFile::fake()->image('kk.png', 800, 600)->store('dokumen-siswa/kk', 'public');
    Storage::disk('public')->put('konten/rusak.jpg', 'not an image');

    expect(ResponsiveImage::generate($private))->toBeFalse()
        ->and(ResponsiveImage::generate('konten/rusak.jpg'))->toBeFalse()
        ->and(ResponsiveImage::generate('konten/../../.env'))->toBeFalse();
    Storage::disk('public')->assertMissing($private.'.optimized-640.webp');
});

test('varian lama tidak dipakai setelah gambar sumber berubah', function () {
    $path = UploadedFile::fake()->image('hero.png', 640, 360)->store('konten/carousel', 'public');
    ResponsiveImage::generate($path);
    foreach ([320, 640] as $width) {
        $variant = Storage::disk('public')->path($path.'.optimized-'.$width.'.webp');
        touch($variant, time() - 60);
        clearstatcache(true, $variant);
    }
    expect(ResponsiveImage::attributes($path)['srcset'])->toBe('');
    ResponsiveImage::generate($path);
    clearstatcache();
    expect(ResponsiveImage::attributes($path)['srcset'])->toContain('640w');
});

test('hero pertama diprioritaskan dan slide lain dimuat malas', function () {
    $path = UploadedFile::fake()->image('hero.png', 1600, 900)->store('konten/carousel', 'public');
    ResponsiveImage::generate($path);
    CarouselModel::factory()->count(2)->create(['gambar' => $path]);
    $html = Livewire::test(Carousel::class)->html();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$html);
    $images = $document->getElementsByTagName('img');
    expect($images->item(0)->getAttribute('fetchpriority'))->toBe('high')
        ->and($images->item(0)->getAttribute('loading'))->toBe('eager')
        ->and($images->item(0)->getAttribute('srcset'))->toContain('640w')
        ->and($images->item(1)->getAttribute('fetchpriority'))->toBe('auto')
        ->and($images->item(1)->getAttribute('loading'))->toBe('lazy');
});

test('halaman utama memakai stylesheet publik tersendiri', function () {
    $this->withoutVite();
    $html = file_get_contents(resource_path('views/layouts/public.blade.php'));
    expect($html)->toContain("@vite('resources/css/site.css')")
        ->not->toContain('resources/css/app.css');
    $this->get(route('home'))->assertSuccessful();
});
