<?php

use App\Http\Controllers\CetakRaporController;
use App\Livewire\HelloWorld;
use App\Livewire\PendaftaranForm;
use Illuminate\Support\Facades\Route;

Route::get('/lagibelajar', HelloWorld::class);

Route::get('/pendaftaran', PendaftaranForm::class)->name('pendaftaran');

// Update Foto Routes (Public - No Auth Required)
Route::get('/update-foto/{type}/{id}', \App\Livewire\UpdateFotoForm::class)->name('update-foto.form');

// Daftar Ulang Routes (Public - No Auth Required)
Route::get('/daftar-ulang', \App\Livewire\DaftarUlangTable::class)->name('daftar-ulang.table');
Route::get('/daftar-ulang/{id}', \App\Livewire\DaftarUlangForm::class)->name('daftar-ulang.form');

// Cetak Rapor Route (butuh auth)
Route::get('/cetak-rapor/generate', [CetakRaporController::class, 'generate'])
    ->name('cetak-rapor.generate')
    ->middleware(['auth']);

// ============================================================
// Website Sekolah (halaman publik) — full SPA Livewire
// ============================================================
Route::get('/', \App\Livewire\Site\Home::class)->name('home');
Route::get('/berita', \App\Livewire\Site\BeritaIndex::class)->name('berita.index');
Route::get('/berita/{slug}', \App\Livewire\Site\BeritaShow::class)->name('berita.show');
Route::get('/fasilitas', \App\Livewire\Site\FasilitasIndex::class)->name('fasilitas.index');
Route::get('/guru', \App\Livewire\Site\GuruIndex::class)->name('guru.index');
Route::get('/kontak', \App\Livewire\Site\KontakIndex::class)->name('kontak.index');

// PSB: pendaftaran & pencarian data santri
Route::get('/psb', \App\Livewire\Site\Psb::class)->name('psb');

Route::get('/beranda', function () {
    return view('testcoba');
})->name('beranda');

// Admin Routes (Butuh Login)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard')->middleware(['\App\Http\Middleware\CheckRole::class,admin']);

    // Mtsputra
    Route::middleware(['\App\Http\Middleware\CheckRole::class,mtsputra'])->group(function () {
        Route::get('mtsputras', \App\Livewire\Admin\MtsputrasTable::class)->name('mtsputras.index');
        Route::get('mtsputras/create', [\App\Http\Controllers\Admin\MtsputraController::class, 'create'])->name('mtsputras.create');
        Route::post('mtsputras', [\App\Http\Controllers\Admin\MtsputraController::class, 'store'])->name('mtsputras.store');
        Route::get('mtsputras-export', [\App\Http\Controllers\Admin\MtsputraController::class, 'export'])->name('mtsputras.export');
        Route::get('mtsputras/{mtsputra}', [\App\Http\Controllers\Admin\MtsputraController::class, 'show'])->name('mtsputras.show');
        Route::get('mtsputras/{mtsputra}/edit', [\App\Http\Controllers\Admin\MtsputraController::class, 'edit'])->name('mtsputras.edit');
        Route::put('mtsputras/{mtsputra}', [\App\Http\Controllers\Admin\MtsputraController::class, 'update'])->name('mtsputras.update');
        Route::delete('mtsputras/{mtsputra}', [\App\Http\Controllers\Admin\MtsputraController::class, 'destroy'])->name('mtsputras.destroy');
    });

    // Mtsputri
    Route::middleware(['\App\Http\Middleware\CheckRole::class,mtsputri'])->group(function () {
        Route::get('mtsputris', \App\Livewire\Admin\MtsputrisTable::class)->name('mtsputris.index');
        Route::get('mtsputris/create', [\App\Http\Controllers\Admin\MtsputriController::class, 'create'])->name('mtsputris.create');
        Route::post('mtsputris', [\App\Http\Controllers\Admin\MtsputriController::class, 'store'])->name('mtsputris.store');
        Route::get('mtsputris-export', [\App\Http\Controllers\Admin\MtsputriController::class, 'export'])->name('mtsputris.export');
        Route::get('mtsputris/{mtsputri}', [\App\Http\Controllers\Admin\MtsputriController::class, 'show'])->name('mtsputris.show');
        Route::get('mtsputris/{mtsputri}/edit', [\App\Http\Controllers\Admin\MtsputriController::class, 'edit'])->name('mtsputris.edit');
        Route::put('mtsputris/{mtsputri}', [\App\Http\Controllers\Admin\MtsputriController::class, 'update'])->name('mtsputris.update');
        Route::delete('mtsputris/{mtsputri}', [\App\Http\Controllers\Admin\MtsputriController::class, 'destroy'])->name('mtsputris.destroy');
    });

    // Maputra
    Route::middleware(['\App\Http\Middleware\CheckRole::class,maputra'])->group(function () {
        Route::get('maputras', \App\Livewire\Admin\MaputrasTable::class)->name('maputras.index');
        Route::get('maputras/create', [\App\Http\Controllers\Admin\MaputraController::class, 'create'])->name('maputras.create');
        Route::post('maputras', [\App\Http\Controllers\Admin\MaputraController::class, 'store'])->name('maputras.store');
        Route::get('maputras-export', [\App\Http\Controllers\Admin\MaputraController::class, 'export'])->name('maputras.export');
        Route::get('maputras/{maputra}', [\App\Http\Controllers\Admin\MaputraController::class, 'show'])->name('maputras.show');
        Route::get('maputras/{maputra}/edit', [\App\Http\Controllers\Admin\MaputraController::class, 'edit'])->name('maputras.edit');
        Route::put('maputras/{maputra}', [\App\Http\Controllers\Admin\MaputraController::class, 'update'])->name('maputras.update');
        Route::delete('maputras/{maputra}', [\App\Http\Controllers\Admin\MaputraController::class, 'destroy'])->name('maputras.destroy');
    });

    // Maputri
    Route::middleware(['\App\Http\Middleware\CheckRole::class,maputri'])->group(function () {
        Route::get('maputris', \App\Livewire\Admin\MaputrisTable::class)->name('maputris.index');
        Route::get('maputris/create', [\App\Http\Controllers\Admin\MaputriController::class, 'create'])->name('maputris.create');
        Route::post('maputris', [\App\Http\Controllers\Admin\MaputriController::class, 'store'])->name('maputris.store');
        Route::get('maputris-export', [\App\Http\Controllers\Admin\MaputriController::class, 'export'])->name('maputris.export');
        Route::get('maputris/{maputri}', [\App\Http\Controllers\Admin\MaputriController::class, 'show'])->name('maputris.show');
        Route::get('maputris/{maputri}/edit', [\App\Http\Controllers\Admin\MaputriController::class, 'edit'])->name('maputris.edit');
        Route::put('maputris/{maputri}', [\App\Http\Controllers\Admin\MaputriController::class, 'update'])->name('maputris.update');
        Route::delete('maputris/{maputri}', [\App\Http\Controllers\Admin\MaputriController::class, 'destroy'])->name('maputris.destroy');
    });

    // Settings
    Route::middleware(['\App\Http\Middleware\CheckRole::class,admin'])->group(function () {
        Route::get('settings', \App\Livewire\Admin\Settings::class)->name('settings.index');
    });

    // Pendaftaran
    Route::middleware(['\App\Http\Middleware\CheckRole::class,admin'])->group(function () {
        Route::get('pendaftarans', \App\Livewire\Admin\PendaftaransTable::class)->name('pendaftarans.index');
        Route::get('pendaftarans/create', [\App\Http\Controllers\Admin\PendaftaranController::class, 'create'])->name('pendaftarans.create');
        Route::post('pendaftarans', [\App\Http\Controllers\Admin\PendaftaranController::class, 'store'])->name('pendaftarans.store');
        Route::get('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftarans.show');
        Route::get('pendaftarans/{pendaftaran}/edit', [\App\Http\Controllers\Admin\PendaftaranController::class, 'edit'])->name('pendaftarans.edit');
        Route::put('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'update'])->name('pendaftarans.update');
        Route::delete('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'destroy'])->name('pendaftarans.destroy');
        Route::get('pendaftarans-export', [\App\Http\Controllers\Admin\PendaftaranController::class, 'export'])->name('pendaftarans.export');
    });

    // Konten Website — Berita, Fasilitas, Profil Guru, Kontak (admin only)
    Route::middleware(['\App\Http\Middleware\CheckRole::class,admin'])->group(function () {
        // Berita
        Route::get('beritas', \App\Livewire\Admin\BeritasTable::class)->name('beritas.index');
        Route::get('beritas/create', [\App\Http\Controllers\Admin\BeritaController::class, 'create'])->name('beritas.create');
        Route::post('beritas', [\App\Http\Controllers\Admin\BeritaController::class, 'store'])->name('beritas.store');
        Route::post('beritas/upload-gambar', [\App\Http\Controllers\Admin\BeritaController::class, 'uploadGambar'])->name('beritas.upload-gambar');
        Route::get('beritas/{berita}', [\App\Http\Controllers\Admin\BeritaController::class, 'show'])->name('beritas.show');
        Route::get('beritas/{berita}/edit', [\App\Http\Controllers\Admin\BeritaController::class, 'edit'])->name('beritas.edit');
        Route::put('beritas/{berita}', [\App\Http\Controllers\Admin\BeritaController::class, 'update'])->name('beritas.update');
        Route::delete('beritas/{berita}', [\App\Http\Controllers\Admin\BeritaController::class, 'destroy'])->name('beritas.destroy');

        // Fasilitas
        Route::get('fasilitas', \App\Livewire\Admin\FasilitasTable::class)->name('fasilitas.index');
        Route::get('fasilitas/create', [\App\Http\Controllers\Admin\FasilitasController::class, 'create'])->name('fasilitas.create');
        Route::post('fasilitas', [\App\Http\Controllers\Admin\FasilitasController::class, 'store'])->name('fasilitas.store');
        Route::get('fasilitas/{fasilitas}', [\App\Http\Controllers\Admin\FasilitasController::class, 'show'])->name('fasilitas.show');
        Route::get('fasilitas/{fasilitas}/edit', [\App\Http\Controllers\Admin\FasilitasController::class, 'edit'])->name('fasilitas.edit');
        Route::put('fasilitas/{fasilitas}', [\App\Http\Controllers\Admin\FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::delete('fasilitas/{fasilitas}', [\App\Http\Controllers\Admin\FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
        Route::delete('fasilitas/{fasilitas}/foto/{foto}', [\App\Http\Controllers\Admin\FasilitasController::class, 'destroyFoto'])->name('fasilitas.foto.destroy');

        // Profil Guru
        Route::get('gurus', \App\Livewire\Admin\GurusTable::class)->name('gurus.index');
        Route::get('gurus/create', [\App\Http\Controllers\Admin\GuruController::class, 'create'])->name('gurus.create');
        Route::post('gurus', [\App\Http\Controllers\Admin\GuruController::class, 'store'])->name('gurus.store');
        Route::get('gurus/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'show'])->name('gurus.show');
        Route::get('gurus/{guru}/edit', [\App\Http\Controllers\Admin\GuruController::class, 'edit'])->name('gurus.edit');
        Route::put('gurus/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'update'])->name('gurus.update');
        Route::delete('gurus/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'destroy'])->name('gurus.destroy');

        // Kontak person
        Route::get('kontaks', \App\Livewire\Admin\KontaksTable::class)->name('kontaks.index');
        Route::get('kontaks/create', [\App\Http\Controllers\Admin\KontakController::class, 'create'])->name('kontaks.create');
        Route::post('kontaks', [\App\Http\Controllers\Admin\KontakController::class, 'store'])->name('kontaks.store');
        Route::get('kontaks/{kontak}', [\App\Http\Controllers\Admin\KontakController::class, 'show'])->name('kontaks.show');
        Route::get('kontaks/{kontak}/edit', [\App\Http\Controllers\Admin\KontakController::class, 'edit'])->name('kontaks.edit');
        Route::put('kontaks/{kontak}', [\App\Http\Controllers\Admin\KontakController::class, 'update'])->name('kontaks.update');
        Route::delete('kontaks/{kontak}', [\App\Http\Controllers\Admin\KontakController::class, 'destroy'])->name('kontaks.destroy');

        // Kontak lembaga (pengaturan, singleton)
        Route::get('kontak-lembaga', \App\Livewire\Admin\KontakLembagaSettings::class)->name('kontak-lembaga.index');

        // Carousel halaman utama
        Route::get('carousels', \App\Livewire\Admin\CarouselsTable::class)->name('carousels.index');
        Route::get('carousels/create', [\App\Http\Controllers\Admin\CarouselController::class, 'create'])->name('carousels.create');
        Route::post('carousels', [\App\Http\Controllers\Admin\CarouselController::class, 'store'])->name('carousels.store');
        Route::get('carousels/{carousel}', [\App\Http\Controllers\Admin\CarouselController::class, 'show'])->name('carousels.show');
        Route::get('carousels/{carousel}/edit', [\App\Http\Controllers\Admin\CarouselController::class, 'edit'])->name('carousels.edit');
        Route::put('carousels/{carousel}', [\App\Http\Controllers\Admin\CarouselController::class, 'update'])->name('carousels.update');
        Route::delete('carousels/{carousel}', [\App\Http\Controllers\Admin\CarouselController::class, 'destroy'])->name('carousels.destroy');
    });

});

// Foto Santri (Public)
Route::get('/foto', \App\Livewire\FotoTable::class)->name('foto.index');

// Uang Masuk (Public)
Route::get('/uangmasuk', \App\Livewire\UangMasukTable::class)->name('uangmasuk.index');
