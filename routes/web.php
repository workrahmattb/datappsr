<?php

use Livewire\Volt\Volt;
use App\Livewire\HelloWorld;
use App\Livewire\PendaftaranForm;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakRaporController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MtsputraController;
use App\Http\Controllers\Admin\MtsputriController;
use App\Http\Controllers\Admin\MaputraController;
use App\Http\Controllers\Admin\MaputriController;
use App\Http\Controllers\Admin\PendaftaranController;

Route::get('/lagibelajar', HelloWorld::class);

Route::get('/pendaftaran', PendaftaranForm::class)->name('pendaftaran');

// Daftar Ulang Routes (Public - No Auth Required)
Route::get('/daftar-ulang', \App\Livewire\DaftarUlangTable::class)->name('daftar-ulang.table');
Route::get('/daftar-ulang/{id}', \App\Livewire\DaftarUlangForm::class)->name('daftar-ulang.form');

// Cetak Rapor Route (butuh auth)
Route::get('/cetak-rapor/generate', [CetakRaporController::class, 'generate'])
    ->name('cetak-rapor.generate')
    ->middleware(['auth']);

// Public Routes (Front End)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/beranda', function () {
    return view('testcoba');
})->name('beranda');

// Admin Routes (Butuh Login)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    
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

    // Pendaftaran
    Route::get('pendaftarans', \App\Livewire\Admin\PendaftaransTable::class)->name('pendaftarans.index');
    Route::get('pendaftarans/create', [\App\Http\Controllers\Admin\PendaftaranController::class, 'create'])->name('pendaftarans.create');
    Route::post('pendaftarans', [\App\Http\Controllers\Admin\PendaftaranController::class, 'store'])->name('pendaftarans.store');
    Route::get('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftarans.show');
    Route::get('pendaftarans/{pendaftaran}/edit', [\App\Http\Controllers\Admin\PendaftaranController::class, 'edit'])->name('pendaftarans.edit');
    Route::put('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'update'])->name('pendaftarans.update');
    Route::delete('pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'destroy'])->name('pendaftarans.destroy');
    Route::get('pendaftarans-export', [\App\Http\Controllers\Admin\PendaftaranController::class, 'export'])->name('pendaftarans.export');
});
