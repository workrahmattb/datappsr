<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 dark:text-gray-300">PSB</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Cari Data &amp; Pendaftaran Santri</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Cari data santri untuk memperbarui foto, atau data pendaftaran
            untuk melanjutkan daftar ulang.</p>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <livewire:cari-siswa-table />
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-green-50 dark:bg-gray-800 p-8 rounded-xl border-l-4 border-green-600">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Butuh bantuan?</h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                Jika data tidak ditemukan atau ada kendala saat daftar ulang, silakan hubungi admin pondok melalui
                halaman <a href="{{ route('kontak.index') }}" wire:navigate
                    class="text-green-700 dark:text-green-400 underline">Kontak</a>.
            </p>
        </div>
    </section>
</div>
