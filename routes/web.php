<?php

use App\Livewire\Guru;
use Livewire\Volt\Volt;
use App\Livewire\HelloWorld;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;

Route::get('/lagibelajar', HelloWorld::class);

Route::get('/guru', Guru::class);

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
