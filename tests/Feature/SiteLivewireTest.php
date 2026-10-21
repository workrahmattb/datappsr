<?php

use App\Livewire\Site\BeritaIndex;
use App\Livewire\Site\Carousel;
use App\Livewire\Site\Footer;
use App\Livewire\Site\Home;
use App\Livewire\Site\Navbar;
use App\Livewire\Site\WhatsappButton;
use App\Models\Berita;
use App\Models\Carousel as CarouselModel;
use App\Models\Setting;
use Livewire\Livewire;

test('semua halaman publik memakai navbar & footer sebagai komponen livewire', function (string $routeName) {
    $this->get(route($routeName))
        ->assertSuccessful()
        ->assertSeeLivewire(Navbar::class)
        ->assertSeeLivewire(Footer::class);
})->with([
    'beranda' => 'home',
    'berita' => 'berita.index',
    'fasilitas' => 'fasilitas.index',
    'guru' => 'guru.index',
    'kontak' => 'kontak.index',
    'psb' => 'psb',
]);

test('halaman detail berita memakai navbar & footer livewire', function () {
    $berita = Berita::factory()->published()->create();

    $this->get(route('berita.show', $berita->slug))
        ->assertSuccessful()
        ->assertSeeLivewire(Navbar::class)
        ->assertSeeLivewire(Footer::class);
});

test('halaman utama dirender sebagai komponen livewire', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeLivewire(Home::class);
});

test('tautan internal memakai wire:navigate (SPA)', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeHtml('href="'.route('berita.index').'" wire:navigate')
        ->assertSeeHtml('href="'.route('fasilitas.index').'" wire:navigate')
        ->assertSeeHtml('href="'.route('guru.index').'" wire:navigate')
        ->assertSeeHtml('href="'.route('kontak.index').'" wire:navigate')
        ->assertSeeHtml('href="'.route('pendaftaran').'" wire:navigate');
});

test('menu navbar yang aktif ditandai aria-current', function () {
    $html = $this->get(route('guru.index'))->assertSuccessful()->getContent();

    expect($html)
        ->toMatch('/<a href="[^"]*\/guru"[^>]*aria-current="page"/')
        ->not->toMatch('/<a href="[^"]*\/berita"[^>]*aria-current="page"/');
});

test('menu mobile navbar dibuka & ditutup lewat aksi livewire', function () {
    Livewire::test(Navbar::class)
        ->assertSet('menuTerbuka', false)
        ->assertDontSee('PSB & Cari Data')
        ->call('toggleMenu')
        ->assertSet('menuTerbuka', true)
        ->assertSee('PSB & Cari Data')
        ->call('toggleMenu')
        ->assertSet('menuTerbuka', false);
});

test('footer menampilkan kontak lembaga dari pengaturan', function () {
    Setting::set('kontak_alamat', 'Jl. Pesantren No. 1');
    Setting::set('kontak_email', 'info@ppsr.local');

    Livewire::test(Footer::class)
        ->assertSee('Jl. Pesantren No. 1')
        ->assertSee('info@ppsr.local')
        ->assertSeeHtml('href="'.route('berita.index').'" wire:navigate');
});

test('halaman utama menampilkan komponen carousel bila ada slide', function () {
    CarouselModel::factory()->create(['judul' => 'Slide Utama PPSR']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeLivewire(Carousel::class)
        ->assertSee('Slide Utama PPSR');
});

test('carousel memutar slide dan berputar kembali ke awal', function () {
    CarouselModel::factory()->count(3)->create();

    Livewire::test(Carousel::class)
        ->assertSet('aktif', 0)
        ->assertSeeHtml('wire:poll.6s="berikut"')
        ->call('berikut')->assertSet('aktif', 1)
        ->call('berikut')->assertSet('aktif', 2)
        ->call('berikut')->assertSet('aktif', 0)
        ->call('sebelumnya')->assertSet('aktif', 2)
        ->call('keSlide', 1)->assertSet('aktif', 1);
});

test('carousel tidak berputar sendiri bila hanya ada satu slide', function () {
    CarouselModel::factory()->create();

    Livewire::test(Carousel::class)
        ->assertSet('aktif', 0)
        ->assertDontSeeHtml('wire:poll.6s="berikut"')
        ->call('berikut')->assertSet('aktif', 0)
        ->call('sebelumnya')->assertSet('aktif', 0);
});

test('carousel hanya memuat slide yang aktif', function () {
    CarouselModel::factory()->create(['judul' => 'Slide Tampil']);
    CarouselModel::factory()->nonaktif()->create(['judul' => 'Slide Tersembunyi']);

    Livewire::test(Carousel::class)
        ->assertSee('Slide Tampil')
        ->assertDontSee('Slide Tersembunyi')
        ->assertDontSeeHtml('wire:poll.6s="berikut"');
});

test('carousel memakai rasio hero yang konsisten di semua slide', function () {
    CarouselModel::factory()->count(2)->create();

    Livewire::test(Carousel::class)
        ->assertSeeHtml('aspect-[3/2] sm:aspect-[2/1] lg:aspect-[21/9]')
        ->assertSeeHtml('object-cover object-center')
        ->assertDontSeeHtml('h-[380px]')
        ->assertDontSeeHtml('md:h-[520px]');
});

test('kartu teks carousel hanya tampil bila slide punya teks atau tombol', function () {
    CarouselModel::factory()->create(['judul' => null, 'deskripsi' => null, 'link_url' => null, 'link_text' => null]);

    Livewire::test(Carousel::class)
        ->assertDontSeeHtml('data-slide-caption');

    CarouselModel::query()->delete();
    CarouselModel::factory()->create(['judul' => 'Pengumuman Penting']);

    Livewire::test(Carousel::class)
        ->assertSeeHtml('data-slide-caption')
        ->assertSee('Pengumuman Penting');
});

test('teks dan kontrol carousel tampil tanpa latar kaca', function () {
    CarouselModel::factory()->count(2)->create(['judul' => 'Slide Tanpa Kaca']);

    Livewire::test(Carousel::class)
        ->assertSee('Slide Tanpa Kaca')
        ->assertDontSeeHtml('backdrop-blur')
        ->assertDontSeeHtml('bg-black/30')
        ->assertDontSeeHtml('ring-white/25')
        ->assertSeeHtml('text-shadow-md');
});

test('daftar berita memakai pagination livewire tanpa reload', function () {
    Berita::factory()->published()->count(10)->create();

    Livewire::test(BeritaIndex::class)
        ->call('nextPage')
        ->assertSet('paginators.page', 2)
        ->assertStatus(200);
});

test('tombol whatsapp mengambang tampil di semua halaman publik', function (string $routeName) {
    $this->get(route($routeName))
        ->assertSuccessful()
        ->assertSeeLivewire(WhatsappButton::class)
        ->assertSeeHtml('fixed bottom-5 right-5')
        ->assertSeeHtml('Chat WhatsApp');
})->with([
    'beranda' => 'home',
    'berita' => 'berita.index',
    'fasilitas' => 'fasilitas.index',
    'guru' => 'guru.index',
    'kontak' => 'kontak.index',
    'psb' => 'psb',
]);

test('tombol whatsapp mengarah ke wa.me dengan pesan pembuka', function () {
    Setting::set('kontak_whatsapp', '');
    Setting::set('kontak_alamat', '');

    $link = 'https://wa.me/6285259875754?text='.rawurlencode(WhatsappButton::PESAN_DEFAULT);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeHtml('href="'.$link.'" target="_blank"')
        ->assertSeeHtml('rel="noopener noreferrer"')
        ->assertDontSeeHtml('href="'.$link.'" wire:navigate');
});

test('tombol whatsapp memakai nomor dari pengaturan kontak lembaga', function () {
    Setting::set('kontak_whatsapp', '085259875754');

    Livewire::test(WhatsappButton::class)
        ->assertSeeHtml('https://wa.me/6285259875754?text=');
});

test('tombol whatsapp memakai nomor default bila pengaturan masih kosong', function () {
    Setting::set('kontak_whatsapp', '');

    Livewire::test(WhatsappButton::class)
        ->assertSet('nomor', WhatsappButton::NOMOR_DEFAULT)
        ->assertSeeHtml('https://wa.me/'.WhatsappButton::NOMOR_DEFAULT.'?text=');
});
