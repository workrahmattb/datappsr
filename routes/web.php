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

// Cetak Rapor Route
Route::get('/cetak-rapor/generate', [CetakRaporController::class, 'generate'])
    ->name('cetak-rapor.generate')
    ->middleware(['auth']);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/beranda', function () {
    return view('testcoba');
})->name('beranda');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // Mtsputra
    Route::resource('mtsputras', MtsputraController::class);
    
    // Mtsputri
    Route::resource('mtsputris', MtsputriController::class);
    
    // Maputra
    Route::resource('maputras', MaputraController::class);
    
    // Maputri
    Route::resource('maputris', MaputriController::class);
    
    // Pendaftaran
    Route::resource('pendaftarans', PendaftaranController::class);
    Route::get('pendaftarans-export', [PendaftaranController::class, 'export'])->name('pendaftarans.export');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
