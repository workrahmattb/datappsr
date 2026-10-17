<?php

use App\Support\HtmlSanitizer;

test('mempertahankan tag dan atribut yang diizinkan', function () {
    $input = '<h2>Judul</h2><p>Halo <strong>Bold</strong>, <em>miring</em>, <u>garis</u>.</p>'
        .'<ul><li>satu</li><li>dua</li></ul>'
        .'<blockquote>Kutipan</blockquote>'
        .'<a href="https://contoh.test" title="tautan">Link</a>'
        .'<img src="https://contoh.test/g.jpg" alt="gambar">';

    $hasil = HtmlSanitizer::clean($input);

    expect($hasil)
        ->toContain('<h2>Judul</h2>')
        ->toContain('<strong>Bold</strong>')
        ->toContain('<em>miring</em>')
        ->toContain('<u>garis</u>')
        ->toContain('<li>satu</li>')
        ->toContain('<blockquote>Kutipan</blockquote>')
        ->toContain('href="https://contoh.test"')
        ->toContain('title="tautan"')
        ->toContain('rel="noopener noreferrer"')
        ->toContain('alt="gambar"');
});

test('membuang elemen berbahaya beserta isinya', function () {
    $hasil = HtmlSanitizer::clean(
        '<p>Aman</p>'
        .'<script>alert(1)</script>'
        .'<iframe src="http://contoh.test"></iframe>'
        .'<style>body{display:none}</style>'
        .'<svg><circle /></svg>'
        .'<form><input name="x"></form>'
    );

    expect($hasil)->toBe('<p>Aman</p>');
});

test('membuang atribut event handler dan inline style', function () {
    $hasil = HtmlSanitizer::clean(
        '<p onclick="evil()" style="color:red">Teks</p>'
        .'<img src="https://contoh.test/a.jpg" onerror="alert(1)">'
    );

    expect($hasil)
        ->not->toContain('onclick')
        ->not->toContain('onerror')
        ->not->toContain('style=')
        ->toContain('<p>Teks</p>')
        ->toContain('src="https://contoh.test/a.jpg"');
});

test('membuang skema URL berbahaya', function (string $url) {
    $hasil = HtmlSanitizer::clean('<a href="'.$url.'">klik</a>');

    expect($hasil)
        ->toContain('klik')
        ->not->toContain('href');
})->with([
    'javascript' => 'javascript:alert(1)',
    'javascript dengan tab' => 'java&#09;script:alert(1)',
    'vbscript' => 'vbscript:msgbox(1)',
    'data uri' => 'data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==',
]);

test('mengizinkan URL relatif dan skema aman', function (string $url) {
    $hasil = HtmlSanitizer::clean('<a href="'.$url.'">klik</a>');

    expect($hasil)->toContain('href');
})->with([
    'relatif' => '/storage/konten/berita/isi/gambar.jpg',
    'anchor' => '#bagian',
    'https' => 'https://ppsr.example.com',
    'mailto' => 'mailto:info@ppsr.example.com',
    'tel' => 'tel:+628123456789',
]);

test('membuka tag yang tidak dikenal tetapi teksnya tetap ada', function () {
    $hasil = HtmlSanitizer::clean('<custom-tag>Isi penting</custom-tag><p>Setelahnya</p>');

    expect($hasil)
        ->toContain('Isi penting')
        ->toContain('<p>Setelahnya</p>')
        ->not->toContain('custom-tag');
});

test('mengembalikan string kosong untuk input kosong', function (?string $input) {
    expect(HtmlSanitizer::clean($input))->toBe('');
})->with([
    'null' => null,
    'string kosong' => '',
    'spasi saja' => '   ',
]);

test('mengambil src dari kode embed', function () {
    $kode = '<iframe src="https://www.google.com/maps/embed?pb=abc&amp;hl=id"></iframe>';

    expect(HtmlSanitizer::embedUrl($kode))->toBe('https://www.google.com/maps/embed?pb=abc&hl=id');
});

test('menerima url langsung sebagai kode embed', function () {
    expect(HtmlSanitizer::embedUrl('https://www.google.com/maps/embed?pb=abc'))
        ->toBe('https://www.google.com/maps/embed?pb=abc');
});

test('menolak embed kosong atau tidak aman', function (?string $input) {
    expect(HtmlSanitizer::embedUrl($input))->toBeNull();
})->with([
    'null' => null,
    'kosong' => '',
    'spasi saja' => '   ',
    'javascript' => '<iframe src="javascript:alert(1)"></iframe>',
    'data uri' => 'data:text/html;base64,PHNjcmlwdD4=',
]);
