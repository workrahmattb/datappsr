<?php

use App\Livewire\CariSiswaTable;
use App\Models\Setting;

test('halaman utama dapat diakses', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee("Pondok Pesantren Syafa'aturrasul", false);
});

test('halaman utama menyediakan tautan ke layanan utama', function () {
    $response = $this->get(route('home'))->assertSuccessful();

    $response->assertSeeHtml('href="'.route('psb').'"')
        ->assertSeeHtml('href="'.route('pendaftaran').'"')
        ->assertSeeHtml('href="'.route('foto.index').'"')
        ->assertSeeHtml('href="'.route('uangmasuk.index').'"');
});

test('halaman utama tidak lagi memuat komponen pencarian siswa', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertDontSeeLivewire(CariSiswaTable::class);
});

test('halaman psb dapat diakses dan memuat pencarian siswa', function () {
    $this->get(route('psb'))
        ->assertSuccessful()
        ->assertSeeLivewire(CariSiswaTable::class)
        ->assertSee('Cari Data');
});

test('halaman utama menampilkan kontak lembaga bila sudah diisi', function () {
    Setting::set('kontak_alamat', 'Jl. Pesantren No. 1, Kuantan Singingi');
    Setting::set('kontak_email', 'info@ppsr.local');

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Hubungi Kami')
        ->assertSee('Jl. Pesantren No. 1, Kuantan Singingi')
        ->assertSee('info@ppsr.local');
});

test('detail kontak lembaga diganti pesan pengisian bila masih kosong', function () {
    Setting::set('kontak_alamat', '');
    Setting::set('kontak_email', '');
    Setting::set('kontak_telepon', '');
    Setting::set('kontak_whatsapp', '');
    Setting::set('kontak_jam_layanan', '');

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Hubungi Kami')
        ->assertSee('Informasi kontak dapat diisi melalui menu Pengaturan')
        ->assertDontSee('Jam Layanan');
});
