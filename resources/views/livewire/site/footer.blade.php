<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-4 gap-8 mb-12">
            <div>
                <h2 class="text-white font-bold mb-4">PPSR 2026</h2>
                <p class="text-sm">Pondok Pesantren Syafa'aturrasul — Kuantan Singingi, Riau. Mendidik generasi Qur'ani
                    yang berilmu, berakhlak, dan mandiri.</p>
            </div>

            <div>
                <h2 class="text-white font-bold mb-4">Tautan</h2>
                <ul class="space-y-2 text-sm">
                    @foreach ($menu as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" wire:navigate
                                wire:key="footer-tautan-{{ $item['route'] }}"
                                class="hover:text-green-400 transition">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="text-white font-bold mb-4">Layanan</h2>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('pendaftaran') }}" wire:navigate class="hover:text-green-400 transition">Formulir
                            Pendaftaran</a>
                    </li>
                    <li>
                        <a href="{{ route('psb') }}" wire:navigate class="hover:text-green-400 transition">Cari Data
                            Santri</a>
                    </li>
                    <li>
                        <a href="{{ route('foto.index') }}" wire:navigate class="hover:text-green-400 transition">Galeri
                            Foto</a>
                    </li>
                    <li>
                        <a href="{{ route('uangmasuk.index') }}" wire:navigate class="hover:text-green-400 transition">Uang
                            Masuk</a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-white font-bold mb-4">Kontak</h2>
                <ul class="space-y-2 text-sm">
                    <li>Email: {{ filled($email) ? $email : 'syafaaturrasultatausaha@gmail.com' }}</li>
                    <li>Telp:
                        {{ filled($telepon) ? $telepon : (filled($whatsapp) ? $whatsapp : '+6285259875754') }}
                    </li>
                    <li>{{ filled($alamat) ? $alamat : 'KUANTAN SINGINGI, RIAU' }}</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm">&copy; {{ date('Y') }} PPSR. All rights reserved.</p>
                <div class="flex gap-4 text-sm">
                    <a href="{{ route('kontak.index') }}" wire:navigate class="hover:text-green-400 transition">Kontak</a>
                    <a href="https://www.syafaaturrasul.com" target="_blank" rel="noopener"
                        class="hover:text-green-400 transition">Website Pondok</a>
                </div>
            </div>
        </div>
    </div>
</footer>
