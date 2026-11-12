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

    $registration = \App\Models\Pendaftaran::query()->where('nisn', '1234567890')->firstOrFail();
    Storage::disk('public')->assertExists($registration->buktitransfer);
    $url = Storage::disk('public')->url($registration->buktitransfer);
    $this->actingAs(\App\Models\User::factory()->create(['role' => 'admin']));
    $this->get(route('admin.pendaftarans.index'))->assertOk()->assertSee($url)->assertSeeText('Alamat pengujian');
    $this->get(route('admin.pendaftarans.show', $registration))->assertOk()->assertSee($url);

    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$component->html());
    $xpath = new DOMXPath($document);
    $actions = $xpath->query('//*[@data-registration-success-actions]')->item(0);
    expect($actions)->not->toBeNull();
    $backLink = $xpath->query('.//a', $actions)->item(0);
    expect($backLink->getAttribute('href'))->toBe(route('psb'));
    expect(trim($backLink->textContent))->toBe('Kembali ke PSB');

    expect($actions->getAttribute('class'))->toContain('grid-cols-1', 'sm:grid-cols-2');
    $button = $xpath->query('.//button', $actions)->item(0);
    expect($button->getAttribute('type'))->toBe('button');
    expect($button->getAttribute('class'))->toContain('min-w-0', 'min-h-12')->not->toContain('hover:scale-105');
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

test('oversized receipt explains the size limit until replaced', function () {
    Storage::fake('public');
    $message = 'File bukti transfer terlalu besar. Silakan unggah file berukuran maksimal 2 MB.';
    $file = fn (int $kb) => UploadedFile::fake()->createWithContent('bukti.pdf', str_pad('%PDF-1.4', $kb * 1024));

    Livewire::test(PendaftaranForm::class)
        ->set('buktitransfer', $file(2049))
        ->assertHasErrors(['buktitransfer' => 'max'])
        ->assertSee($message)
        ->call('submit')
        ->assertSee($message)
        ->set('buktitransfer', $file(2048))
        ->assertHasNoErrors('buktitransfer')
        ->assertDontSee($message);
});
