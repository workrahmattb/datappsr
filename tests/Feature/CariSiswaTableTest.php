<?php

use App\Livewire\CariSiswaTable;
use App\Models\Mtsputra;
use App\Models\Pendaftaran;
use Livewire\Livewire;

test('pencarian tidak dijalankan jika kata kunci kurang dari 3 huruf', function () {
    Mtsputra::create([
        'nama' => 'Ahmad Fauzi',
        'nisn' => '1111111111',
        'tahun_ajaran' => activeTahunAjaran(),
    ]);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Ah')
        ->assertSee('Ketik minimal 3 huruf')
        ->assertDontSee('Ahmad Fauzi')
        ->assertDontSee('Data tidak ditemukan');
});

test('pencarian dijalankan jika kata kunci minimal 3 huruf', function () {
    Mtsputra::create([
        'nama' => 'Ahmad Fauzi',
        'nisn' => '1111111111',
        'tahun_ajaran' => activeTahunAjaran(),
    ]);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Ahm')
        ->assertSee('Ahmad Fauzi')
        ->assertSee('Ditemukan');
});

test('menampilkan pesan data tidak ditemukan untuk kata kunci valid tanpa hasil', function () {
    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Zzz')
        ->assertSee('Data tidak ditemukan');
});

test('spasi di awal dan akhir kata kunci diabaikan', function () {
    Mtsputra::create([
        'nama' => 'Ahmad Fauzi',
        'nisn' => '1111111111',
        'tahun_ajaran' => activeTahunAjaran(),
    ]);

    Livewire::test(CariSiswaTable::class)
        ->set('search', '  Ahm  ')
        ->assertSee('Ahmad Fauzi');
});

test('kata kunci berisi spasi saja tidak dianggap sebagai pencarian', function () {
    Mtsputra::create([
        'nama' => 'Ahmad Fauzi',
        'nisn' => '1111111111',
        'tahun_ajaran' => activeTahunAjaran(),
    ]);

    Livewire::test(CariSiswaTable::class)
        ->set('search', '   ')
        ->assertSee('Ketik nama siswa untuk mencari')
        ->assertDontSee('Ahmad Fauzi');
});

test('pendaftar yang masih pending ikut ditemukan', function () {
    Pendaftaran::create([
        'nama' => 'Budi Santoso',
        'nisn' => '2222222222',
        'tahun_ajaran' => activeTahunAjaran(),
        'status_pendaftaran' => 'pending',
    ]);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Budi')
        ->assertSee('Budi Santoso')
        ->assertSee('Daftar Ulang');
});

test('halaman /psb dapat diakses dan memuat komponen pencarian', function () {
    $this->get(route('psb'))
        ->assertSuccessful()
        ->assertSeeLivewire(CariSiswaTable::class);
});

/**
 * Membuat data siswa uji sejumlah $jumlah dengan nama berurutan
 * (Siswa Uji 01, Siswa Uji 02, dst.) agar urutan pagination mudah diuji.
 */
function buatSiswaUjiPagination(int $jumlah): void
{
    foreach (range(1, $jumlah) as $index) {
        $nomor = str_pad((string) $index, 2, '0', STR_PAD_LEFT);

        Mtsputra::create([
            'nama' => 'Siswa Uji '.$nomor,
            'nisn' => '90000000'.$nomor,
            'tahun_ajaran' => activeTahunAjaran(),
        ]);
    }
}

test('hanya menampilkan 10 data per halaman', function () {
    buatSiswaUjiPagination(12);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji')
        ->assertSeeText('Ditemukan 12 data siswa')
        ->assertSee('Siswa Uji 01')
        ->assertSee('Siswa Uji 10')
        ->assertDontSee('Siswa Uji 11')
        ->assertDontSee('Siswa Uji 12');
});

test('halaman kedua menampilkan sisa data', function () {
    buatSiswaUjiPagination(12);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji')
        ->call('gotoPage', 2)
        ->assertSee('Siswa Uji 11')
        ->assertSee('Siswa Uji 12')
        ->assertDontSee('Siswa Uji 01');
});

test('info rentang data hanya muncul jika hasil lebih dari 10', function () {
    buatSiswaUjiPagination(12);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji')
        ->assertSeeText('menampilkan 1-10 (10 per halaman)');

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji 12')
        ->assertDontSeeText('per halaman');
});

test('link pagination dijalankan lewat Livewire tanpa reload halaman', function () {
    buatSiswaUjiPagination(12);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji')
        ->assertSeeHtml('wire:click="gotoPage(2');
});

test('mengganti kata kunci mereset pagination ke halaman pertama', function () {
    buatSiswaUjiPagination(12);

    Livewire::test(CariSiswaTable::class)
        ->set('search', 'Siswa Uji')
        ->call('gotoPage', 2)
        ->set('search', 'Siswa Uji 0')
        ->assertSee('Siswa Uji 01')
        ->assertDontSee('Siswa Uji 11');
});
