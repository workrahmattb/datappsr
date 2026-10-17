<?php

use App\Livewire\Admin\FasilitasTable;
use App\Models\Fasilitas;
use App\Models\FasilitasFoto;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function adminFasilitas(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.fasilitas.index'))->assertRedirect(route('login'));
});

test('user non-admin tidak boleh mengakses fasilitas', function () {
    $user = User::factory()->create(['role' => 'maputra']);

    $this->actingAs($user)->get(route('admin.fasilitas.index'))->assertForbidden();
});

test('admin bisa melihat daftar fasilitas', function () {
    Fasilitas::factory()->create(['nama' => 'Asrama Putra']);

    $this->actingAs(adminFasilitas())
        ->get(route('admin.fasilitas.index'))
        ->assertSuccessful()
        ->assertSee('Asrama Putra');
});

test('admin bisa menambah fasilitas dengan lebih dari satu foto', function () {
    Storage::fake('public');

    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), [
            'nama' => 'Masjid Utama',
            'kategori' => 'Ibadah',
            'deskripsi' => 'Masjid untuk kegiatan ibadah santri',
            'urutan' => 1,
            'is_active' => '1',
            'fotos' => [
                UploadedFile::fake()->image('masjid-1.jpg', 1200, 900),
                UploadedFile::fake()->image('masjid-2.jpg', 1200, 900),
                UploadedFile::fake()->image('masjid-3.jpg', 1200, 900),
            ],
        ])
        ->assertRedirect(route('admin.fasilitas.index'));

    $fasilitas = Fasilitas::where('nama', 'Masjid Utama')->first();

    expect($fasilitas)->not->toBeNull()
        ->and($fasilitas->kategori)->toBe('Ibadah')
        ->and($fasilitas->urutan)->toBe(1)
        ->and($fasilitas->is_active)->toBeTrue()
        ->and($fasilitas->fotos)->toHaveCount(3)
        ->and($fasilitas->gambar)->toBe($fasilitas->fotos->first()->path);

    foreach ($fasilitas->fotos as $foto) {
        Storage::disk('public')->assertExists($foto->path);
    }
});

test('nama fasilitas wajib diisi', function () {
    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), [])
        ->assertSessionHasErrors(['nama']);
});

test('fasilitas tanpa centang aktif tersimpan nonaktif', function () {
    Storage::fake('public');

    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), [
            'nama' => 'Gudang Lama',
            'fotos' => [UploadedFile::fake()->image('gudang.jpg', 1200, 900)],
        ]);

    expect(Fasilitas::where('nama', 'Gudang Lama')->first()->is_active)->toBeFalse();
});

test('admin bisa menambah foto baru tanpa menghapus foto lama', function () {
    Storage::fake('public');

    $fasilitas = Fasilitas::factory()->create(['nama' => 'Asrama Lama']);
    $fasilitas->fotos()->create(['path' => 'konten/fasilitas/lama.jpg', 'urutan' => 0]);
    Storage::disk('public')->put('konten/fasilitas/lama.jpg', 'file lama');
    $fasilitas->syncGambarUtama();

    $this->actingAs(adminFasilitas())
        ->put(route('admin.fasilitas.update', $fasilitas), [
            'nama' => 'Asrama Baru',
            'urutan' => 2,
            'is_active' => '1',
            'fotos' => [UploadedFile::fake()->image('baru.jpg', 1200, 900)],
        ])
        ->assertRedirect(route('admin.fasilitas.index'));

    $fasilitas->refresh()->load('fotos');

    expect($fasilitas->nama)->toBe('Asrama Baru')
        ->and($fasilitas->fotos)->toHaveCount(2)
        ->and($fasilitas->gambar)->toBe('konten/fasilitas/lama.jpg');

    Storage::disk('public')->assertExists('konten/fasilitas/lama.jpg');
});

test('admin bisa menghapus satu foto dan foto utama ikut diperbarui', function () {
    Storage::fake('public');

    $fasilitas = Fasilitas::factory()->create();
    $utama = $fasilitas->fotos()->create(['path' => 'konten/fasilitas/utama.jpg', 'urutan' => 0]);
    $kedua = $fasilitas->fotos()->create(['path' => 'konten/fasilitas/kedua.jpg', 'urutan' => 1]);
    Storage::disk('public')->put('konten/fasilitas/utama.jpg', 'file');
    Storage::disk('public')->put('konten/fasilitas/kedua.jpg', 'file');
    $fasilitas->syncGambarUtama();

    $this->actingAs(adminFasilitas())
        ->delete(route('admin.fasilitas.foto.destroy', [$fasilitas, $utama]))
        ->assertRedirect(route('admin.fasilitas.edit', $fasilitas));

    $fasilitas->refresh();

    expect(FasilitasFoto::find($utama->id))->toBeNull()
        ->and($fasilitas->gambar)->toBe('konten/fasilitas/kedua.jpg')
        ->and($fasilitas->fotos()->count())->toBe(1);

    Storage::disk('public')->assertMissing('konten/fasilitas/utama.jpg');
    Storage::disk('public')->assertExists('konten/fasilitas/kedua.jpg');
});

test('foto fasilitas wajib diunggah', function () {
    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), ['nama' => 'Tanpa Foto'])
        ->assertSessionHasErrors(['fotos']);
});

test('foto fasilitas berukuran terlalu kecil ditolak', function () {
    Storage::fake('public');

    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), [
            'nama' => 'Foto Kecil',
            'fotos' => [UploadedFile::fake()->image('kecil.jpg', 400, 300)],
        ])
        ->assertSessionHasErrors(['fotos.0']);

    expect(Fasilitas::where('nama', 'Foto Kecil')->exists())->toBeFalse();
});

test('foto fasilitas berbentuk portrait ditolak', function () {
    Storage::fake('public');

    $this->actingAs(adminFasilitas())
        ->post(route('admin.fasilitas.store'), [
            'nama' => 'Foto Portrait',
            'fotos' => [UploadedFile::fake()->image('portrait.jpg', 900, 1200)],
        ])
        ->assertSessionHasErrors(['fotos.0']);

    expect(Fasilitas::where('nama', 'Foto Portrait')->exists())->toBeFalse();
});

test('admin bisa menghapus fasilitas beserta semua fotonya', function () {
    Storage::fake('public');

    $fasilitas = Fasilitas::factory()->create();
    $fasilitas->fotos()->create(['path' => 'konten/fasilitas/a.jpg', 'urutan' => 0]);
    $fasilitas->fotos()->create(['path' => 'konten/fasilitas/b.jpg', 'urutan' => 1]);
    Storage::disk('public')->put('konten/fasilitas/a.jpg', 'file');
    Storage::disk('public')->put('konten/fasilitas/b.jpg', 'file');
    $fasilitas->syncGambarUtama();

    $this->actingAs(adminFasilitas())
        ->delete(route('admin.fasilitas.destroy', $fasilitas))
        ->assertRedirect(route('admin.fasilitas.index'));

    expect(Fasilitas::find($fasilitas->id))->toBeNull()
        ->and(FasilitasFoto::where('fasilitas_id', $fasilitas->id)->count())->toBe(0);

    Storage::disk('public')->assertMissing('konten/fasilitas/a.jpg');
    Storage::disk('public')->assertMissing('konten/fasilitas/b.jpg');
});

test('tabel fasilitas bisa dicari', function () {
    Fasilitas::factory()->create(['nama' => 'Asrama Putra']);
    Fasilitas::factory()->create(['nama' => 'Lab Komputer']);

    Livewire::actingAs(adminFasilitas())
        ->test(FasilitasTable::class)
        ->set('search', 'Asrama')
        ->assertSee('Asrama Putra')
        ->assertDontSee('Lab Komputer');
});

test('hapus dari tabel fasilitas menghapus data beserta fotonya', function () {
    Storage::fake('public');

    $fasilitas = Fasilitas::factory()->create();
    $fasilitas->fotos()->create(['path' => 'konten/fasilitas/tabel.jpg', 'urutan' => 0]);
    Storage::disk('public')->put('konten/fasilitas/tabel.jpg', 'file');

    Livewire::actingAs(adminFasilitas())
        ->test(FasilitasTable::class)
        ->call('confirmDelete', $fasilitas->id)
        ->assertSet('deleteId', $fasilitas->id)
        ->call('deleteConfirmed');

    expect(Fasilitas::find($fasilitas->id))->toBeNull();
    Storage::disk('public')->assertMissing('konten/fasilitas/tabel.jpg');
});
