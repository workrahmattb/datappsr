<?php

use App\Livewire\Admin\BeritasTable;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function adminBerita(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.beritas.index'))->assertRedirect(route('login'));
});

test('user non-admin tidak boleh mengakses berita', function () {
    $user = User::factory()->create(['role' => 'mtsputra']);

    $this->actingAs($user)->get(route('admin.beritas.index'))->assertForbidden();
});

test('admin bisa melihat daftar berita', function () {
    Berita::factory()->create(['judul' => 'Berita Pertama']);

    $this->actingAs(adminBerita())
        ->get(route('admin.beritas.index'))
        ->assertSuccessful()
        ->assertSee('Berita Pertama');
});

test('admin bisa menambah berita beserta gambar', function () {
    Storage::fake('public');

    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [
            'judul' => 'Kegiatan Haflah Akhirussanah',
            'kategori' => 'Kegiatan',
            'ringkasan' => 'Ringkasan kegiatan',
            'isi' => 'Isi berita lengkap',
            'penulis' => 'Admin PPSR',
            'status' => 'published',
            'gambar' => UploadedFile::fake()->image('kegiatan.jpg', 1200, 675),
        ])
        ->assertRedirect(route('admin.beritas.index'));

    $berita = Berita::where('judul', 'Kegiatan Haflah Akhirussanah')->first();

    expect($berita)->not->toBeNull()
        ->and($berita->slug)->toBe('kegiatan-haflah-akhirussanah')
        ->and($berita->status)->toBe('published')
        ->and($berita->published_at)->not->toBeNull();

    Storage::disk('public')->assertExists($berita->gambar);
});

test('judul dan isi wajib diisi', function () {
    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [])
        ->assertSessionHasErrors(['judul', 'isi']);
});

test('admin bisa memperbarui berita dan mengganti gambar', function () {
    Storage::fake('public');

    $berita = Berita::factory()->create(['gambar' => 'konten/berita/lama.jpg']);
    Storage::disk('public')->put('konten/berita/lama.jpg', 'file lama');

    $this->actingAs(adminBerita())
        ->put(route('admin.beritas.update', $berita), [
            'judul' => 'Judul Diperbarui',
            'isi' => 'Isi diperbarui',
            'status' => 'draft',
            'gambar' => UploadedFile::fake()->image('baru.jpg', 1200, 675),
        ])
        ->assertRedirect(route('admin.beritas.index'));

    $berita->refresh();

    expect($berita->judul)->toBe('Judul Diperbarui')
        ->and($berita->gambar)->not->toBe('konten/berita/lama.jpg');

    Storage::disk('public')->assertMissing('konten/berita/lama.jpg');
});

test('admin bisa menghapus berita beserta gambarnya', function () {
    Storage::fake('public');

    $berita = Berita::factory()->create(['gambar' => 'konten/berita/hapus.jpg']);
    Storage::disk('public')->put('konten/berita/hapus.jpg', 'file');

    $this->actingAs(adminBerita())
        ->delete(route('admin.beritas.destroy', $berita))
        ->assertRedirect(route('admin.beritas.index'));

    expect(Berita::find($berita->id))->toBeNull();
    Storage::disk('public')->assertMissing('konten/berita/hapus.jpg');
});

test('judul berita disanitasi dari tag HTML', function () {
    Berita::create([
        'judul' => 'Judul <script>alert(1)</script>Aman',
        'isi' => 'Isi berita',
        'status' => 'draft',
    ]);

    expect(Berita::first()->judul)->toBe('Judul alert(1)Aman');
});

test('isi berita menyimpan HTML yang diizinkan dan membuang yang berbahaya', function () {
    Berita::create([
        'judul' => 'Berita HTML',
        'isi' => '<h2>Sub Judul</h2><p>Halo <strong>Bold</strong> dan <em>miring</em></p>'
            .'<ul><li>satu</li></ul>'
            .'<script>alert(1)</script>'
            .'<img src="https://contoh.test/g.jpg" onerror="alert(2)">'
            .'<a href="javascript:alert(3)">klik</a>',
        'status' => 'draft',
    ]);

    $isi = Berita::first()->isi;

    expect($isi)
        ->toContain('<h2>Sub Judul</h2>')
        ->toContain('<strong>Bold</strong>')
        ->toContain('<em>miring</em>')
        ->toContain('<li>satu</li>')
        ->not->toContain('<script')
        ->not->toContain('onerror')
        ->not->toContain('javascript:');
});

test('isi berita tersedia sebagai HTML yang sudah aman', function () {
    $berita = Berita::factory()->create([
        'isi' => '<p>Aman</p><script>alert(1)</script>',
    ]);

    expect($berita->isi_html)->toBe('<p>Aman</p>');
});

test('ringkasan singkat dibuat dari isi berita tanpa tag', function () {
    $berita = Berita::factory()->create([
        'ringkasan' => null,
        'isi' => '<p>'.str_repeat('Kata contoh ', 20).'</p>',
    ]);

    $ringkasan = $berita->ringkasan_singkat;

    expect($ringkasan)
        ->not->toContain('<p>')
        ->toContain('Kata contoh')
        ->toEndWith('...');
});

test('admin bisa mengunggah gambar untuk isi berita', function () {
    Storage::fake('public');

    $response = $this->actingAs(adminBerita())
        ->post(route('admin.beritas.upload-gambar'), [
            'gambar' => UploadedFile::fake()->image('isi.jpg'),
        ]);

    $response->assertSuccessful()->assertJsonStructure(['url']);

    $url = (string) $response->json('url');

    expect($url)->toContain('/storage/konten/berita/isi/');

    Storage::disk('public')->assertExists(
        'konten/berita/isi/'.basename((string) parse_url($url, PHP_URL_PATH))
    );
});

test('user non-admin tidak boleh mengunggah gambar isi berita', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'mtsputra']);

    $this->actingAs($user)
        ->post(route('admin.beritas.upload-gambar'), [
            'gambar' => UploadedFile::fake()->image('isi.jpg'),
        ])
        ->assertForbidden();
});

test('unggahan gambar isi berita harus berupa gambar', function () {
    Storage::fake('public');

    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.upload-gambar'), [
            'gambar' => UploadedFile::fake()->create('dokumen.pdf', 10, 'application/pdf'),
        ])
        ->assertSessionHasErrors('gambar');
});

test('thumbnail berita sesuai ketentuan diterima', function () {
    Storage::fake('public');

    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [
            'judul' => 'Thumbnail Sesuai',
            'isi' => 'Isi berita',
            'status' => 'draft',
            'gambar' => UploadedFile::fake()->image('thumb.jpg', 1200, 675),
        ])
        ->assertRedirect(route('admin.beritas.index'));

    expect(Berita::where('judul', 'Thumbnail Sesuai')->exists())->toBeTrue();
});

test('thumbnail berita berukuran terlalu kecil ditolak', function () {
    Storage::fake('public');

    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [
            'judul' => 'Thumbnail Kecil',
            'isi' => 'Isi berita',
            'status' => 'draft',
            'gambar' => UploadedFile::fake()->image('kecil.jpg', 400, 300),
        ])
        ->assertSessionHasErrors(['gambar']);

    expect(Berita::where('judul', 'Thumbnail Kecil')->exists())->toBeFalse();
});

test('thumbnail berita berbentuk portrait ditolak', function () {
    Storage::fake('public');

    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [
            'judul' => 'Thumbnail Portrait',
            'isi' => 'Isi berita',
            'status' => 'draft',
            'gambar' => UploadedFile::fake()->image('portrait.jpg', 900, 1200),
        ])
        ->assertSessionHasErrors(['gambar']);

    expect(Berita::where('judul', 'Thumbnail Portrait')->exists())->toBeFalse();
});

test('halaman tambah dan edit berita menampilkan editor isi berita', function () {
    $berita = Berita::factory()->create(['isi' => '<p>Isi lama</p>']);

    $this->actingAs(adminBerita())
        ->get(route('admin.beritas.create'))
        ->assertSuccessful()
        ->assertSeeHtml('id="isi-editor"')
        ->assertSeeHtml('name="isi"')
        ->assertSee('quill@2')
        ->assertSee('dist/quill.js')
        ->assertSee('beritas\/upload-gambar');

    $this->actingAs(adminBerita())
        ->get(route('admin.beritas.edit', $berita))
        ->assertSuccessful()
        ->assertSeeHtml('id="isi-editor"')
        ->assertSee('Isi lama');
});

test('isi berita berupa HTML tersimpan dari form admin', function () {
    $this->actingAs(adminBerita())
        ->post(route('admin.beritas.store'), [
            'judul' => 'Berita Dengan Format',
            'isi' => '<p>Paragraf <strong>tebal</strong></p><script>alert(1)</script>',
            'status' => 'draft',
        ])
        ->assertRedirect(route('admin.beritas.index'));

    $isi = Berita::where('judul', 'Berita Dengan Format')->first()->isi;

    expect($isi)->toBe('<p>Paragraf <strong>tebal</strong></p>');
});

test('slug duplikat dibuat unik otomatis', function () {
    Berita::create(['judul' => 'Judul Sama', 'isi' => 'a', 'status' => 'draft']);
    Berita::create(['judul' => 'Judul Sama', 'isi' => 'b', 'status' => 'draft']);

    expect(Berita::orderBy('id')->pluck('slug')->all())->toBe(['judul-sama', 'judul-sama-1']);
});

test('tabel berita bisa dicari dan difilter status', function () {
    Berita::factory()->create(['judul' => 'Kegiatan Santri', 'status' => 'published']);
    Berita::factory()->create(['judul' => 'Pengumuman Libur', 'status' => 'draft']);

    Livewire::actingAs(adminBerita())
        ->test(BeritasTable::class)
        ->set('search', 'Kegiatan')
        ->assertSee('Kegiatan Santri')
        ->assertDontSee('Pengumuman Libur')
        ->set('search', '')
        ->set('status', 'draft')
        ->assertSee('Pengumuman Libur')
        ->assertDontSee('Kegiatan Santri');
});

test('hapus dari tabel berita menghapus data', function () {
    $berita = Berita::factory()->create();

    Livewire::actingAs(adminBerita())
        ->test(BeritasTable::class)
        ->call('confirmDelete', $berita->id)
        ->assertSet('deleteId', $berita->id)
        ->call('deleteConfirmed');

    expect(Berita::find($berita->id))->toBeNull();
});
