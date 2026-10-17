<?php

use App\Models\User;

function adminLayoutUser(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('menu sidebar admin memakai area yang bisa discroll', function () {
    $this->actingAs(adminLayoutUser())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSeeHtml('mt-4 px-3 space-y-1 flex-1 overflow-y-auto sidebar-scroll pb-6');
});

test('sidebar admin memakai layout flex kolom setinggi layar', function () {
    $this->actingAs(adminLayoutUser())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSeeHtml('md:flex md:flex-col h-screen overflow-hidden')
        ->assertDontSeeHtml('absolute bottom-0 w-72');
});

test('info user tetap menempel di bawah sidebar', function () {
    $this->actingAs(adminLayoutUser())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSeeHtml('w-full p-4 border-t border-emerald-500 bg-emerald-800/30 shrink-0');
});

test('menu mobile juga bisa discroll', function () {
    $this->actingAs(adminLayoutUser())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSeeHtml('max-h-[70vh] overflow-y-auto sidebar-scroll');
});

test('menu konten website tampil di sidebar admin', function () {
    $this->actingAs(adminLayoutUser())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Berita')
        ->assertSee('Fasilitas')
        ->assertSee('Profil Guru')
        ->assertSee('Kontak');
});
