<?php

use App\Livewire\Admin\KontakLembagaSettings;
use App\Livewire\Admin\KontaksTable;
use App\Models\Kontak;
use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;

function adminKontak(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.kontaks.index'))->assertRedirect(route('login'));
});

test('user non-admin tidak boleh mengakses kontak', function () {
    $user = User::factory()->create(['role' => 'maputri']);

    $this->actingAs($user)->get(route('admin.kontaks.index'))->assertForbidden();
});

test('admin bisa melihat daftar kontak', function () {
    Kontak::factory()->create(['nama' => 'Ustadz Zaid']);

    $this->actingAs(adminKontak())
        ->get(route('admin.kontaks.index'))
        ->assertSuccessful()
        ->assertSee('Ustadz Zaid');
});

test('admin bisa menambah kontak', function () {
    $this->actingAs(adminKontak())
        ->post(route('admin.kontaks.store'), [
            'unit' => 'PSB',
            'nama' => 'Ustadz Zaid',
            'jabatan' => 'Panitia PSB',
            'telepon' => '08123456789',
            'whatsapp' => '628123456789',
            'email' => 'zaid@ppsr.local',
            'alamat' => 'Jl. Pesantren',
            'urutan' => 1,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.kontaks.index'));

    $kontak = Kontak::where('nama', 'Ustadz Zaid')->first();

    expect($kontak)->not->toBeNull()
        ->and($kontak->unit)->toBe('PSB')
        ->and($kontak->is_active)->toBeTrue()
        ->and($kontak->whatsapp_link)->toBe('https://wa.me/628123456789');
});

test('nama kontak wajib diisi', function () {
    $this->actingAs(adminKontak())
        ->post(route('admin.kontaks.store'), [])
        ->assertSessionHasErrors(['nama']);
});

test('nomor whatsapp berawalan 0 dikonversi ke 62', function () {
    $kontak = Kontak::create(['nama' => 'Panitia', 'whatsapp' => '0812-3456-7890']);

    expect($kontak->whatsapp_link)->toBe('https://wa.me/6281234567890');
});

test('admin bisa memperbarui kontak', function () {
    $kontak = Kontak::factory()->create(['nama' => 'Nama Lama']);

    $this->actingAs(adminKontak())
        ->put(route('admin.kontaks.update', $kontak), [
            'nama' => 'Nama Baru',
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.kontaks.index'));

    expect($kontak->refresh()->nama)->toBe('Nama Baru');
});

test('admin bisa menghapus kontak', function () {
    $kontak = Kontak::factory()->create();

    $this->actingAs(adminKontak())
        ->delete(route('admin.kontaks.destroy', $kontak))
        ->assertRedirect(route('admin.kontaks.index'));

    expect(Kontak::find($kontak->id))->toBeNull();
});

test('tabel kontak bisa dicari', function () {
    Kontak::factory()->create(['nama' => 'Ustadz Zaid', 'unit' => 'PSB']);
    Kontak::factory()->create(['nama' => 'Ustadzah Salma', 'unit' => 'Akademik']);

    Livewire::actingAs(adminKontak())
        ->test(KontaksTable::class)
        ->set('search', 'Zaid')
        ->assertSee('Ustadz Zaid')
        ->assertDontSee('Ustadzah Salma');
});

test('hapus dari tabel kontak menghapus data', function () {
    $kontak = Kontak::factory()->create();

    Livewire::actingAs(adminKontak())
        ->test(KontaksTable::class)
        ->call('confirmDelete', $kontak->id)
        ->assertSet('deleteId', $kontak->id)
        ->call('deleteConfirmed');

    expect(Kontak::find($kontak->id))->toBeNull();
});

test('admin bisa menyimpan kontak lembaga', function () {
    Livewire::actingAs(adminKontak())
        ->test(KontakLembagaSettings::class)
        ->set('alamat', 'Jl. Pesantren No. 1')
        ->set('telepon', '021-1234567')
        ->set('whatsapp', '6285259875754')
        ->set('email', 'info@ppsr.local')
        ->set('jamLayanan', 'Senin - Sabtu, 07.00 - 16.00 WIB')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::value('kontak_alamat'))->toBe('Jl. Pesantren No. 1')
        ->and(Setting::value('kontak_whatsapp'))->toBe('6285259875754')
        ->and(Setting::value('kontak_email'))->toBe('info@ppsr.local');
});

test('email kontak lembaga harus berformat valid', function () {
    Livewire::actingAs(adminKontak())
        ->test(KontakLembagaSettings::class)
        ->set('email', 'bukan-email')
        ->call('save')
        ->assertHasErrors(['email']);
});

test('halaman kontak lembaga bisa diakses admin', function () {
    $this->actingAs(adminKontak())
        ->get(route('admin.kontak-lembaga.index'))
        ->assertSuccessful()
        ->assertSee('Kontak Lembaga');
});
