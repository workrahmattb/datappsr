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
