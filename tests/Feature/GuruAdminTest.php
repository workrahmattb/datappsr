<?php

use App\Livewire\Admin\GurusTable;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function adminGuru(): User
{
    return User::factory()->create(['role' => 'admin']);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function buatGuru(array $attributes = []): Guru
{
    return Guru::create(array_merge([
        'name' => 'Ustadz Ahmad',
        'alamat' => 'Jl. Pesantren No. 1',
        'jabatan' => 'Guru Fiqih',
        'jenis_kelamin' => 'L',
        'is_active' => true,
        'urutan' => 0,
    ], $attributes));
}

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.gurus.index'))->assertRedirect(route('login'));
});

test('user non-admin tidak boleh mengakses profil guru', function () {
    $user = User::factory()->create(['role' => 'mtsputri']);

    $this->actingAs($user)->get(route('admin.gurus.index'))->assertForbidden();
});

test('admin bisa melihat daftar profil guru', function () {
    buatGuru(['name' => 'Ustadz Hasan']);

    $this->actingAs(adminGuru())
        ->get(route('admin.gurus.index'))
        ->assertSuccessful()
        ->assertSee('Ustadz Hasan');
});

test('admin bisa menambah profil guru beserta foto', function () {
    Storage::fake('public');

    $this->actingAs(adminGuru())
        ->post(route('admin.gurus.store'), [
            'name' => 'Ustadzah Fatimah',
            'nip' => '199001012020',
            'jabatan' => 'Guru Bahasa Arab',
            'jenis_kelamin' => 'P',
            'pendidikan' => 'S1 Bahasa Arab',
            'email' => 'fatimah@ppsr.local',
            'no_hp' => '081234567890',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Pesantren No. 2',
            'deskripsi' => 'Pengajar bahasa Arab',
            'urutan' => 3,
            'is_active' => '1',
            'foto' => UploadedFile::fake()->image('guru.jpg'),
        ])
        ->assertRedirect(route('admin.gurus.index'));

    $guru = Guru::where('name', 'Ustadzah Fatimah')->first();

    expect($guru)->not->toBeNull()
        ->and($guru->jabatan)->toBe('Guru Bahasa Arab')
        ->and($guru->jenis_kelamin)->toBe('P')
        ->and($guru->urutan)->toBe(3)
        ->and($guru->is_active)->toBeTrue();

    Storage::disk('public')->assertExists($guru->foto);
});

test('nama dan alamat guru wajib diisi', function () {
    $this->actingAs(adminGuru())
        ->post(route('admin.gurus.store'), [])
        ->assertSessionHasErrors(['name', 'alamat']);
});

test('admin bisa memperbarui profil guru dan mengganti foto', function () {
    Storage::fake('public');

    $guru = buatGuru(['foto' => 'konten/guru/lama.jpg']);
    Storage::disk('public')->put('konten/guru/lama.jpg', 'file lama');

    $this->actingAs(adminGuru())
        ->put(route('admin.gurus.update', $guru), [
            'name' => 'Ustadz Ahmad Fauzi',
            'alamat' => 'Jl. Pesantren No. 1',
            'is_active' => '1',
            'foto' => UploadedFile::fake()->image('baru.jpg'),
        ])
        ->assertRedirect(route('admin.gurus.index'));

    $guru->refresh();

    expect($guru->name)->toBe('Ustadz Ahmad Fauzi')
        ->and($guru->foto)->not->toBe('konten/guru/lama.jpg');

    Storage::disk('public')->assertMissing('konten/guru/lama.jpg');
});

test('admin bisa menghapus profil guru beserta fotonya', function () {
    Storage::fake('public');

    $guru = buatGuru(['foto' => 'konten/guru/hapus.jpg']);
    Storage::disk('public')->put('konten/guru/hapus.jpg', 'file');

    $this->actingAs(adminGuru())
        ->delete(route('admin.gurus.destroy', $guru))
        ->assertRedirect(route('admin.gurus.index'));

    expect(Guru::find($guru->id))->toBeNull();
    Storage::disk('public')->assertMissing('konten/guru/hapus.jpg');
});

test('nama guru disanitasi dari tag HTML', function () {
    buatGuru(['name' => 'Ustadz <b>Bold</b>']);

    expect(Guru::first()->name)->toBe('Ustadz Bold');
});

test('tabel profil guru bisa dicari dan difilter jenis kelamin', function () {
    buatGuru(['name' => 'Ustadz Hasan', 'jenis_kelamin' => 'L']);
    buatGuru(['name' => 'Ustadzah Aisyah', 'jenis_kelamin' => 'P']);

    Livewire::actingAs(adminGuru())
        ->test(GurusTable::class)
        ->set('search', 'Hasan')
        ->assertSee('Ustadz Hasan')
        ->assertDontSee('Ustadzah Aisyah')
        ->set('search', '')
        ->set('jenisKelamin', 'P')
        ->assertSee('Ustadzah Aisyah')
        ->assertDontSee('Ustadz Hasan');
});

test('hapus dari tabel profil guru menghapus data', function () {
    $guru = buatGuru();

    Livewire::actingAs(adminGuru())
        ->test(GurusTable::class)
        ->call('confirmDelete', $guru->id)
        ->assertSet('deleteId', $guru->id)
        ->call('deleteConfirmed');

    expect(Guru::find($guru->id))->toBeNull();
});

test('form guru menyediakan panduan ukuran dan pratinjau foto lingkaran', function () {
    $guru = buatGuru(['foto' => 'gurus/foto-lama.webp']);
    $this->actingAs(adminGuru());
    foreach ([route('admin.gurus.create'), route('admin.gurus.edit', $guru)] as $url) {
        $this->get($url)->assertSuccessful()
            ->assertSee('800 × 800 piksel')
            ->assertSee('data-photo-preview', false)
            ->assertSee('object-cover object-center shadow-md', false)
            ->assertSee('template-foto-guru-800x800.svg', false)
            ->assertSee('name="foto"', false);
    }
    $this->get(route('admin.gurus.edit', $guru))->assertSee(Storage::url($guru->foto), false);
    $svg = file_get_contents(public_path('images/template-foto-guru.svg'));
    expect($svg)->toContain('width="800" height="800"')->toContain('viewBox="0 0 800 800"');
});
