<?php

use App\Livewire\PendaftaranForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('successful registration displays the new WhatsApp group invitation', function () {
    Storage::fake('public');
    $component = Livewire::test(PendaftaranForm::class)
        ->assertDontSee('FMyYh8xiajs6YFDaZwCEmr')
        ->set('nisn', '1234567890')
        ->set('nama', 'Calon Santri Uji')
        ->set('jenjang_pendidikan', 'MTs Putra')
        ->set('tempat_lahir', 'Teluk Kuantan')
        ->set('tanggal_lahir', '2013-01-01')
        ->set('asal_sekolah', 'SD Uji')
        ->set('alamat', 'Alamat pengujian')
        ->set('nama_ayah', 'Ayah Uji')
        ->set('nama_ibu', 'Ibu Uji')
        ->set('no_hp', '081234567890')
        ->set('buktitransfer', UploadedFile::fake()->image('bukti.jpg'))
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true)
        ->assertDontSee('pendaftaran-error-summary', false)
        ->assertDontSee('HKmThd3bFKn4WXBQvs5kYn');

    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$component->html());
    $xpath = new DOMXPath($document);
    $link = $xpath->query('//a[starts-with(@href, "https://chat.whatsapp.com/")]')->item(0);
    expect($link)->not->toBeNull();
    expect($link->getAttribute('href'))->toBe('https://chat.whatsapp.com/FMyYh8xiajs6YFDaZwCEmr?s=cl&p=a&mlu=4&ilr=4')
        ->and($link->getAttribute('target'))->toBe('_blank')
        ->and($link->getAttribute('rel'))->toBe('noopener noreferrer');
});

test('tanggal lahir pendaftaran dibatasi lebar wadah pada layar kecil', function () {
    $html = Livewire::test(PendaftaranForm::class)->html();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$html);
    $input = $document->getElementById('tanggal_lahir');
    expect($input)->not->toBeNull();
    expect($input->getAttribute('type'))->toBe('date');
    $classes = explode(' ', $input->getAttribute('class'));
    foreach (['block', 'box-border', 'min-w-0', 'max-w-full', 'w-full', 'appearance-none', 'text-base'] as $class) {
        expect($classes)->toContain($class);
    }
});

test('ringkasan kesalahan pendaftaran muncul sebelum tombol kirim', function () {
    $component = Livewire::test(PendaftaranForm::class)
        ->assertDontSee('pendaftaran-error-summary', false)
        ->call('submit')
        ->assertHasErrors(['nama', 'tanggal_lahir', 'buktitransfer']);
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$component->html());
    $xpath = new DOMXPath($document);
    $summary = $document->getElementById('pendaftaran-error-summary');
    expect($summary)->not->toBeNull();
    expect($summary->textContent)->toContain('Nama lengkap wajib diisi', 'Tanggal lahir wajib diisi');
    expect($xpath->query('//*[@id="pendaftaran-error-summary"]/following-sibling::div[1]//button[@type="submit"]')->length)->toBe(1);
});
