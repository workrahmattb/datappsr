<?php

use App\Livewire\Guru;
use Livewire\Volt\Volt;
use App\Livewire\HelloWorld;
use App\Livewire\PendaftaranForm;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakRaporController;

Route::get('/lagibelajar', HelloWorld::class);

Route::get('/pendaftaran', PendaftaranForm::class)->name('pendaftaran');

// Daftar Ulang Routes (Public - No Auth Required)
Route::get('/daftar-ulang', \App\Livewire\DaftarUlangTable::class)->name('daftar-ulang.table');
Route::get('/daftar-ulang/{id}', \App\Livewire\DaftarUlangForm::class)->name('daftar-ulang.form');


Route::get('/guru', Guru::class);

// Cetak Rapor Route
Route::get('/cetak-rapor/generate', [CetakRaporController::class, 'generate'])
    ->name('cetak-rapor.generate')
    ->middleware(['auth']);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/beranda', function () {
    return view('testcoba');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
