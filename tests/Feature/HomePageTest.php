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

test('profil pesantren dan tiga foto tampil tepat setelah visi misi', function () {
    $response = $this->get(route('home'))->assertSuccessful()
        ->assertSee('Memadukan pendidikan agama, ilmu pengetahuan, pembinaan karakter, dan pengembangan potensi santri.')
        ->assertDontSee("Pondok Pesantren Syafa'aturrasul merupakan lembaga pendidikan Islam", false)
        ->assertSee("Membangun Generasi Qur'ani, Berakhlak Mulia, Berilmu, dan Berprestasi", false)
        ->assertSee('MTs Putra, MTs Putri, MA Putra, dan MA Putri')
        ->assertSee('Akreditasi A')
        ->assertSee('Berkomitmen mencetak generasi muslim yang beriman, berilmu, berakhlak mulia, mandiri, dan siap menghadapi tantangan zaman.')
        ->assertDontSee('Dengan lingkungan pendidikan yang islami, tenaga pendidik yang berdedikasi')
        ->assertSeeHtml('</strong> ber <strong')
        ->assertDontSee('Kami menyelenggarakan pendidikan melalui empat satuan pendidikan')
        ->assertSee('Menanamkan Nilai Islam, Membangun Generasi Masa Depan.');
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    $section = $xpath->query('//section[@aria-labelledby="visi-misi-heading"]/following-sibling::*[1]')->item(0);

    expect($section->getAttribute('aria-labelledby'))->toBe('profil-pesantren-heading');
    $images = $xpath->query('.//img', $section);
    expect($images->length)->toBe(3);
    expect($xpath->query('.//figure/following-sibling::p', $section)->length)->toBe(3);
    expect($section->getAttribute('class'))->toContain('max-w-5xl');
    foreach ($xpath->query('.//figure', $section) as $figure) {
        expect($figure->parentNode->getAttribute('class'))->toContain('items-center', 'gap-3');
    }

    foreach (['profil-santriwati.webp', 'profil-santri-quran.webp', 'profil-santri-pramuka.webp'] as $index => $filename) {
        $image = $images->item($index);
        $dimensions = getimagesize(public_path('images/'.$filename));
        $source = imagecreatefromwebp(public_path('images/'.$filename));
        expect(imagecolorat($source, 0, 0) >> 24)->toBe(127);
        imagedestroy($source);
        expect($image->parentNode->getAttribute('class'))->not->toContain('bg-', 'rounded-', 'border');
        expect($image->getAttribute('src'))->toBe(asset('images/'.$filename))
            ->and($image->getAttribute('loading'))->toBe('lazy')
            ->and($image->getAttribute('alt'))->not->toBeEmpty()
            ->and((int) $image->getAttribute('width'))->toBe($dimensions[0])
            ->and((int) $image->getAttribute('height'))->toBe($dimensions[1]);
    }
});

test('banner pondok tampil tepat setelah profil dengan rasio gambar asli', function () {
    $response = $this->get(route('home'))->assertSuccessful();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    $image = $xpath->query('//section[@aria-labelledby="profil-pesantren-heading"]/following-sibling::*[1][self::figure]/img')->item(0);

    expect($image)->not->toBeNull();
    expect($image->getAttribute('src'))->toBe(asset('images/profil-pondok-syafaaturrasul.webp'))
        ->and($image->getAttribute('alt'))->not->toBeEmpty();

    $dimensions = getimagesize(public_path('images/profil-pondok-syafaaturrasul.webp'));

    expect((int) $image->getAttribute('width'))->toBe($dimensions[0])
        ->and((int) $image->getAttribute('height'))->toBe($dimensions[1]);
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
        ->assertDontSeeHtml('href="'.route('foto.index').'"')
        ->assertDontSeeHtml('href="'.route('uangmasuk.index').'"');
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
        ->assertSee('Hubungi kami melalui halaman kontak')
        ->assertDontSee('Jam Layanan');
});
