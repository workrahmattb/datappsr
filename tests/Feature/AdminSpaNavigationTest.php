<?php

use App\Models\Berita;
use App\Models\User;

function adminSpaUser(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('tombol tambah di daftar konten memakai navigasi SPA', function (string $daftar, string $buat) {
    $this->actingAs(adminSpaUser())
        ->get(route($daftar))
        ->assertSuccessful()
        ->assertSeeHtml('wire:navigate href="'.route($buat).'"');
})->with([
    'berita' => ['admin.beritas.index', 'admin.beritas.create'],
    'fasilitas' => ['admin.fasilitas.index', 'admin.fasilitas.create'],
    'profil guru' => ['admin.gurus.index', 'admin.gurus.create'],
    'kontak' => ['admin.kontaks.index', 'admin.kontaks.create'],
    'carousel' => ['admin.carousels.index', 'admin.carousels.create'],
    'siswa MTs putra' => ['admin.mtsputras.index', 'admin.mtsputras.create'],
    'data pendaftaran' => ['admin.pendaftarans.index', 'admin.pendaftarans.create'],
]);

test('tombol batal di halaman tambah memakai navigasi SPA', function (string $buat, string $daftar) {
    $this->actingAs(adminSpaUser())
        ->get(route($buat))
        ->assertSuccessful()
        ->assertSeeHtml('wire:navigate href="'.route($daftar).'"');
})->with([
    'berita' => ['admin.beritas.create', 'admin.beritas.index'],
    'fasilitas' => ['admin.fasilitas.create', 'admin.fasilitas.index'],
    'profil guru' => ['admin.gurus.create', 'admin.gurus.index'],
    'kontak' => ['admin.kontaks.create', 'admin.kontaks.index'],
    'carousel' => ['admin.carousels.create', 'admin.carousels.index'],
]);

test('tabel berita memakai navigasi SPA untuk tombol tambah dan edit', function () {
    $berita = Berita::factory()->create();

    $this->actingAs(adminSpaUser())
        ->get(route('admin.beritas.index'))
        ->assertSuccessful()
        ->assertSeeHtml('wire:navigate href="'.route('admin.beritas.create').'"')
        ->assertSeeHtml('wire:navigate href="'.route('admin.beritas.edit', $berita).'"');
});

test('tombol batal di halaman edit berita memakai navigasi SPA', function () {
    $berita = Berita::factory()->create();

    $this->actingAs(adminSpaUser())
        ->get(route('admin.beritas.edit', $berita))
        ->assertSuccessful()
        ->assertSeeHtml('wire:navigate href="'.route('admin.beritas.index').'"');
});

test('link export tidak memakai navigasi SPA', function () {
    $this->actingAs(adminSpaUser())
        ->get(route('admin.mtsputras.index'))
        ->assertSuccessful()
        ->assertDontSeeHtml('wire:navigate href="'.route('admin.mtsputras.export').'"');
});
