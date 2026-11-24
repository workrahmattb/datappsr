<?php

use App\Models\Pendaftaran;
use App\Models\Setting;
use Livewire\Volt\Volt;

test('public registration summary limits data to active year and public fields', function () {
    Setting::set('tahun_ajaran_aktif', '2026/2027');
    $data = ['nama' => 'Nama Rahasia', 'nisn' => '1234567890', 'tempat_lahir' => 'Tempat Rahasia',
        'tanggal_lahir' => '2013-01-02', 'asal_sekolah' => 'Sekolah Rahasia', 'alamat' => 'Alamat Rahasia',
        'nama_ayah' => 'Ayah Rahasia', 'nama_ibu' => 'Ibu Rahasia', 'no_hp' => '08999999999',
        'jenjang_pendidikan' => 'MTs Putra', 'tahun_ajaran' => '2026/2027'];
    Pendaftaran::create($data);
    Pendaftaran::create(array_replace($data, ['nama' => 'Pendaftar Tahun Lama', 'nisn' => '1234567891', 'tahun_ajaran' => '2025/2026']));
    $this->get('/rekap-pendaftaran')->assertOk()->assertSee('Rekap Pendaftaran')->assertSee('Nama Rahasia')->assertSee('Sekolah Rahasia')->assertDontSee('Pendaftar Tahun Lama')->assertDontSee('Alamat Rahasia')->assertDontSee('Ayah Rahasia')->assertDontSee('Ibu Rahasia')->assertDontSee('Tempat Rahasia')->assertDontSee('08999999999');
    Volt::test('site.pendaftar')->assertViewHas('total', 1)
        ->assertViewHas('registrations', fn ($rows) => array_keys($rows->first()->getAttributes()) === ['id', 'nama', 'jenjang_pendidikan', 'nama_sekolah_sebelumnya', 'asal_sekolah']);
});

test('public summary handles an empty year', function () {
    Setting::set('tahun_ajaran_aktif', '2099/2100');
    $this->get('/rekap-pendaftaran')->assertOk()->assertSee('Belum ada pendaftaran');
    Volt::test('site.pendaftar')->assertViewHas('total', 0);
});

test('public registration numbering continues across pages', function () {
    Setting::set('tahun_ajaran_aktif', '2026/2027');
    for ($index = 0; $index < 26; $index++) {
        Pendaftaran::create([
            'nama' => 'Uji', 'nisn' => str_pad((string) $index, 10, '0', STR_PAD_LEFT),
            'tempat_lahir' => 'Uji', 'tanggal_lahir' => '2013-01-01',
            'asal_sekolah' => 'SD', 'alamat' => 'Uji', 'nama_ayah' => 'Ayah',
            'nama_ibu' => 'Ibu', 'no_hp' => '08123456789',
            'jenjang_pendidikan' => 'MTs Putra', 'tahun_ajaran' => '2026/2027',
        ]);
    }
    $component = Volt::test('site.pendaftar')->call('setPage', 2);
    $document = new DOMDocument;
    @$document->loadHTML($component->html());
    $xpath = new DOMXPath($document);
    expect(trim($xpath->query('//tbody/tr/td[1]')->item(0)->textContent))->toBe('26');
});
