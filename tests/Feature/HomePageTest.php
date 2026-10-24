<?php

use App\Livewire\CariSiswaTable;
use App\Models\Berita;
use App\Models\Carousel;
use App\Models\Setting;

test('halaman utama menampilkan visi dan enam misi dengan atau tanpa carousel', function (bool $denganCarousel) {
    if ($denganCarousel) {
        Carousel::factory()->create(['is_active' => true]);
    }

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeInOrder([
            'Visi Pesantren',
            'Menjadi Lembaga Islam Yang Kokoh dalam Melahirkan Generasi Penghafal Al Qur’an Berakhlak Mulia Dan Berwawasan Dunia.',
            'Misi Pesantren',
            'Melahirkan Santri & Santriwati:',
            'Hafal Al-Quran dan 100 Hadits',
            'Berkarakter 10 Muwasofat',
            'Aktif Berkomunikasi dengan Bahasa asing',
            'Berjiwa Pemimpin dan Wirausaha',
            'Berprestasi dalam Segala Bidang',
            'Lulus PTN dan Swasta Favorit & Lulus Perguruan Tinggi Luar Negeri',
        ]);
})->with(['tanpa carousel' => false, 'dengan carousel' => true]);

test('halaman utama dapat diakses', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee("Pondok Pesantren Syafa'aturrasul", false);
});

test('berita dan pengumuman berada tepat sebelum lokasi pondok', function () {
    Berita::factory()->published()->create();

    $response = $this->get(route('home'))->assertSuccessful();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    $heading = $xpath->query('//section[@aria-labelledby="lokasi-pondok-heading"]/preceding-sibling::*[1]//h2')->item(0);

    expect($heading)->not->toBeNull();
    expect(trim($heading->textContent))->toBe('Berita & Pengumuman');
});

test('halaman utama memasangkan peta dan tautan dengan pondok yang tepat', function () {
    $response = $this->get(route('home'))->assertSuccessful();

    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    expect(trim($xpath->query('//h2[@id="lokasi-pondok-heading"]')->item(0)->textContent))
        ->toBe("Lokasi Pondok Pesantren Syafa'aturasul");
    $cards = $xpath->query('//section[@aria-labelledby="lokasi-pondok-heading"]//article');

    expect($cards->length)->toBe(2);

    foreach ([
        ['Pondok Putri', '-0.5124461,101.577084', 'https://maps.app.goo.gl/1aHyy2XN8Qn6W7h76'],
        ['Pondok Putra', '-0.415269,101.6124704', 'https://maps.app.goo.gl/dmS8nThqcXPSDhe4A'],
    ] as $index => [$label, $coordinates, $url]) {
        $card = $cards->item($index);
        $frame = $xpath->query('.//iframe', $card)->item(0);
        $link = $xpath->query('.//a', $card)->item(0);

        expect(trim($xpath->query('.//h3', $card)->item(0)->textContent))->toBe($label)
            ->and($frame->getAttribute('src'))->toBe('https://www.google.com/maps?q='.$coordinates.'&z=16&output=embed')
            ->and($frame->getAttribute('title'))->toContain($label)
            ->and($frame->getAttribute('loading'))->toBe('lazy')
            ->and($link->getAttribute('href'))->toBe($url)
            ->and($link->getAttribute('target'))->toBe('_blank')
            ->and($link->getAttribute('rel'))->toBe('noopener noreferrer')
            ->and($link->hasAttribute('wire:navigate'))->toBeFalse();
    }
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
