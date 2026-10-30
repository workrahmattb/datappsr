<?php

use App\Livewire\Admin\Settings;
use App\Livewire\DaftarUlangForm;
use App\Livewire\PendaftaranForm;
use App\Models\Setting;
use App\Models\User;
use App\Support\AdmissionPeriod;
use Livewire\Livewire;

beforeEach(function () {
    Setting::set('tahun_ajaran_aktif', '2026/2027');
});

test('each stage independently controls public registration pages', function ($stage, $registration, $reregistration) {
    Setting::set(AdmissionPeriod::key('2026/2027'), $stage);
    expect(AdmissionPeriod::registrationOpen())->toBe($registration)
        ->and(AdmissionPeriod::reregistrationOpen())->toBe($reregistration);
    $response = $this->get('/pendaftaran')->assertOk();
    $registration ? $response->assertDontSee('Pendaftaran ditutup') : $response->assertSee('Pendaftaran ditutup');
    $response = $this->get('/daftar-ulang')->assertOk();
    $reregistration ? $response->assertDontSee('Daftar ulang ditutup') : $response->assertSee('Daftar ulang ditutup');
    if (! $reregistration) {
        $this->get('/daftar-ulang/999')->assertOk()->assertSee('Daftar ulang ditutup');
    }
})->with([
    ['registration', true, false], ['both', true, true],
    ['reregistration', false, true], ['closed', false, false],
]);

test('admin can save stages and invalid stages are rejected', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $component = Livewire::actingAs($admin)->test(Settings::class);
    foreach (array_keys(AdmissionPeriod::STAGES) as $stage) {
        $component->set('admissionStage', $stage)->call('saveAdmissionPeriod')->assertHasNoErrors();
        expect(AdmissionPeriod::stage())->toBe($stage);
    }
    $component->set('admissionStage', 'invalid')->call('saveAdmissionPeriod')->assertHasErrors('admissionStage');
    expect(AdmissionPeriod::stage())->toBe('closed');
});

test('non admin cannot change admission period', function () {
    Livewire::actingAs(User::factory()->create(['role' => 'guru']))->test(Settings::class)
        ->set('admissionStage', 'closed')->call('saveAdmissionPeriod')->assertForbidden();
    expect(AdmissionPeriod::stage())->toBe('both');
});

test('stages are isolated by year and stale settings cannot change another year', function () {
    Setting::set(AdmissionPeriod::key('2026/2027'), 'closed');
    $component = Livewire::actingAs(User::factory()->create(['role' => 'admin']))->test(Settings::class);
    Setting::set('tahun_ajaran_aktif', '2027/2028');
    $component->set('admissionStage', 'registration')->call('saveAdmissionPeriod')->assertHasErrors('admissionStage');
    expect(AdmissionPeriod::stage())->toBe('both')->and(AdmissionPeriod::stage('2026/2027'))->toBe('closed');
});

test('closing period prevents a previously opened registration form submitting', function () {
    $component = Livewire::test(PendaftaranForm::class);
    Setting::set(AdmissionPeriod::key('2026/2027'), 'closed');
    $component->call('submit')->assertHasNoErrors()->assertSet('submitted', false)->assertSee('Pendaftaran ditutup');
    $this->assertDatabaseCount('pendaftarans', 0);
});

test('closed re registration blocks both submission steps before processing files', function () {
    Setting::set(AdmissionPeriod::key('2026/2027'), 'closed');
    Livewire::test(DaftarUlangForm::class, ['id' => 999])
        ->call('submitStep1')->assertSet('currentStep', 1)
        ->call('submit')->assertSet('submitted', false)->assertHasNoErrors();
});

test('pending registrations remain available only in their active year', function () {
    $registration = \App\Models\Pendaftaran::create([
        'nisn' => '1234567890', 'nama' => 'Santri Periode Uji',
        'jenjang_pendidikan' => 'MTs Putra', 'tahun_ajaran' => '2026/2027',
        'tempat_lahir' => 'Teluk Kuantan', 'tanggal_lahir' => '2013-01-01',
        'asal_sekolah' => 'SD Uji', 'alamat' => 'Alamat Uji',
        'nama_ayah' => 'Ayah', 'nama_ibu' => 'Ibu', 'no_hp' => '08123456789',
        'buktitransfer' => 'test.jpg', 'status_pendaftaran' => 'pending',
    ]);
    $component = Livewire::test(DaftarUlangForm::class, ['id' => $registration->id])->assertSet('nama', 'Santri Periode Uji');
    Setting::set(AdmissionPeriod::key('2026/2027'), 'closed');
    $component->call('submitStep1')->assertHasNoErrors()->assertSee('Daftar ulang ditutup');
    $component->call('submit')->assertHasNoErrors()->assertSet('submitted', false);
    expect($registration->fresh()->status_pendaftaran)->toBe('pending');
    Setting::set('tahun_ajaran_aktif', '2027/2028');
    $this->get('/daftar-ulang/'.$registration->id)->assertNotFound();
    expect(fn () => $component->call('submit'))->toThrow(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
    $this->assertDatabaseCount('pendaftarans', 1);
});

test('search tables show re registration actions only while the period is open', function ($stage, $visible) {
    $registration = \App\Models\Pendaftaran::create([
        'nisn' => '1234567890', 'nama' => 'Santri Pencarian Uji',
        'jenjang_pendidikan' => 'MTs Putra', 'tahun_ajaran' => '2026/2027',
        'tempat_lahir' => 'Teluk Kuantan', 'tanggal_lahir' => '2013-01-01',
        'asal_sekolah' => 'SD Uji', 'alamat' => 'Alamat Uji',
        'nama_ayah' => 'Ayah', 'nama_ibu' => 'Ibu', 'no_hp' => '08123456789',
        'buktitransfer' => 'test.jpg', 'status_pendaftaran' => 'pending',
    ]);
    Setting::set(AdmissionPeriod::key('2026/2027'), $stage);
    foreach ([\App\Livewire\CariSiswaTable::class, \App\Livewire\PendaftaranTable::class] as $table) {
        $component = Livewire::test($table)->set('search', 'Santri Pencarian')->assertSee('Santri Pencarian Uji');
        $url = route('daftar-ulang.form', $registration->id);
        expect(substr_count($component->html(), $url))->toBe($visible ? 2 : 0);
        Setting::set(AdmissionPeriod::key('2026/2027'), 'closed');
        $component->call('$refresh')->assertDontSee($url, false)->assertSee('Santri Pencarian Uji');
        Setting::set(AdmissionPeriod::key('2026/2027'), $stage);
    }
})->with([['registration', false], ['both', true], ['reregistration', true], ['closed', false]]);

test('kolom identitas dan tanggal daftar ulang memiliki atribut ramah perangkat mobile', function () {
    $html = view('livewire.daftar-ulang-form', [
        'errors' => new \Illuminate\Support\ViewErrorBag,
        'submitted' => false, 'currentStep' => 2, 'jenjangPendidikan' => 'MTs Putra',
        'nama' => 'Santri Uji', 'nisn' => '1234567890', 'tahun_ajaran' => '2026/2027',
        'fototransferPath' => null, 'fototransfer' => null,
        'fotokk' => null, 'fotoakta' => null, 'foto' => null,
        'pekerjaan_ayah' => '', 'pekerjaan_ibu' => '',
    ])->render();
    expect($html)->not->toContain('Beranda');
    expect($html)->toContain('data-reregistration-submit', 'wire:loading.flex', 'sm:min-w-52')
        ->not->toContain('style="width: 65%"');
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$html);
    $xpath = new DOMXPath($document);
    foreach (['nik', 'nik_ayah', 'nik_ibu', 'kk', 'nisn', 'npsn_sekolah_sebelumnya'] as $field) {
        $input = $xpath->query('//input[@*[name()="wire:model"]="'.$field.'"]')->item(0);
        expect($input)->not->toBeNull();
        expect($input->getAttribute('type'))->toBe('text')
            ->and($input->getAttribute('inputmode'))->toBe('numeric');
        if (in_array($field, ['nik', 'nik_ayah', 'nik_ibu', 'kk', 'nisn'])) {
            expect($input->getAttribute('maxlength'))->toBe($field === 'nisn' ? '10' : '16');
        }
    }
    foreach (['anak_ke' => '1', 'jumlah_saudara' => '0'] as $field => $minimum) {
        $input = $xpath->query('//input[@*[name()="wire:model"]="'.$field.'"]')->item(0);
        expect($input)->not->toBeNull();
        expect($input->getAttribute('type'))->toBe('number')
            ->and($input->getAttribute('inputmode'))->toBe('numeric')
            ->and($input->getAttribute('step'))->toBe('1')
            ->and($input->getAttribute('min'))->toBe($minimum);
    }
    foreach (['tanggal_lahir', 'tanggal_lahir_ayah', 'tanggal_lahir_ibu'] as $field) {
        $input = $xpath->query('//input[@*[name()="wire:model"]="'.$field.'"]')->item(0);
        expect($input)->not->toBeNull();
        expect($input->getAttribute('type'))->toBe('date');
        foreach (['block', 'box-border', 'min-w-0', 'max-w-full', 'w-full', 'appearance-none', 'text-base'] as $class) {
            expect(explode(' ', $input->getAttribute('class')))->toContain($class);
        }
        expect($input->parentNode->getAttribute('class'))->toContain('min-w-0');
    }

});

test('template daftar ulang tidak menyediakan tombol Beranda pada semua tahap', function () {
    $template = file_get_contents(resource_path('views/livewire/daftar-ulang-form.blade.php'));
    expect($template)->not->toContain('Beranda')
        ->toContain('Kembali ke Daftar', 'wire:submit.prevent="submit"');
});
