<?php

use App\Livewire\Admin\CarouselsTable;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function adminCarousel(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.carousels.index'))->assertRedirect(route('login'));
});

test('user non-admin tidak boleh mengakses carousel', function () {
    $user = User::factory()->create(['role' => 'maputra']);

    $this->actingAs($user)->get(route('admin.carousels.index'))->assertForbidden();
});

test('admin bisa melihat daftar carousel', function () {
    Carousel::factory()->create(['judul' => 'Selamat Datang']);

    $this->actingAs(adminCarousel())
        ->get(route('admin.carousels.index'))
        ->assertSuccessful()
        ->assertSee('Selamat Datang');
});

test('admin bisa menambah slide carousel beserta gambar', function () {
    Storage::fake('public');

    $this->actingAs(adminCarousel())
        ->post(route('admin.carousels.store'), [
            'judul' => 'Pendaftaran Dibuka',
            'deskripsi' => 'Segera daftarkan putra Anda',
            'link_text' => 'Daftar Sekarang',
            'link_url' => '/pendaftaran',
            'urutan' => 1,
            'is_active' => '1',
            'gambar' => UploadedFile::fake()->image('slide.jpg'),
        ])
        ->assertRedirect(route('admin.carousels.index'));

    $carousel = Carousel::where('judul', 'Pendaftaran Dibuka')->first();

    expect($carousel)->not->toBeNull()
        ->and($carousel->link_url)->toBe('/pendaftaran')
        ->and($carousel->urutan)->toBe(1)
        ->and($carousel->is_active)->toBeTrue()
        ->and($carousel->punya_tombol)->toBeTrue()
        ->and($carousel->gambar)->toStartWith('konten/carousel/');

    Storage::disk('public')->assertExists($carousel->gambar);
});

test('gambar carousel wajib diunggah', function () {
    $this->actingAs(adminCarousel())
        ->post(route('admin.carousels.store'), ['judul' => 'Tanpa Gambar'])
        ->assertSessionHasErrors(['gambar']);
});

test('admin bisa memperbarui slide dan mengganti gambar', function () {
    Storage::fake('public');

    $carousel = Carousel::factory()->create(['gambar' => 'konten/carousel/lama.jpg']);
    Storage::disk('public')->put('konten/carousel/lama.jpg', 'file lama');

    $this->actingAs(adminCarousel())
        ->put(route('admin.carousels.update', $carousel), [
            'judul' => 'Judul Baru',
            'is_active' => '1',
            'gambar' => UploadedFile::fake()->image('baru.jpg'),
        ])
        ->assertRedirect(route('admin.carousels.index'));

    $carousel->refresh();

    expect($carousel->judul)->toBe('Judul Baru')
        ->and($carousel->gambar)->not->toBe('konten/carousel/lama.jpg');

    Storage::disk('public')->assertMissing('konten/carousel/lama.jpg');
});

test('memperbarui slide tanpa gambar baru tetap memakai gambar lama', function () {
    Storage::fake('public');

    $carousel = Carousel::factory()->create(['gambar' => 'konten/carousel/tetap.jpg']);
    Storage::disk('public')->put('konten/carousel/tetap.jpg', 'file');

    $this->actingAs(adminCarousel())
        ->put(route('admin.carousels.update', $carousel), [
            'judul' => 'Judul Diubah',
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.carousels.index'));

    expect($carousel->refresh()->gambar)->toBe('konten/carousel/tetap.jpg');
    Storage::disk('public')->assertExists('konten/carousel/tetap.jpg');
});

test('admin bisa menghapus slide beserta gambarnya', function () {
    Storage::fake('public');

    $carousel = Carousel::factory()->create(['gambar' => 'konten/carousel/hapus.jpg']);
    Storage::disk('public')->put('konten/carousel/hapus.jpg', 'file');

    $this->actingAs(adminCarousel())
        ->delete(route('admin.carousels.destroy', $carousel))
        ->assertRedirect(route('admin.carousels.index'));

    expect(Carousel::find($carousel->id))->toBeNull();
    Storage::disk('public')->assertMissing('konten/carousel/hapus.jpg');
});

test('tautan berbahaya pada slide tidak disimpan', function () {
    $carousel = Carousel::create([
        'judul' => 'Slide Berbahaya',
        'gambar' => 'konten/carousel/x.jpg',
        'link_text' => 'Klik',
        'link_url' => 'javascript:alert(1)',
    ]);

    expect($carousel->link_url)->toBeNull()
        ->and($carousel->punya_tombol)->toBeFalse();
});

test('tautan relatif pada slide tetap disimpan', function () {
    $carousel = Carousel::create([
        'judul' => 'Slide Relatif',
        'gambar' => 'konten/carousel/x.jpg',
        'link_text' => 'Daftar',
        'link_url' => '/pendaftaran',
    ]);

    expect($carousel->link_url)->toBe('/pendaftaran')
        ->and($carousel->punya_tombol)->toBeTrue();
});

test('teks slide disanitasi dari tag HTML', function () {
    $carousel = Carousel::create([
        'judul' => 'Judul <script>alert(1)</script>Aman',
        'deskripsi' => '<b>Deskripsi</b> penting',
        'gambar' => 'konten/carousel/x.jpg',
    ]);

    expect($carousel->judul)->toBe('Judul alert(1)Aman')
        ->and($carousel->deskripsi)->toBe('Deskripsi penting');
});

test('tabel carousel bisa dicari', function () {
    Carousel::factory()->create(['judul' => 'Pendaftaran Santri Baru']);
    Carousel::factory()->create(['judul' => 'Haflah Akhirussanah']);

    Livewire::actingAs(adminCarousel())
        ->test(CarouselsTable::class)
        ->set('search', 'Haflah')
        ->assertSee('Haflah Akhirussanah')
        ->assertDontSee('Pendaftaran Santri Baru');
});

test('urutan slide bisa dinaikkan dan diturunkan', function () {
    $atas = Carousel::factory()->create(['judul' => 'Slide Atas', 'urutan' => 1]);
    $bawah = Carousel::factory()->create(['judul' => 'Slide Bawah', 'urutan' => 2]);

    Livewire::actingAs(adminCarousel())
        ->test(CarouselsTable::class)
        ->call('pindah', $bawah->id, 'naik');

    expect($atas->refresh()->urutan)->toBe(2)
        ->and($bawah->refresh()->urutan)->toBe(1);
});

test('hapus dari tabel carousel menghapus data', function () {
    $carousel = Carousel::factory()->create();

    Livewire::actingAs(adminCarousel())
        ->test(CarouselsTable::class)
        ->call('confirmDelete', $carousel->id)
        ->assertSet('deleteId', $carousel->id)
        ->call('deleteConfirmed');

    expect(Carousel::find($carousel->id))->toBeNull();
});
