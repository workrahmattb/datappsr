<?php

use App\Models\Berita;
use App\Models\Carousel;
use App\Models\Fasilitas;
use App\Models\FasilitasFoto;
use App\Models\Guru;
use App\Models\Kontak;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

/**
 * @param  array<string, mixed>  $attributes
 */
function buatGuruSite(array $attributes = []): Guru
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

test('navbar situs memuat tautan berita fasilitas guru dan kontak', function () {
    $response = $this->get(route('home'))->assertSuccessful();

    $response->assertSeeHtml('href="'.route('berita.index').'"')
        ->assertSeeHtml('href="'.route('fasilitas.index').'"')
        ->assertSeeHtml('href="'.route('guru.index').'"')
        ->assertSeeHtml('href="'.route('kontak.index').'"');
});

test('halaman utama menampilkan carousel yang aktif saja', function () {
    $slide = Carousel::factory()->create(['judul' => 'Selamat Datang di PPSR', 'urutan' => 1]);
    Carousel::factory()->nonaktif()->create(['judul' => 'Slide Nonaktif']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Selamat Datang di PPSR')
        ->assertDontSee('Slide Nonaktif')
        ->assertSeeHtml(Storage::url($slide->gambar));
});

test('halaman utama memakai hero bawaan bila belum ada carousel', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee("Pondok Pesantren Syafa'aturrasul")
        ->assertSee('Daftar Santri Baru');
});

test('halaman utama menampilkan berita terbaru yang sudah diterbitkan', function () {
    Berita::factory()->published()->create(['judul' => 'Pengumuman Penerimaan Santri Baru']);
    Berita::factory()->create(['judul' => 'Draft Berita Rahasia']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Pengumuman Penerimaan Santri Baru')
        ->assertDontSee('Draft Berita Rahasia');
});

test('halaman utama menampilkan fasilitas dan guru yang aktif saja', function () {
    Fasilitas::factory()->create(['nama' => 'Asrama Putra']);
    Fasilitas::factory()->nonaktif()->create(['nama' => 'Gedung Nonaktif']);
    buatGuruSite(['name' => 'Ustadz Ahmad Fauzi']);
    buatGuruSite(['name' => 'Guru Nonaktif', 'is_active' => false]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Asrama Putra')
        ->assertDontSee('Gedung Nonaktif')
        ->assertSee('Ustadz Ahmad Fauzi')
        ->assertDontSee('Guru Nonaktif');
});

test('halaman utama menampilkan kontak lembaga dan kontak person aktif', function () {
    Setting::set('kontak_alamat', 'Jl. Pesantren No. 1, Kuantan Singingi');
    Kontak::factory()->create(['nama' => 'Ustadz Kontak PSB', 'unit' => 'PSB']);
    Kontak::factory()->nonaktif()->create(['nama' => 'Kontak Nonaktif']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Hubungi Kami')
        ->assertSee('Jl. Pesantren No. 1, Kuantan Singingi')
        ->assertSee('Ustadz Kontak PSB')
        ->assertDontSee('Kontak Nonaktif');
});

test('halaman daftar berita hanya menampilkan berita terbit', function () {
    Berita::factory()->published()->create(['judul' => 'Berita Terbit Pertama']);
    Berita::factory()->create(['judul' => 'Berita Draft Internal']);

    $this->get(route('berita.index'))
        ->assertSuccessful()
        ->assertSee('Berita Terbit Pertama')
        ->assertDontSee('Berita Draft Internal');
});

test('halaman daftar berita menampilkan pesan kosong bila belum ada berita', function () {
    $this->get(route('berita.index'))
        ->assertSuccessful()
        ->assertSee('Belum ada berita yang diterbitkan');
});

test('detail berita menampilkan isi yang sudah disanitasi', function () {
    $berita = Berita::factory()->published()->create([
        'judul' => 'Kegiatan Haflah Akhirussanah',
        'isi' => '<p>Acara berlangsung meriah.</p><script>alert("xss")</script>',
    ]);

    $this->get(route('berita.show', $berita->slug))
        ->assertSuccessful()
        ->assertSee('Kegiatan Haflah Akhirussanah')
        ->assertSeeHtml('<p>Acara berlangsung meriah.</p>')
        ->assertDontSee('alert("xss")', false);
});

test('detail berita draft tidak dapat diakses publik', function () {
    $berita = Berita::factory()->create(['judul' => 'Berita Draft Internal']);

    $this->get(route('berita.show', $berita->slug))->assertNotFound();
});

test('detail berita dengan slug tidak dikenal menghasilkan 404', function () {
    $this->get(route('berita.show', 'slug-tidak-ada'))->assertNotFound();
});

test('halaman fasilitas menampilkan fasilitas aktif beserta galeri fotonya', function () {
    $fasilitas = Fasilitas::factory()->create(['nama' => 'Masjid Utama', 'kategori' => 'Ibadah']);
    FasilitasFoto::create(['fasilitas_id' => $fasilitas->id, 'path' => 'konten/fasilitas/masjid-1.jpg', 'urutan' => 0]);
    FasilitasFoto::create(['fasilitas_id' => $fasilitas->id, 'path' => 'konten/fasilitas/masjid-2.jpg', 'urutan' => 1]);
    Fasilitas::factory()->nonaktif()->create(['nama' => 'Fasilitas Nonaktif']);

    $this->get(route('fasilitas.index'))
        ->assertSuccessful()
        ->assertSee('Masjid Utama')
        ->assertSee('Ibadah')
        ->assertSeeHtml(Storage::url('konten/fasilitas/masjid-2.jpg'))
        ->assertDontSee('Fasilitas Nonaktif');
});

test('halaman fasilitas menampilkan pesan kosong bila belum ada data', function () {
    $this->get(route('fasilitas.index'))
        ->assertSuccessful()
        ->assertSee('Belum ada data fasilitas');
});

test('halaman guru menampilkan profil guru aktif saja', function () {
    buatGuruSite(['name' => 'Ustadzah Fatimah', 'jabatan' => 'Guru Bahasa Arab', 'pendidikan' => 'S1 PBA']);
    buatGuruSite(['name' => 'Guru Tidak Aktif', 'is_active' => false]);

    $this->get(route('guru.index'))
        ->assertSuccessful()
        ->assertSee('Ustadzah Fatimah')
        ->assertSee('Guru Bahasa Arab')
        ->assertSee('S1 PBA')
        ->assertDontSee('Guru Tidak Aktif');
});

test('halaman guru menampilkan pesan kosong bila belum ada data', function () {
    $this->get(route('guru.index'))
        ->assertSuccessful()
        ->assertSee('Belum ada data profil guru');
});

test('halaman kontak menampilkan informasi lembaga dan kontak person aktif', function () {
    Setting::set('kontak_alamat', 'Jl. Pesantren No. 1, Kuantan Singingi');
    Setting::set('kontak_email', 'info@ppsr.local');
    Setting::set('kontak_jam_layanan', 'Senin - Sabtu, 08.00 - 15.00');
    Kontak::factory()->create(['nama' => 'Ustadz Kontak', 'unit' => 'PSB', 'whatsapp' => '081234567890']);
    Kontak::factory()->nonaktif()->create(['nama' => 'Kontak Nonaktif']);

    $this->get(route('kontak.index'))
        ->assertSuccessful()
        ->assertSee('Jl. Pesantren No. 1, Kuantan Singingi')
        ->assertSee('info@ppsr.local')
        ->assertSee('Senin - Sabtu, 08.00 - 15.00')
        ->assertSee('Ustadz Kontak')
        ->assertSeeHtml('https://wa.me/6281234567890')
        ->assertDontSee('Kontak Nonaktif');
});

test('halaman kontak menampilkan peta dari kode embed yang aman', function () {
    Setting::set('kontak_maps_embed', '<iframe src="https://www.google.com/maps/embed?pb=abc"></iframe>');

    $this->get(route('kontak.index'))
        ->assertSuccessful()
        ->assertSeeHtml('src="https://www.google.com/maps/embed?pb=abc"');
});

test('kode embed peta yang tidak aman tidak dirender', function () {
    Setting::set('kontak_maps_embed', '<iframe src="javascript:alert(1)"></iframe>');

    $this->get(route('kontak.index'))
        ->assertSuccessful()
        ->assertDontSee('javascript:alert', false)
        ->assertDontSee('Lokasi');
});

test('foto profil guru memakai lingkaran putih dengan shadow', function () {
    buatGuruSite(['name' => 'Guru Foto Putih', 'foto' => 'images/guru-test.webp']);
    foreach (['home', 'guru.index'] as $route) {
        $this->get(route($route))->assertSuccessful()
            ->assertSee('border-4 border-white bg-white shadow-md', false)
            ->assertDontSee('border-2 border-green-100 dark:border-gray-600', false);
    }
});
