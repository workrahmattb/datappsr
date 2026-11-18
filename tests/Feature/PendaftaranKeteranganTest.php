<?php

use App\Livewire\Admin\PendaftaransTable;
use App\Models\Pendaftaran;
use App\Models\User;
use Livewire\Livewire;

test('admin saves and clears inline registration notes', function () {
    $registration = Pendaftaran::create([
        'nisn' => '1234567890', 'nama' => 'Uji', 'jenjang_pendidikan' => 'MTs Putra',
        'tempat_lahir' => 'Teluk Kuantan', 'tanggal_lahir' => '2013-01-01',
        'asal_sekolah' => 'SD Uji', 'alamat' => 'Alamat', 'nama_ayah' => 'Ayah',
        'nama_ibu' => 'Ibu', 'no_hp' => '08123456789', 'status_pendaftaran' => 'pending',
    ]);
    $component = Livewire::actingAs(User::factory()->create(['role' => 'admin']))
        ->test(PendaftaransTable::class)
        ->assertSee('rows="3"', false)
        ->assertSee('resize overflow-auto', false)
        ->assertSee('Shift+Enter untuk baris baru.')
        ->assertSee('x-on:keydown.enter="if (!$event.shiftKey && !$event.isComposing)', false)
        ->set("keterangan.{$registration->id}", "Sudah dihubungi\nMenunggu konfirmasi")
        ->call('saveKeterangan', $registration->id)->assertHasNoErrors()->assertSee('Tersimpan');
    expect($registration->fresh()->keterangan)->toBe("Sudah dihubungi\nMenunggu konfirmasi");
    \Illuminate\Support\Facades\Storage::fake('public');
    $component->call('export')->assertDispatched('download-excel');
    $path = \Illuminate\Support\Facades\Storage::disk('public')->files('temp')[0];
    $rows = \Spatie\SimpleExcel\SimpleExcelReader::create(
        \Illuminate\Support\Facades\Storage::disk('public')->path($path)
    )->getRows()->toArray();
    expect($rows[0]['Keterangan'])->toBe("Sudah dihubungi\nMenunggu konfirmasi");

    $component
        ->set("keterangan.{$registration->id}", str_repeat('a', 2001))->call('saveKeterangan', $registration->id)
        ->assertHasErrors("keterangan.{$registration->id}");
    expect($registration->fresh()->keterangan)->toBe("Sudah dihubungi\nMenunggu konfirmasi");
    $component->set("keterangan.{$registration->id}", '')
        ->call('saveKeterangan', $registration->id)->assertHasNoErrors();
    expect($registration->fresh()->keterangan)->toBeNull();
});

test('non admin cannot save notes', function () {
    Livewire::actingAs(User::factory()->create(['role' => 'guru']))
        ->test(PendaftaransTable::class)->call('saveKeterangan', 1)->assertForbidden();
});
